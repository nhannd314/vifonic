<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/08/2017
 * Time: 10:46 SA
 */

get_header();
?>
    <main class="main main-page page-cart">
        <div class="container">
            <section class="content" role="main">
                <div class="row cart-wrapper">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php vifonic_title('GIỎ HÀNG CỦA TÔI','','left'); ?>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-table">
						<?php
						wp_nonce_field( 'ajax-remove-item-nonce', 'vifonic_remove_item_security' );
						$cart_list = array();
						if(isset($_COOKIE['cart_list'])){
							$cookie = $_COOKIE['cart_list'];
							$cookie = stripslashes($cookie);
							$cart_list = json_decode($cookie, true);
						}
						if (!empty($cart_list)){
							foreach ($cart_list as $key => $course_id){
							    $checked_coupcon = vifonic_check_coupon($course_id);
								?>
                                <div class="row cart-item">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 item-image">
                                        <button type="button" class="btn btn-primary btn-remove-item vifonic-ajax-button" onclick="confirm('<?php _e('Are you sure?', 'vifonic'); ?>')" data-course-id="<?php echo $course_id; ?>" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>">X</button>
										<?php echo get_the_post_thumbnail($course_id, 'course-thumbnail') ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 item-name item-price">
                                        <h3><?php echo get_the_title($course_id); ?></h3>
	                                    <?php
	                                    $is_free = get_field('free_course', $course_id);
	                                    $item_price = 0;
	                                    if (!$is_free) {
		                                    $regular_price = get_field('regular_price', $course_id);
		                                    $sale_price = get_field('sale_price', $course_id);
		                                    if ($sale_price > 0){
			                                    $item_price = $sale_price;
			                                    $regular_price = vifonic_price_format($regular_price);
			                                    $sale_price = vifonic_price_format($sale_price);
			                                    printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%2$s</span><span class="sale-price">%1$s</span></div>', $regular_price, $sale_price);
		                                    } else {
			                                    $item_price = $regular_price;
			                                    $regular_price = vifonic_price_format($regular_price);

			                                    printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="sale-price"></span><span class="regular-price">%1$s</span></div>', $regular_price);
		                                    }

		                                    if($checked_coupcon){
		                                        printf('<p>%1$s: <strong>%2$s</strong> (-%3$s)</p>', __('Coupon', 'vifonic'), $checked_coupcon['coupon_code'], $checked_coupcon['percentage_discount'].'%');
			                                    $item_price = ((100-$checked_coupcon['percentage_discount'])/100)*$item_price;
                                            }
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
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 item-price">
		                                <?php
		                                $discount_price = vifonic_price_format($item_price);
		                                printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%1$s</span></div>', $discount_price);
		                                ?>
                                    </div>
                                </div>
								<?php
							}
						} else {
							printf('<p class="text-center">%1$s</p>', __('There are no course in your cart', 'vifonic'));
						}

						?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<?php printf('<a class="btn btn-warning pull-left" href="%1$s"><i class="fa fa-arrow-left" aria-hidden="true"></i> %2$s</a>', get_post_type_archive_link( 'course' ), __('SEE MORE', 'vifonic')); ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<?php printf('<a class="btn btn-primary pull-right" href="%1$s">%2$s <i class="fa fa-arrow-right" aria-hidden="true"></i></a>', '/order/detail/', __('PROCESS TO CHECKOUT', 'vifonic')); ?>
                    </div>

                </div>
            </section>
        </div>
    </main>
<?php
get_footer();
?>