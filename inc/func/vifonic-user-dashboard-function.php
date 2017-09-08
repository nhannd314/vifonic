<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 04/08/2017
 * Time: 11:18 SA
 */

//============================================================
//--------------------- Update Profile -----------------------
//Custom Avatar
function be_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
	$user_id = is_object( $id_or_email ) ? $id_or_email->user_id : $id_or_email;
	// If provided an email and it doesn't exist as WP user, return avatar since there can't be a custom avatar
	$email = is_object( $id_or_email ) ? $id_or_email->comment_author_email : $id_or_email;
	if( is_email( $email ) && ! email_exists( $email ) )
		return $avatar;

	$custom_avatar = esc_url(get_field('profile_avatar', 'user_'.$user_id));
	if ($custom_avatar)
		$return = '<img alt="'.$alt.'" src="'.$custom_avatar.'" srcset="'.$custom_avatar.'" class="avatar avatar-40 photo" height="'.$size.'" width="'.$size.'">';
	elseif ($avatar)
		$return = $avatar;
	else
		$return = '<img alt="'.$alt.'" src="'.$default.'" srcset="'.$default.'" class="avatar avatar-40 photo" height="'.$size.'" width="'.$size.'">';
	return $return;
}
add_filter('get_avatar', 'be_gravatar_filter', 10, 5);


//AJAX
function ajax_update_profile_init(){
	global $vifonic_version;
	wp_register_script('ajax-update-profile-script', get_template_directory_uri() . '/js/ajax-update-profile-script.js', array('jquery'), $vifonic_version, true);
	wp_enqueue_script('ajax-update-profile-script');

	wp_localize_script( 'ajax-update-profile-script', 'ajax_update_profile_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	// Enable the user with no privileges to run vifonic_ajax_update_profile() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxUpdateProfile', 'vifonic_ajax_update_profile' );
	add_action( 'wp_ajax_ajaxUpdateProfile', 'vifonic_ajax_update_profile' );
}

// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
	add_action('init', 'ajax_update_profile_init');
}

//------------

// get the data received
if (!function_exists('vifonic_profile_data_filter')) {
	function vifonic_profile_data_filter($post){
		return array(
//			'profile_avatar' => esc_url( $post['avatar'] ),
			'first_name' => sanitize_text_field( $post['fullname'] ),
			'profile_birthday' => sanitize_text_field( $post['birthday'] ),
			'profile_mobile' => sanitize_text_field( $post['mobile'] ),
			'profile_sex' => esc_attr( $post['sex'] ),
			'current_pass' => esc_attr( $post['current_pass'] ),
			'new_pass' => esc_attr( $post['new_pass'] ),
			'new_pass_confirm' => esc_attr( $post['new_pass_confirm'] ),
		);
	}
}

//validate data received
if (!function_exists('vifonic_validate_profile_data')) {
	function vifonic_validate_profile_data($post){
		$error = array();

//		$profile_avatar = $post['avatar'];
		$fullname = $post['fullname'];
		$profile_birthday = $post['birthday'];
		$profile_mobile = $post['mobile'];
		$profile_sex = $post['sex'];

		$current_pass = $post['current_pass'];
		$new_pass = $post['new_pass'];
		$new_pass_confirm = $post['new_pass_confirm'];

		if ( empty( $fullname ) || empty( $profile_birthday ) || empty( $profile_mobile ) || empty( $profile_sex ) ) {
			array_push($error, __('This field is required!', 'vifonic'));
		}
		$user = wp_get_current_user();
		if ( !empty( $current_pass ) || !empty( $new_pass ) || !empty( $new_pass_confirm ) ){
			if (!wp_check_password( $current_pass, $user->data->user_pass, $user->ID)){
				array_push($error, __('Current password incorrect!', 'vifonic') );
			}

			if ( 7 > strlen( $new_pass ) ) {
				array_push($error, __('Passwords must be greater than 7 characters!', 'vifonic') );
			}
			if ($new_pass != $new_pass_confirm) {
				array_push($error, __('Password confirm incorrect!', 'vifonic') );
			}
		}

		if (empty($error)) return false;
		return $error;
	}
}

// Update new profile
if (!function_exists('vifonic_ajax_update_profile')) {
	function vifonic_ajax_update_profile(){
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-update-profile-nonce', 'security' );

		$error = vifonic_validate_profile_data($_POST);

		if ($error != false) {
			echo json_encode(array('success' => false, 'error' => $error));
		} else {
			$user = wp_get_current_user();
			$new_profile = vifonic_profile_data_filter($_POST);

			// Update PROFILE DATA
			if ($new_profile['first_name'] != get_user_meta($user->ID, 'first_name', true)) {
				update_user_meta($user->ID, 'first_name',$new_profile['first_name']);
			}
			if ($new_profile['profile_birthday'] != get_user_meta($user->ID, 'profile_birthday', true)) {
				$ymd = DateTime::createFromFormat('d/m/Y', $new_profile['profile_birthday'])->format('Ymd');
				update_user_meta($user->ID, 'profile_birthday', $ymd);
			}
			if ($new_profile['profile_mobile'] != get_user_meta($user->ID, 'profile_mobile', true)) {
				update_user_meta($user->ID, 'profile_mobile',$new_profile['profile_mobile']);
			}
			if ($new_profile['profile_sex'] != get_user_meta($user->ID, 'profile_sex', true)) {
				update_user_meta($user->ID, 'profile_sex',$new_profile['profile_sex']);
			}
			if (!empty($new_profile['new_pass'])) {
				wp_set_password( $new_profile['new_pass'], $user->ID );
				echo json_encode(array('success' => true, 'message' => __("Profile update successful! Your password has been changed, please log in again!", 'vifonic')));
				die();
			}

			echo json_encode(array('success' => true, 'message' => __("Profile update successful!", 'vifonic')));
		}

	}
}

// Upload avatar
if (!function_exists('vifonic_upload_avatar')){
	add_action('wp_head', 'vifonic_upload_avatar');
	function vifonic_upload_avatar(){
		$user = wp_get_current_user();
		// Check that the nonce is valid, and the user can edit this post.
		if (isset( $_POST['my_image_upload_nonce'] )){
			if (
				isset( $_POST['my_image_upload_nonce'], $_POST['post_id'] )
				&& wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )
				&& current_user_can( 'edit_post', $_POST['post_id'] )
			) {
				// The nonce was valid and the user has the capabilities, it is safe to continue.

				// These files need to be included as dependencies when on the front end.
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );

				// Let WordPress handle the upload.
				// Remember, 'my_image_upload' is the name of our file input in our form above.
				$attachment_id = media_handle_upload( 'my_image_upload', $_POST['post_id'] );

				if ( is_wp_error( $attachment_id ) ) {
					// There was an error uploading the image.
					$text = __('There was an error uploading the image.', 'vifonic');
					echo '<script type="text/javascript">alert("'.$text.'")</script>';
				} else {
					// The image was uploaded successfully!
					$old_avatar_id = get_user_meta($user->ID, 'profile_avatar', true);
					wp_delete_attachment($old_avatar_id, true);
					update_field('field_59852bfd73c7a', $attachment_id, 'user_'.$user->ID);
					/*$text = __('The image was uploaded successfully!', 'vifonic');
					echo '<script>alert("'.$text.'")</script>';*/
					echo '<script type="text/javascript">window.location.replace("/user/profile/");</script>';
					$_POST = array();
				}
			} else {
				// The security check failed, maybe show the user an error.
				$text = __('Something wrong when upload, please try again!!', 'vifonic');
				echo '<script type="text/javascript">alert("'.$text.'")</script>';
			}
		}
	}
}

//----------------------- My Course ---------------------------
// ============== Show list Courses by ID ============
if (!function_exists('vifonic_show_list_courses_by_id'))
{
	function vifonic_show_list_courses_by_id($course_id_list = array() ){
		$args = array(
			'post_type' => 'course',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post__in' => $course_id_list,
		);

		$queryCourse = new WP_Query($args);
		if ($queryCourse->have_posts()){
			echo '<div class="vifonic-course-list"><div class="row">';
			$i = 0;
			while ($queryCourse->have_posts()) {
				$queryCourse->the_post();

				echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 course-item">';
				get_template_part('templates/loop/content', 'my-course');
				echo '</div>';

				$i++;
				if ($i%4==0){ echo '<div class="clearfix"></div>'; }
			}
			echo '</div></div>';
		}
	}
}