<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 10:31 SA
 */

//AJAX
$theme = wp_get_theme('vifonic');
$vifonic_version = $theme['Version'];

function ajax_add_to_cart_init(){
	global $vifonic_version;
	wp_register_script('ajax-add-to-cart-script', get_template_directory_uri() . '/js/ajax-add-to-cart-script.js', array('jquery'), $vifonic_version, true);
	wp_enqueue_script('ajax-add-to-cart-script');

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_add_to_cart_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_add_to_wishlist_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_remove_item_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_remove_wishlist_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_add_coupon_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxAddToCart', 'vifonic_ajax_add_to_cart' );
	add_action( 'wp_ajax_ajaxAddToCart', 'vifonic_ajax_add_to_cart' );

	add_action( 'wp_ajax_nopriv_ajaxAddToWishlist', 'vifonic_ajax_add_to_wishlist' );
	add_action( 'wp_ajax_ajaxAddToWishlist', 'vifonic_ajax_add_to_wishlist' );

	add_action( 'wp_ajax_nopriv_ajaxRemoveItem', 'vifonic_ajax_remove_item' );
	add_action( 'wp_ajax_ajaxRemoveItem', 'vifonic_ajax_remove_item' );

	add_action( 'wp_ajax_nopriv_ajaxRemoveWishlist', 'vifonic_ajax_remove_wishlist' );
	add_action( 'wp_ajax_ajaxRemoveWishlist', 'vifonic_ajax_remove_wishlist' );

	add_action( 'wp_ajax_nopriv_ajaxAddCoupon', 'vifonic_ajax_add_coupon' );
	add_action( 'wp_ajax_ajaxAddCoupon', 'vifonic_ajax_add_coupon' );
}

// Execute the action only if the user isn't logged in
add_action('init', 'ajax_add_to_cart_init');

//ADD TO CART BUTTON
if (!function_exists('vifonic_ajax_add_to_cart')) {
	function vifonic_ajax_add_to_cart() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-add-to-cart-nonce', 'security' );

		$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : 0;
		$course = get_post(intval($course_id));
		if ($course != null) {
			if(!isset($_COOKIE['cart_list'])) {
				$cart_list = array( "course_".$course_id => $course_id );
				setcookie('cart_list', json_encode($cart_list), time()+(60*60*24), "/");
				echo json_encode( array('success' => true, 'message' => array( __('Cart created! Course has been add to cart!', 'vifonic')) ));
				die();
			} else {
				$cookie = $_COOKIE['cart_list'];
				$cookie = stripslashes($cookie);
				$cart_list = json_decode($cookie, true);
				if (!array_key_exists('course_'.$course_id, $cart_list)){
					$cart_list["course_".$course_id] = $course_id;
				}
				setcookie('cart_list', json_encode($cart_list), time()+(60*60*24), "/");
				echo json_encode( array('success' => true, 'message' => array( __('Course has been add to cart!', 'vifonic')) ));
				die();
			}
		} else {
			echo json_encode(array('success' => false, 'error' => __('Course not exists!', 'vifonic') ));
			die();
		}
	}
}

//ADD TO WISHLIST BUTTON
if (!function_exists('vifonic_ajax_add_to_wishlist')) {
	function vifonic_ajax_add_to_wishlist() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-add-to-wishlist-nonce', 'security' );

		$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : 0;
		$course = get_post(intval($course_id));
		if ($course != null) {
			$wishlist = get_field('profile_wishlist', 'user_'.get_current_user_id());
			if(!$wishlist) {
				$wishlist = array($course_id);
				update_field('profile_wishlist', $wishlist, 'user_'.get_current_user_id());
				echo json_encode( array('success' => true, 'message' => array( __('Wishlist created! Course has been add to wishlist!', 'vifonic')) ));
				die();
			} else {
				array_push($wishlist, $course_id);
				update_field('profile_wishlist', $wishlist, 'user_'.get_current_user_id());
				echo json_encode( array('success' => true, 'message' => array( __('Course has been add to wishlist!', 'vifonic')) ));
				die();
			}
		} else {
			echo json_encode(array('success' => false, 'error' => __('Course not exists!', 'vifonic') ));
			die();
		}
	}
}

//REMOVE ITEM BUTTON
if (!function_exists('vifonic_ajax_remove_item')) {
	function vifonic_ajax_remove_item() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-remove-item-nonce', 'security' );

		$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : 0;
		$course = get_post(intval($course_id));
		if ($course != null) {
			if(isset($_COOKIE['cart_list'])) {
				$cookie = $_COOKIE['cart_list'];
				$cookie = stripslashes($cookie);
				$cart_list = json_decode($cookie, true);
				if (array_key_exists('course_'.$course_id, $cart_list)){
					unset($cart_list["course_".$course_id]);
				}
				setcookie('cart_list', json_encode($cart_list), time()+(60*60*24), "/");
				echo json_encode( array('success' => true, 'message' => array( __('Course has been deleted!', 'vifonic')) ));
				die();
			}
		}
	}
}

//REMOVE WISHLIST BUTTON
if (!function_exists('vifonic_ajax_remove_wishlist')) {
	function vifonic_ajax_remove_wishlist() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-remove-wishlist-nonce', 'security' );

		$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : 0;
		$course = get_post(intval($course_id));
		if ($course != null) {
			$wishlist = get_field('profile_wishlist', 'user_'.get_current_user_id());
			if($wishlist) {
				if(($key = array_search($course_id, $wishlist)) !== false) {
					unset($wishlist[$key]);
				}
				update_field('profile_wishlist', $wishlist, 'user_'.get_current_user_id());
				echo json_encode( array('success' => true, 'message' => array( __('Course has been deleted!', 'vifonic')) ));
				die();
			}
		}
	}
}

//AJAX ADD COUPON
if (!function_exists('vifonic_ajax_add_coupon')) {
	function vifonic_ajax_add_coupon() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-add-coupon-nonce', 'security' );

		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : 0;

		$args = array(
			'post_type' => 'coupon',
			'post_status' => 'publish',
			'numberposts' => 1,
			'name' => sanitize_title($coupon_code),
		);
		$coupon = get_posts($args);

		if ( $coupon ) {
			$coupon_end = get_field('coupon_end', $coupon[0]->ID);
			$current_date = date('Ymd');
			if (strtotime($coupon_end) < strtotime($current_date)){
				echo json_encode(array('success' => false, 'error' => __('Coupon has been expired!', 'vifonic') ));
				die();
			}

			if(!isset($_COOKIE['coupon_list'])) {
				$coupon_list = array( $coupon_code );
				setcookie('coupon_list', json_encode($coupon_list), time()+(60*60*24), "/");
				echo json_encode( array('success' => true, 'message' => array( __('Coupon added!', 'vifonic')) ));
				die();
			} else {
				$cookie = $_COOKIE['coupon_list'];
				$cookie = stripslashes($cookie);
				$coupon_list = json_decode($cookie, true);
				if (!in_array($coupon_code, $coupon_list)){
					array_push($coupon_list, $coupon_code);
				}
				setcookie('coupon_list', json_encode($coupon_list), time()+(60*60*24), "/");
				echo json_encode( array('success' => true, 'message' => array( __('Coupon has been applied!', 'vifonic')) ));
				die();
			}
		} else {
			echo json_encode(array('success' => false, 'error' => __('Coupon not exists!', 'vifonic') ));
			die();
		}
	}
}

//Check coupon
if (!function_exists('vifonic_check_coupon')) {
	function vifonic_check_coupon($course_id){
		if (isset($_COOKIE['coupon_list'])){
			$cookie = $_COOKIE['coupon_list'];
			$cookie = stripslashes($cookie);
			$coupon_list = json_decode($cookie, true);

			$coupon_arr = array('coupon_code' => '', 'percentage_discount' => 0);
			foreach ($coupon_list as $coupon_code) {
				$args = array(
					'post_type' => 'coupon',
					'post_status' => 'publish',
					'numberposts' => 1,
					'name' => sanitize_title($coupon_code),
				);
				$coupon = get_posts($args);

				if(get_field('free_course', $course_id)){
				    return false;
				}

				if (get_field('exclude_sale_items', $coupon[0]->ID) && get_field('sale_price', $course_id) > 0){
					continue;
				}

				$coupon_end = get_field('coupon_end', $coupon[0]->ID);
				$current_date = date('Ymd');
				if (strtotime($coupon_end) < strtotime($current_date)){
					continue;
				}

				$apply_for_course = get_field('apply_for_course', $coupon[0]->ID);
				$apply_for_course_category = get_field('apply_for_course_category', $coupon[0]->ID);
				if ($apply_for_course) {
					if (in_array($course_id, $apply_for_course) ){
						if ( $coupon_arr['percentage_discount'] < get_field('percentage_discount', $coupon[0]->ID) ){
							$coupon_arr['percentage_discount'] =  get_field('percentage_discount', $coupon[0]->ID);
							$coupon_arr['coupon_code'] =  $coupon_code;
						}
					}
				}

				if($apply_for_course_category) {
					$is_apply_for_course_category = false;
					$terms = wp_get_post_terms( $course_id, 'course_category', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids'));
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term_id ) {
							if (in_array($term_id, $apply_for_course_category)) {
								$is_apply_for_course_category = true;
							}
						}
						if($is_apply_for_course_category){
							if ( $coupon_arr['percentage_discount'] < get_field('percentage_discount', $coupon[0]->ID) ){
								$coupon_arr['percentage_discount'] =  get_field('percentage_discount', $coupon[0]->ID);
								$coupon_arr['coupon_code'] =  $coupon_code;
							}
						}
					}
				}

				if(!$apply_for_course && !$apply_for_course_category) {
					if ( $coupon_arr['percentage_discount'] < get_field('percentage_discount', $coupon[0]->ID) ){
						$coupon_arr['percentage_discount'] =  get_field('percentage_discount', $coupon[0]->ID);
						$coupon_arr['coupon_code'] =  $coupon_code;
					}
				}
			} //End foreach Coupon list

			if ($coupon_arr['coupon_code'] == '' && $coupon_arr['percentage_discount'] == 0) {
				return false;
			} else {
				return $coupon_arr;
			}
		} else {
			return false;
		}
	}
}


//Send Mail Order
if (!function_exists('vifonic_send_mail_order')) {
	function vifonic_send_mail_order( $user_email, $order_id, $order_arr = array() ) {
		// get the posted data
		$email_address = vifonic_from_email();

		// write the email content
		$header = "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=utf-8\n";
		$header .= "From:" . $email_address;

		$subject = __('Order', 'vifonic'). ' #'.$order_id.' - '.__('Course ordering successful!!', 'vifonic');
		$subject = "=?utf-8?B?" . base64_encode( $subject ) . "?=";
		$to      = $user_email;

		$message = __('Congratulations on successfully ordering course. This is Order detail:', 'vifonic');

		foreach ($order_arr as $order_item) {
			$course = get_post($order_item['course_id']);
			$message .= '<br/>';
			$message .= '<br/>'.__('Course id:', 'vifonic').$order_item['course_id'];
			$message .= '<br/>'.__('Course name:', 'vifonic').$course->post_title;
			$message .= '<br/>'.__('Course key:', 'vifonic').$order_item['course_key'];
		}

		// send the email using wp_mail()
		return wp_mail( $to, $subject, $message, $header );
	}
}
?>