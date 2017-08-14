<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 10:46 SA
 */

$order_page = (null !== get_query_var('order_page')) ? get_query_var('order_page') : '';

switch ($order_page){
	case 'detail':
		get_template_part('templates/cart-order/content-order', 'detail');
		break;
	case 'payment':
		$submit_order = isset($_POST['submit-order']) ? $_POST['submit-order'] : '';
		if ($submit_order == '') {
			wp_redirect(home_url().'/cart/');
			exit();
		}
		get_template_part('templates/cart-order/content-order', 'payment');
		break;
	case 'success':
		$order_success = isset($_POST['order_success']) ? $_POST['order_success'] : '';
		if ($order_success == '') {
			wp_redirect(home_url().'/cart/');
			exit();
		}
		get_template_part('templates/cart-order/content-order', 'success');
		break;
	default:
		get_template_part('templates/cart-order/content-order', 'detail');
}

