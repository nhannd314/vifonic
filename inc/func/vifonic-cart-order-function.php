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

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_cart_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_localize_script( 'ajax-add-to-cart-script', 'ajax_cart_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxAddToCart', 'vifonic_ajax_add_to_cart' );
	add_action( 'wp_ajax_ajaxAddToCart', 'vifonic_ajax_add_to_cart' );

	add_action( 'wp_ajax_nopriv_ajaxRemoveItem', 'vifonic_ajax_add_to_cart' );
	add_action( 'wp_ajax_ajaxRemoveItem', 'vifonic_ajax_add_to_cart' );
}

// Execute the action only if the user isn't logged in
add_action('init', 'ajax_add_to_cart_init');

//-----Buy Now Button function
if (!function_exists('vifonic_save_cart_cookie')) {
	function vifonic_save_cart_cookie($course_id){

	}
}

//ADD TO CART BUTTON
if (!function_exists('vifonic_ajax_add_to_cart')) {
	function vifonic_ajax_add_to_cart() {

	}
}

//REMOVE ITEM BUTTON
if (!function_exists('vifonic_ajax_remove_item')) {
	function vifonic_ajax_remove_item() {

	}
}