<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 21/07/2017
 * Time: 12:52 SA
 */
//Add custom page using rewrite_rule
require get_template_directory() . '/inc/func/vifonic-custom-page-function.php';

require get_template_directory() . '/inc/func/vifonic-register-login-function.php';
require get_template_directory() . '/inc/func/vifonic-user-dashboard-function.php';
require get_template_directory() . '/inc/func/vifonic-cart-order-function.php';


add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
	wp_register_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
//OR
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
}

function my_enqueue($hook) {
	wp_enqueue_script('my_custom_admin_script', get_template_directory_uri(). '/js/admin-script.js');
}

add_action('admin_enqueue_scripts', 'my_enqueue');

//-----Template function
if (!function_exists('vifonic_')) {
	function vifonic_(){

	}
}

?>