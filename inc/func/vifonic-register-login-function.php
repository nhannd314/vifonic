<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 02/08/2017
 * Time: 4:32 CH
 */

//AJAX
$theme = wp_get_theme('vifonic');
$vifonic_version = $theme['Version'];

function ajax_register_login_init(){
	global $vifonic_version;
	wp_register_script('ajax-register-login-script', get_template_directory_uri() . '/js/ajax-register-login-script.js', array('jquery'), $vifonic_version, true);
	wp_enqueue_script('ajax-register-login-script');

	wp_localize_script( 'ajax-register-login-script', 'ajax_register_login_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxlogin', 'vifonic_ajax_login' );
	add_action( 'wp_ajax_nopriv_ajaxregister', 'vifonic_ajax_register' );
//	add_action( 'wp_ajax_nopriv_ajaxforgotpassword', 'vifonic_ajax_forgot_password' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
	add_action('init', 'ajax_register_login_init');
}

// ============================ REGISTER ============================
function vifonic_alert($text) {
	echo '<script>alert("'.$text.'")</script>';
}

// get the data received
if (!function_exists('vifonic_register_data_filter')) {
	function vifonic_register_data_filter($post){
		$arr = explode("@", $post['email'], 2);
		$username = $arr[0];
		return array(
			'user_login' => sanitize_user( $username ),
			'user_pass' => esc_attr( $post['password'] ),
			'user_email' => sanitize_email( $post['email'] ),
			'first_name' => sanitize_text_field( $post['fullname'] ),
		);
	}
}

//validate data received
if (!function_exists('vifonic_validate_data')) {
	function vifonic_validate_data($post){
		$error = array();

		$arr = explode("@", $post['email'], 2);
		$username = $arr[0];

		$password = $post['password'];
		$password_confirm = $post['password_confirm'];
		$email = $post['email'];

		if ( empty( $username ) || empty( $password ) || empty( $password_confirm ) || empty( $email ) ) {
			array_push($error, __('This field is required!', 'vifonic'));
		}
		// if ( 5 > strlen( $username ) ) {
		//     array_push($error, __('Username too short. Need at least 5 characters!', 'vifonic') );
		// }
		// if ( username_exists( $username ) ) {
		//     array_push($error, __('Username already exists!', 'vifonic'));
		// }
		// if ( ! validate_username( $username ) ) {
		//     array_push($error, __('Invalid username!', 'vifonic') );
		// }
		if ( 7 > strlen( $password ) ) {
			array_push($error, __('Passwords must be greater than 7 characters!', 'vifonic') );
		}
		if ($password != $password_confirm) {
			array_push($error, __('Password confirm incorrect!', 'vifonic') );
		}
		if ( !is_email( $email ) ) {
			array_push($error, __('Invalid email!', 'vifonic') );
		}
		if ( email_exists( $email ) ) {
			array_push($error, __('Email already exists!', 'vifonic') );
		}

		if (empty($error)) return false;
		return $error;
	}
}

//Check user exists in database
if (!function_exists('vifonic_check_user_exists')) {
	function vifonic_check_user_exists($user_id){
		global $wpdb;

		$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user_id));

		if($count == 1) { return true; } else { return false; }
	}
}

//Send Mail Active
if (!function_exists('vifonic_send_mail_active')) {
	function vifonic_send_mail_active( $user_id, $user_email, $key ) {
		// get the posted data
		$email_address = vifonic_from_email();

		// write the email content
		$header = "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=utf-8\n";
		$header .= "From:" . $email_address;

		$subject = __('Account registration successful on ', 'vifonic').get_home_url();
		$subject = "=?utf-8?B?" . base64_encode( $subject ) . "?=";
		$to      = $user_email;

		$link    = add_query_arg( array( 'key' => $key, 'user' => $user_id ), home_url( '/active-user' ) );
		$message = __('Congratulations on successfully registering your account. To activate the account please click on the following link to confirm: ', 'vifonic');
		$message .= $link;

		// send the email using wp_mail()
		return wp_mail( $to, $subject, $message, $header );
	}
}

// Insert New User
if (!function_exists('vifonic_ajax_register')) {
	function vifonic_ajax_register(){
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-register-nonce', 'security' );

		if ($error = vifonic_validate_data($_POST)) {
			echo json_encode(array('success' => false, 'error' => $error));
		}
		else {
			$new_user = vifonic_register_data_filter($_POST);
			$new_user_email = $new_user['user_email'];
			$new_user_id = wp_insert_user( $new_user );
			// On success
			if ( ! is_wp_error( $new_user_id ) ) {
				// add user meta is_active = 0
				update_user_meta($new_user_id, 'is_active', 0);

				// add active key & active time to user meta
				$time = time();
				$key = md5( $new_user_id . $time . mt_rand(1, 1000) );
				update_user_meta($new_user_id, 'active_key', $key);
				update_user_meta($new_user_id, 'active_time', $time);

				// Update PROFILE DATA
				update_user_meta($new_user_id, 'profile_mobile', $_POST['mobile']);

				// send mail to active account
				if (vifonic_send_mail_active($new_user_id, $new_user_email, $key)) {
					echo json_encode(array('success' => true, 'message' => __("Account registration successful! Please check your email to confirm your registration!", 'vifonic')));
				} else {
					echo json_encode(array('success' => false, 'error' => array(__('Can not send email. Please check your email or use another email!', 'vifonic'))));
				}
			}
			else {
				echo json_encode(array('success' => false, 'error' => array(__('Error creating new user, please try again later!', 'vifonic') )));
			}
		}
		die();
	}
}

//Activate user page
if (!function_exists('vifonic_activate_user_page')) {
	add_action( 'template_redirect', 'vifonic_activate_user_page' );
	function vifonic_activate_user_page(){
		$parttern = '/(\/active-user\?key\=.*)/';
		if ( preg_match($parttern, $_SERVER['REQUEST_URI']) )
		{
			$user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );

			// if user id not exist
			if (!vifonic_check_user_exists($user_id)) {
				vifonic_alert( __('Username does not exist!', 'vifonic') );
			}
			else {
				// if is active before
				if (get_user_meta($user_id, 'is_active', TRUE) == '1') {
					vifonic_alert( __('Account has been activated before!', 'vifonic'));
				}
				else {
					// check expired time
					$time = get_user_meta($user_id, 'active_time', TRUE);
					// if more than 2 days (48h)
					if (time() - $time > 172800) {
						// invalid, delete user then re register
						wp_delete_user($user_id);
						vifonic_alert(__('Activation code expired, please reapply!', 'vifonic'));
					}
					else {
						$key = get_user_meta($user_id, 'active_key', TRUE);

						// delete user meta active_key, active_time and then active user
						if ($key == filter_input( INPUT_GET, 'key' )) {
							delete_user_meta($user_id, 'active_key');
							delete_user_meta($user_id, 'active_time');
							update_user_meta($user_id, 'is_active', 1);
							vifonic_alert( __('Successful! Login account for immediate use!', 'vifonic') );
						}
						else {
							vifonic_alert( __('Incorrect activation code! Please check again!', 'vifonic') );
						}
					}
				}
			}

			echo '<script>window.location = "' . home_url('/') . '";</script>';
		}
	}
}

// ========================================================

// ============================ LOGIN ============================
//Check activated or not
add_filter('wp_authenticate_user', function($user) {
	if (get_user_meta($user->ID, 'is_active', true) == 1 || $user->ID == 1) {
		return $user;
	}
	return new WP_Error('wp_signon', __('Account not activated, please check email again!', 'vifonic'));
}, 10, 2);

if (!function_exists('vifonic_ajax_login')) {
	function vifonic_ajax_login()
	{
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-login-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		$username = $_POST['email'];
		$password = $_POST['password'];
		if ( empty( $username ) || empty( $password ) ) {
			echo json_encode( array( 'success' => false, 'error' => __('This field is required!', 'vifonic') ) );
			die();
		}
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) { //Invalid Email
			$user = get_user_by('email', $username);
		} else {
			$user = get_user_by('login', $username);
		}
		$info = array();
		if ($user && wp_check_password( $password, $user->data->user_pass, $user->ID)) {
			$info['user_login'] = $user->data->user_login;
			$info['user_password'] = $password;
			$info['remember'] = true;
		}

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			if (!wp_check_password( $password, $user->data->user_pass, $user->ID)) {
				echo json_encode( array( 'success' => false, 'error' => __('The email or password is incorrect, please input again!', 'vifonic') ) );
			} else {
				echo json_encode( array( 'success' => false, 'error' => $user_signon->get_error_message() ) );
			}
		} else {
			echo json_encode(array('success' => true, 'message' => __('Logged in successfully. Redirecting ...', 'vifonic')));
		}

		die();
	}
}

// ============================ FORGOT PASSWORD ============================
if (!function_exists('vifonic_ajax_forgot_password')) {
//	add_action( 'login_form_lostpassword', 'vifonic_ajax_forgot_password' );
	function vifonic_ajax_forgot_password() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-forgot-password-nonce', 'security' );

		$errors = retrieve_password();

		if ( is_wp_error( $errors ) ) {
			echo json_encode( array( 'success' => false, 'error' => $errors->get_error_message() ) );
		} else {
			echo json_encode(array('success' => true, 'message' => __('Requested successfully. Please check your email to confirm your resetting password!', 'vifonic')));
		}

		die();
	}
}
