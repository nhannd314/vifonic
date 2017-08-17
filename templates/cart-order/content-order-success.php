<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 11:01 SA
 */


$order_success = isset($_POST['order_success']) ? $_POST['order_success'] : '';
$cart_list = array();
$error_log = '';
$result = false;
if(isset($_COOKIE['cart_list'])){
	$cookie = $_COOKIE['cart_list'];
	$cookie = stripslashes($cookie);
	$cart_list = json_decode($cookie, true);
}
if ( !empty($cart_list) && $order_success != '' ){
	//var_dump($_POST);
	$fullname = isset($_POST['vifonic_fullname']) ? $_POST['vifonic_fullname'] : '';
	$email = isset($_POST['vifonic_email']) ? $_POST['vifonic_email'] : '';
	$mobile = isset($_POST['vifonic_mobile']) ? $_POST['vifonic_mobile'] : '';
	$address = isset($_POST['vifonic_address']) ? $_POST['vifonic_address'] : '';
	$note = isset($_POST['vifonic_note']) ? $_POST['vifonic_note'] : '';
	$method = isset($_POST['vifonic_payment_method']) ? $_POST['vifonic_payment_method'] : '';
	$coupon = '';
	if (isset($_COOKIE['coupon_list'])){
		$cookie = $_COOKIE['coupon_list'];
		$cookie = stripslashes($cookie);
		$coupon_list = json_decode($cookie, true);

		$coupon = implode(', ', $coupon_list);

	}
	$subtotal = 0;
	$total = 0;
	$randomTitle = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
	$args = array(
		'post_title' => $randomTitle,
		'post_type' => 'orders',
		'post_status' => 'publish',
	);

	$order_id = wp_insert_post($args, true);
	if (!is_wp_error($order_id)) {
		if ($method == 'cod_payment') {
			$post_title = '#'.$order_id.' - '.$fullname.' - '.$email;
		} elseif(is_user_logged_in()){
			$user = wp_get_current_user();
			$post_title = '#'.$order_id.' - '.$user->display_name.' - '.$user->user_email;
		} else {
			$post_title = '#'.$order_id;
		}
		$update_post = array(
			'ID'         => $order_id,
			'post_title' => $post_title,
			'post_name'  => 'order-'.$order_id,
			'meta_input' => array(
				'order_status' => 'pending',
				'payment_method' => $method,
			),
		);
		$i = 0;
		$repeater_value = array();

		foreach ($cart_list as $key => $course_id){
			$checked_coupcon = vifonic_check_coupon($course_id);
			$is_free = get_field('free_course', $course_id);

			$row = array(
				'course_id'	=> $course_id,
				'course_title'	=> get_the_title($course_id),
				'course_regular_price' => null,
				'course_sale_price'	=> null,
				'course_last_price'	=> null,
				'course_coupon_code' => '',
			);

			if (!$is_free) {
				$regular_price = get_field('regular_price', $course_id);
				$sale_price = get_field('sale_price', $course_id);
                $item_price = null;

				$row['course_regular_price'] = $regular_price;
				if ($sale_price > 0){
					$item_price = $sale_price;
					$row['course_sale_price'] = $sale_price;
					$subtotal += $sale_price;
				} else {
				    $item_price = $regular_price;
					$subtotal += $regular_price;
				}
				$last_price = $item_price;
				if($checked_coupcon){
				    $last_price = ((100-$checked_coupcon['percentage_discount'])/100)*$item_price;
					$row['course_coupon_code'] = $checked_coupcon['coupon_code'];
				}
				$row['course_last_price'] = $last_price;
				$total += $last_price;
			} else {
				$row['course_regular_price'] = 0;
				$row['course_last_price'] = 0;
            }

			$i = add_row('order_course_list', $row);
			array_push($repeater_value, $row);

			if (is_user_logged_in()){
				$repeater_my_course = array();
				//Create Active key and add to user
				$course_key = md5('User'.get_current_user_id().'Order'.$order_id.'Course'.$course_id);

				$my_course_row = array(
					'profile_my_course' => $course_id,
					'profile_my_course_key' => $course_key,
					'profile_is_active_course' => 0,
				);

				$i = add_row('order_course_list', $row);
				array_push($repeater_my_course, $my_course_row);

				update_field('profile_my_course_list', $repeater_my_course, 'user_'.get_current_user_id());
            }
		}

		update_field('order_course_list', $repeater_value,$order_id);

		$update_post['meta_input']['order_subtotal'] = $subtotal;
		$update_post['meta_input']['order_total'] = $total;

		if(is_user_logged_in()){
			$update_post['meta_input']['order_customer'] = get_current_user_id();
		}
		if($method == 'cod_payment'){
			$update_post['meta_input']['order_fullname'] = $fullname;
			$update_post['meta_input']['order_email'] = $email;
			$update_post['meta_input']['order_mobile'] = $mobile;
			$update_post['meta_input']['order_address'] = $address;
			$update_post['meta_input']['order_note'] = $note;
		}

		$post_update_id = wp_update_post($update_post, true);
		if (is_wp_error($post_update_id)) {
			$errors = $post_update_id->get_error_messages();
			foreach ($errors as $error) {
				$error_log .= $error;
			}
			$result = false;
		} else {
			unset($_COOKIE['cart_list']);
			unset($_COOKIE['coupon_list']);
			setcookie('cart_list', null, time()-1, "/");
			setcookie('coupon_list', null, time()-1, "/");
			$result = true;
		}
	} else {
		$error_log .= __("Can't create order!", "vifonic");
		$result = false;
	}
} else {
	$error_log .= __("Cart is empty!", "vifonic");
	$result = false;
}


//Get Header
get_header();
?>
<main class="main main-page page-order">
	<div class="container">
		<section class="content" role="main">
			<div class="order-wrapper">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 payment-step">
						<ul class="order-step">
							<li><a href="#" class="step1 "><span>1</span><?php _e('Order detail', 'vifonic'); ?> </a></li>
							<li><a href="#" class="step2"><span>2</span><?php _e('Payment', 'vifonic'); ?></a></li>
							<li><a href="#" class="step3 active"><span>3</span><?php _e('Finish', 'vifonic'); ?></a></li>
						</ul
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 step-wrapper">
						<?php
						if ($result) {
							echo '<p class="text-center">'.__("Your order has been successful!").'</p>';
						} else {
							echo '<p class="text-center">'.$error_log.'</p>';
							echo '<p class="text-center">'.__("Sorry, something went wrong. Please try again later.").'</p>';
						}
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
</main>
<?php
get_footer();
?>
