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


//-----Template function
if (!function_exists('vifonic_')) {
	function vifonic_(){

	}
}