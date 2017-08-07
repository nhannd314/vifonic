<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 10:46 SA
 */
?>
<?php
var_dump($_POST);


$order_page = (null !== get_query_var('order_page')) ? get_query_var('order_page') : '';
switch ($order_page){
	case 'detail':
		echo 'detail page';
		get_template_part('templates/cart-order/content', 'detail');
		break;
	case 'payment':
		echo 'payment page';
		get_template_part('templates/cart-order/content', 'payment');
		break;
	case 'success':
		echo 'success page';
		get_template_part('templates/cart-order/content', 'success');
		break;
	default:
		echo 'default page';
		get_template_part('templates/cart-order/content', 'detail');
}
?>