<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 04/08/2017
 * Time: 11:18 SA
 */

//============================================================
//--------------------- Update Profile -----------------------

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

				echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
				get_template_part('templates/loop/content', 'course');
				echo '</div>';

				$i++;
				if ($i%4==0){ echo '<div class="clearfix"></div>'; }
			}
			echo '</div></div>';
		}
	}
}