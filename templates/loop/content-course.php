<?php
/**
 * Content for course
 */
?>

<div class="single-course-item">
	<a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank">
        <div class="course-thumbnail">
            <?php vifonic_post_thumbnail( 'course-thumbnail' ) ?>
        </div>

		<div class="course-detail">
			<div class="wrapper">
				<h3 class="course-title"><?php the_title() ?></h3>
				<div class="course-rating">
                    <div class="rating-star">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <span class="rating-text">0 <?php _e('review', 'vifonic'); ?></span>
                </div>
                <?php printf('<p class="course-teacher">%1$s <strong>%2$s</strong></p>', __('Teacher:', 'vifonic'), get_field( 'course_teacher', get_the_ID()) ); ?>
				<?php
				$is_free = get_field('free_course', get_the_ID());
				if (!$is_free) {
					$regular_price = get_field('regular_price');
					$sale_price = get_field('sale_price');
					if ($sale_price > 0){
						$regular_price = vifonic_price_format($regular_price);
						$sale_price = vifonic_price_format($sale_price);
						printf('<div class="course-price"><span class="price_1">%1$s</span><i class="fa fa-money" aria-hidden="true"></i><span class="price_2">%2$s</span></div>', $regular_price, $sale_price);
					} else {
						$regular_price = vifonic_price_format($regular_price);

						printf('<div class="course-price"><span class="price_1"></span><i class="fa fa-money" aria-hidden="true"></i><span class="price_2">%1$s</span></div>', $regular_price);
					}
					?>
                    <div class="course-add-to-cart">
                        <button type="button" class="btn btn-warning btn-add-to-cart">
							<?php _e('BUY NOW', 'vifonic'); ?>
                        </button>
                    </div>
					<?php
				} else {
					?>
                    <div class="course-price">
                        <span class="sale-price"></span>
                        <img class="free-tag" src="<?php echo get_stylesheet_directory_uri(); ?>/img/free.png" width="32px" alt="Miễn phí">
                        <span class="regular-price"><?php _e('Free', 'vifonic'); ?></span>
                    </div>
                    <div class="course-add-to-cart">
                        <button type="button" class="btn btn-warning btn-add-to-cart">
							<?php _e('See More', 'vifonic'); ?>
                        </button>
                    </div>
					<?php
				}
				?>

			</div>
		</div>
	</a>
</div>