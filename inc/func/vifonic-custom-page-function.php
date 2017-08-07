<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 10:36 SA
 */

add_action('init', 'vifonic_add_rewrite_rule');
function vifonic_add_rewrite_rule(){
	// USER DASHBOARD
	add_rewrite_rule('^user/profile?','index.php?is_user_page=1&post_type=page&user_page=profile','top');
	add_rewrite_rule('^user/my-course?','index.php?is_user_page=1&post_type=page&user_page=my-course','top');
	add_rewrite_rule('^user/active-course?','index.php?is_user_page=1&post_type=page&user_page=active-course','top');
	add_rewrite_rule('^user/wallet?','index.php?is_user_page=1&post_type=page&user_page=wallet','top');

	// CART
	add_rewrite_rule('^cart?','index.php?is_cart_page=1&post_type=page','top');
	// ORDER
	add_rewrite_rule('^order/detail?','index.php?is_order_page=1&post_type=page&order_page=detail','top');
	add_rewrite_rule('^order/payment?','index.php?is_order_page=1&post_type=page&order_page=payment','top');
	add_rewrite_rule('^order/success?','index.php?is_order_page=1&post_type=page&order_page=success','top');
}

add_action('query_vars','vifonic_set_query_var');
function vifonic_set_query_var($vars) {
	array_push($vars, 'is_user_page');
	array_push($vars, 'user_page');
	array_push($vars, 'is_cart_page');
	array_push($vars, 'is_order_page');
	array_push($vars, 'order_page');
	return $vars;
}

add_filter('template_include', 'vifonic_include_template', 1000, 1);
function vifonic_include_template($template){
	$new_template = '';
	if(get_query_var('is_user_page') && is_user_logged_in()){
		$new_template = locate_template( array( 'templates/members/page-user-dashboard.php' ) );

	} elseif (get_query_var('is_cart_page')){
		$new_template = locate_template( array( 'templates/cart-order/page-cart.php' ) );
	} elseif (get_query_var('is_order_page')){
		$new_template = locate_template( array( 'templates/cart-order/page-order.php' ) );
	}

	if ( '' != $new_template ) {
		return $new_template;
	}

	return $template;
}

add_action( 'pre_get_posts', 'vifonic_pre_get_posts', 1 );
function vifonic_pre_get_posts( $query ) {
	// check if the user is requesting an admin page
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	// edit the query only when we are dealing with our "fake" pages
	// if it isn't, return
	if (
		( get_query_var('is_user_page') && is_user_logged_in() )
		or
		( get_query_var('is_cart_page') )
		or
		( get_query_var('is_order_page') )
	) {
		$query->set('post_type', 'page');
		$query->is_home = false;
	} elseif ( get_query_var('is_user_page') && !is_user_logged_in() ) {
		wp_safe_redirect(get_home_url());
		exit();
	}
}

