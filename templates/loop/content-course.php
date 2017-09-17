<?php
/**
 * Content for course
 */
?>

<div class="single-course-item">
	<?php
	/*$is_hot_course = get_field('featured_course', get_the_ID());
	if ($is_hot_course) {
		//echo '<img src="'.get_stylesheet_directory_uri().'/img/hot.png" class="hot-tag" alt="">';
        echo '<span class="hot-tag">HOT</span>';
	}*/
	?>
    <div class="course-thumbnail">
        <a class="relative" rel="nofollow" href="<?php the_permalink(); ?>">
			<?php vifonic_post_thumbnail( 'course-thumbnail' ) ?>
        </a>
    </div>

    <div class="course-detail">
        <div class="wrapper">
            <h3 class="course-title">
                <a class="relative" rel="nofollow" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
            </h3>
            <div class="course-rating">
                <div class="rating-star">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
                <span class="rating-text"><?php comments_number(__('0 review', 'vifonic'), __('1 review', 'vifonic'), __('% review', 'vifonic')); ?></span>
            </div>

			<?php
			$teacher_list = get_field("teacher_list", get_the_ID());
			if (!empty($teacher_list)) {
				$post_type_query  = new WP_Query(
					array (
						'post_type'      => 'teacher',
						'post__in' => $teacher_list
					)
				);

				$posts_array = $post_type_query->posts;
				$post_title_array = wp_list_pluck( $posts_array, 'post_title' );
				printf('<p class="course-teacher">%1$s <strong>%2$s</strong></p>', __('Teacher:', 'vifonic'), implode(", ",$post_title_array) );
			} else {
				printf('<p class="course-teacher">%1$s <strong>%2$s</strong></p>', __('Teacher:', 'vifonic'), "" );
            }
            ?>
			<?php
			$is_active_course = false;
			$owned_course = false;
			$rows = get_field('profile_my_course_list', 'user_'.get_current_user_id());
			if($rows) {
				foreach($rows as $row) {
					if ($row['profile_my_course'] == get_the_ID()){
						$owned_course = true;
						$is_active_course = $row['profile_is_active_course'];
						break;
					}
				}
			}
			$is_free = get_field('free_course', get_the_ID());
			if (!$is_free) {
				$regular_price = get_field('regular_price');
				$sale_price = get_field('sale_price');
				if ($sale_price > 0){
					$regular_price = vifonic_price_format($regular_price);
					$sale_price = vifonic_price_format($sale_price);
					printf('<div class="course-price"><span class="regular-price">%2$s</span><span class="sale-price">%1$s</span></div>', $regular_price, $sale_price);
				} else {
					$regular_price = vifonic_price_format($regular_price);

					printf('<div class="course-price"><span class="sale-price"></span><span class="regular-price">%1$s</span></div>', $regular_price);
				}
				?>
                <div class="course-cart">
					<?php printf('<a href="%1$s" class="btn btn-primary">%2$s</a>', get_the_permalink(), __('Detail', 'vifonic')); ?>
                </div>
				<?php
			} else {
				?>
                <div class="course-price">
                    <span class="sale-price"></span>
                    <span class="regular-price"><?php _e('Free', 'vifonic'); ?></span>
                </div>
                <div class="course-cart">
					<?php
					printf('<a href="%1$s" class="btn btn-primary">%2$s</a>', get_the_permalink(), __('Detail', 'vifonic'));
					?>
                </div>
				<?php
			}
			?>

        </div>
    </div>
</div>