<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 11:00 SA
 */

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
                                <li><a href="#" class="step2 active"><span>2</span><?php _e('Payment', 'vifonic'); ?></a></li>
                                <li><a href="#" class="step3"><span>3</span><?php _e('Finish', 'vifonic'); ?></a></li>
                            </ul
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 step-wrapper">
                            <div class="row step-2">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 15px">
                                    <p class="text-center"><?php _e('Free shipping with order of 500,000 VND or more', 'vifonic'); ?></p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <h3 class="form-title"><?php _e('SELECT PAYMENT METHOD', 'vifonic'); ?></h3>

                                    <div class="payment-method">
                                        <a role="button" data-toggle="collapse" href="#collapseCOD" aria-expanded="false" aria-controls="collapseCOD">
                                            <label class="collape-link"><?php _e('COD Payment', 'vifonic'); ?></label>
                                        </a>
                                        <div class="collapse" id="collapseCOD">
                                            <form id="cod-payment-form" action="/order/success/" method="post" role="form">
                                                <p><?php _e('Deliver activation code and collect money (COD)', 'vifonic'); ?></p>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                                        <input type="text" class="form-control" name="vifonic_fullname" id="vifonic_fullname" placeholder="<?php _e('Full Name', 'vifonic'); ?>" value="<?php echo $_POST['vifonic_fullname']; ?>" required>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                                        <input type="email" class="form-control" name="vifonic_email" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>" value="<?php echo $_POST['vifonic_email']; ?>" required>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                                        <input type="text" class="form-control" name="vifonic_mobile" id="vifonic_mobile" placeholder="<?php _e('Mobile', 'vifonic'); ?>" value="<?php echo $_POST['vifonic_mobile']; ?>" required>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                                        <input type="text" class="form-control" name="vifonic_address" id="vifonic_address" placeholder="<?php _e('Address', 'vifonic'); ?>" value="<?php echo $_POST['vifonic_address']; ?>" required>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                                        <textarea class="form-control" name="vifonic_note" id="vifonic_note" rows="4" placeholder="<?php _e('Note', 'vifonic'); ?>"></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="vifonic_payment_method" value="cod_payment">
												<?php if(isset($_POST['vifonic_coupon']) && $_POST['vifonic_coupon'] != ''){
													echo '<input type="hidden" name="vifonic_coupon" value="'.$_POST['vifonic_coupon'].'">';
												} ?>
                                                <input type="hidden" name="vifonic_coupon" value="<?php echo $_POST['vifonic_coupon']; ?>">
                                                <button type="submit" class="btn btn-primary" name="order_success" value="order_success"><?php _e('Finish', 'vifonic'); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <a role="button" data-toggle="collapse" href="#collapseBankTransfer" aria-expanded="false" aria-controls="collapseBankTransfer">
                                            <label class="collape-link"><?php _e('Bank Transfer Payment (Fee?)', 'vifonic'); ?></label>
                                        </a>
                                        <div class="collapse" id="collapseBankTransfer">
                                            <form id="banktransfer-payment-form" action="/order/success/" method="post" role="form">
                                                <p>Thanh toán chuyển khoản ngân hàng</p>
                                                <input type="hidden" name="vifonic_payment_method" value="banktransfer_payment">
												<?php if(isset($_POST['vifonic_coupon']) && $_POST['vifonic_coupon'] != ''){
													echo '<input type="hidden" name="vifonic_coupon" value="'.$_POST['vifonic_coupon'].'">';
												} ?>
                                                <button type="submit" class="btn btn-primary" name="order_success" value="order_success"><?php _e('Finish', 'vifonic'); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <a role="button" data-toggle="collapse" href="#collapseOffice" aria-expanded="false" aria-controls="collapseOffice">
                                            <label class="collape-link"><?php _e('Payment at the central office', 'vifonic'); ?></label>
                                        </a>
                                        <div class="collapse" id="collapseOffice">

                                            <form id="office-payment-form" action="/order/success/" method="post" role="form">
                                                <p>Thanh toán tại văn phòng của Trung tâm</p>
                                                <input type="hidden" name="vifonic_payment_method" value="office_payment">
												<?php if(isset($_POST['vifonic_coupon']) && $_POST['vifonic_coupon'] != ''){
													echo '<input type="hidden" name="vifonic_coupon" value="'.$_POST['vifonic_coupon'].'">';
												} ?>
                                                <button type="submit" class="btn btn-primary" name="order_success" value="order_success"><?php _e('Finish', 'vifonic'); ?></button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
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
									<?php
									if (isset($_COOKIE['coupon_list'])){
										$cookie = $_COOKIE['coupon_list'];
										$cookie = stripslashes($cookie);
										$coupon_list = json_decode($cookie, true);

										//printf('<br><p>%1$s: <strong>%2$s</strong></p>', __('Applied Coupon', 'vifonic'), implode(', ', $coupon_list));
                                    }
                                    ?>
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