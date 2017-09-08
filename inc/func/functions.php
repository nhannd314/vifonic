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
require get_template_directory() . '/inc/func/vifonic-comment-ajax-function.php';


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


function vifonic_is_localhost() {
	$server_name = strtolower( $_SERVER['SERVER_NAME'] );
	return in_array( $server_name, array( 'localhost', '127.0.0.1' ) );
}

function vifonic_from_email() {
	$admin_email = get_option( 'admin_email' );
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );

	if ( vifonic_is_localhost() ) {
		return $admin_email;
	}

	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
		$sitename = substr( $sitename, 4 );
	}

	if ( strpbrk( $admin_email, '@' ) == '@' . $sitename ) {
		return $admin_email;
	}

	return 'wordpress@' . $sitename;
}

//-----Template function
if (!function_exists('vifonic_')) {
	function vifonic_(){

	}
}

?>