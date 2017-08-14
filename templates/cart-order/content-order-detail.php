<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 11:00 SA
 */

$full_name = '';
$email = '';
$mobile = '';
if (is_user_logged_in()){
	$user = wp_get_current_user();
	$full_name = $user->display_name;
	$email = $user->user_email;
	$mobile = get_field('profile_mobile','user_'.$user->ID);
}

get_header();
?>
    <main class="main main-page page-order">
        <div class="container">
            <section class="content" role="main">
                <div class="order-wrapper">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 payment-step">
                            <ul class="order-step">
                                <li><a href="#" class="step1 active"><span>1</span><?php _e('Order detail', 'vifonic'); ?> </a></li>
                                <li><a href="#" class="step2"><span>2</span><?php _e('Payment', 'vifonic'); ?></a></li>
                                <li><a href="#" class="step3"><span>3</span><?php _e('Finish', 'vifonic'); ?></a></li>
                            </ul
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 step-wrapper">
                            <div class="row step-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 15px">
                                    <h3 class="text-center"><?php _e('Ordering Guide', 'vifonic'); ?></h3>
                                </div>
                                <!--Form điền thông tin giao hàng-->
                                <form id="info-form" action="/order/payment/" method="post" role="form">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h3 class="form-title"><?php _e('Delivery information', 'vifonic'); ?></h3>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_fullname" id="vifonic_fullname" placeholder="<?php _e('Full Name', 'vifonic'); ?>" value="<?php echo $full_name; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control" name="vifonic_email" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>" value="<?php echo $email; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_mobile" id="vifonic_mobile" placeholder="<?php _e('Mobile', 'vifonic'); ?>" value="<?php echo $mobile; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_address" id="vifonic_address" placeholder="<?php _e('Address', 'vifonic'); ?>" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-submit-order" name="submit-order" value="submit-order"><?php _e('Next', 'vifonic'); ?><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                    </div>
                                </form>
                                <!--Bảng thông tin đơn hàng-->
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="order-table">
                                        <h3 class="order-title"><?php _e('ORDER DETAIL', 'vifonic'); ?></h3>
										<?php
										$cookie = $_COOKIE['cart_list'];
										$cookie = stripslashes($cookie);
										$cart_list = json_decode($cookie, true);
										if (!empty($cart_list)){
											$i = 1;
											$subtotal = 0;
											$total = 0;
											foreach ($cart_list as $key => $course_id){
												$checked_coupcon = vifonic_check_coupon($course_id);
												?>
                                                <div class="row cart-item">
                                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 item-name">
                                                        <?php
                                                        printf('<p><a href="%1$s">%2$s. %3$s</a></p>',  esc_url(get_the_permalink($course_id)), $i, get_the_title($course_id));
                                                        if($checked_coupcon){
                                                            printf('<p>%1$s: <strong>%2$s</strong> (-%3$s)</p>', __('Coupon', 'vifonic'), $checked_coupcon['coupon_code'], $checked_coupcon['percentage_discount'].'%');
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 item-price">
														<?php
														$is_free = get_field('free_course', $course_id);
														$item_price = 0;
														if (!$is_free) {
															$regular_price = get_field('regular_price', $course_id);
															$sale_price = get_field('sale_price', $course_id);
															if ($sale_price > 0){
																$item_price = $sale_price;
																$subtotal += $sale_price;

																$regular_price = vifonic_price_format($regular_price);
																$sale_price = vifonic_price_format($sale_price);
																printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%1$s</span><span class="sale-price">%2$s</span></div>', $sale_price, $regular_price);
															} else {
																$item_price = $regular_price;
																$subtotal += $regular_price;


																$regular_price = vifonic_price_format($regular_price);

																printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%1$s</span></div>', $regular_price);
															}

															if($checked_coupcon){
																$item_price = ((100-$checked_coupcon['percentage_discount'])/100)*$item_price;
																$discount_price = vifonic_price_format($item_price);
																printf('<div class="course-price"><i class="fa fa-arrow-right" aria-hidden="true"></i><span class="regular-price">%1$s</span></div>', $discount_price);

															}
															$total += $item_price;
														} else {
															?>
                                                            <div class="course-price">
                                                                <span class="sale-price"></span>
                                                                <img class="free-tag" src="<?php echo get_stylesheet_directory_uri(); ?>/img/free.png" width="32px" alt="Miễn phí">
                                                                <span class="regular-price"><?php _e('Free', 'vifonic'); ?></span>
                                                            </div>
															<?php
														}
														?>
                                                    </div>
                                                </div>
												<?php
												$i++;
											}
											?>
                                            <div class="row total-order">
                                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 item-name">
                                                    <p class="subtotal"><?php _e('SUBTOTAL', 'vifonic'); ?></p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 item-price">
		                                            <?php
		                                            $subtotal = vifonic_price_format($subtotal);
		                                            echo '<span class="subtotal-price">'.$subtotal.'</span>';
		                                            ?>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 item-name">
                                                    <p class="total"><?php _e('TOTAL', 'vifonic'); ?></p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 item-price">
													<?php
													$total = vifonic_price_format($total);
													echo '<span class="total-price">'.$total.'</span>';
													?>
                                                </div>
                                            </div>
											<?php
										} else {
											wp_safe_redirect(home_url().'/cart/');
										}
										?>
                                    </div>
                                    <form id="add-coupon-form" action="/order/detail/" method="post" role="form">
                                        <div class="form-group form-inline">
                                            <h4 style="margin-top: 19px;"><i class="fa fa-tag" aria-hidden="true"></i> <?php _e('Coupon', 'vifonic'); ?></h4>
                                            <input type="text" class="form-control" name="vifonic_coupon" id="vifonic_coupon" placeholder="<?php _e('Input coupon code here...', 'vifonic') ?>" >
	                                        <?php wp_nonce_field( 'ajax-add-coupon-nonce', 'vifonic_add_coupon_security' ); ?>
                                            <button type="button" class="btn btn-primary btn-add-coupon vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Apply', 'vifonic') ?>" ><?php _e('Apply', 'vifonic') ?></button>
                                            <p class="status text-danger"></p>
                                        </div>
                                    </form>
                                </div>
                            </div >
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php
get_footer();
?>