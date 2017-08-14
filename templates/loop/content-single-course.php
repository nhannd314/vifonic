<?php
/**
 * Content For Single Post
 */
?>

<?php
$course_chapter = get_field('course_chapter');
$count_lesson = 0;
if( !empty($course_chapter) ){
	foreach ($course_chapter as $chapter) {
		$lesson = $chapter['course_lesson'];
		$count_lesson += count($lesson);
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="row single-course-heading">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <h1 class="course-title title" itemprop="name">
				<?php the_title(); ?>
            </h1>
            <p class="course-desc"><?php vifonic_the_excerpt(100); ?></p>
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
			<?php printf('<p class="course-teacher">%1$s <strong>%2$s</strong></p>', __('Teacher:', 'vifonic'), get_field( 'teacher_name', get_the_ID()) ); ?>
        </div>
    </div>

    <div class="row single-course-primary">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 course-video-demo">
            <div class="course-video-wrapper">
				<?php the_post_thumbnail('full') ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 course-information">
			<?php
			$is_free = get_field('free_course', get_the_ID());
			if (!$is_free) {
				$regular_price = get_field('regular_price');
				$sale_price = get_field('sale_price');
				if ($sale_price > 0){
					$regular_price = vifonic_price_format($regular_price);
					$sale_price = vifonic_price_format($sale_price);
					printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%1$s</span><span class="sale-price">%2$s</span></div>', $sale_price, $regular_price);
				} else {
					$regular_price = vifonic_price_format($regular_price);

					printf('<div class="course-price"><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">%1$s</span></div>', $regular_price);
				}
				?>
                <div class="course-cart form-group form-inline">
                    <form class="buy-now-form" action="/order/detail/" method="post" style="display: inline-block;" role="form">
                        <input type="hidden" name="vifonic_course_id" id="vifonic_course_id" value="<?php echo get_the_ID(); ?>">
						<?php wp_nonce_field( 'ajax-add-to-cart-nonce', 'vifonic_add_to_cart_security' ); ?>
                        <button type="submit" class="btn btn-warning btn-buy-now vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('BUY NOW', 'vifonic') ?>">
							<?php _e('BUY NOW', 'vifonic'); ?>
                        </button>
                    </form>
                    <!--<div class="clearfix"><br></div>-->
                    <form class="add-to-cart-form" action="/cart/" method="post" style="display: inline-block;" role="form">
                        <input type="hidden" name="vifonic_course_id" id="vifonic_course_id" value="<?php echo get_the_ID(); ?>">
						<?php wp_nonce_field( 'ajax-add-to-cart-nonce', 'vifonic_add_to_cart_security' ); ?>
                        <button type="submit" class="btn btn-primary btn-add-to-cart vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('ADD TO CART', 'vifonic'); ?>">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<?php _e('ADD TO CART', 'vifonic'); ?>
                        </button>
                    </form>
                </div>
                <!--Form add coupon-->
                <form id="add-coupon-form" action="/order/detail/" method="post" role="form">
                    <div class="course-coupon form-group form-inline">
                        <input type="text" class="form-control" name="vifonic_coupon" id="vifonic_coupon" placeholder="<?php _e('Input coupon code here...', 'vifonic') ?>" >
						<?php wp_nonce_field( 'ajax-add-coupon-nonce', 'vifonic_add_coupon_security' ); ?>
                        <button type="button" class="btn btn-primary btn-add-coupon vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Apply', 'vifonic') ?>" ><?php _e('Apply', 'vifonic') ?></button>
                        <p class="status text-danger"></p>
                    </div>
                </form>
				<?php
			} else {
				?>
                <div class="course-price">
                    <span class="sale-price"></span>
                    <img class="free-tag" src="<?php echo get_stylesheet_directory_uri(); ?>/img/free.png" width="32px" alt="Miễn phí">
                    <span class="regular-price"><?php _e('Free', 'vifonic'); ?></span>
                </div>
                <div class="course-cart">
                    <a href="#" class="btn btn-primary">
						<?php _e('LEARN NOW', 'vifonic'); ?>
                    </a>
                </div>
				<?php
			}
			?>
            <div class="course-warning-error">
                <button type="submit" class="btn btn-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
					<?php _e('Error!', 'vifonic'); ?></button>
            </div>
            <div class="course-lesson-time">
				<?php
				printf('<p><span class="lesson-time"><i class="fa fa-file-text-o" aria-hidden="true"></i>%1$s</span> %2$s</p>
                                    <p><span class="lesson-time"><i class="fa fa-clock-o" aria-hidden="true"></i>%3$s</span> %4$s</p>'
					, $count_lesson, __('Lesson', 'vifonic'), '2h30p', __('Lesson duration', 'vifonic'));
				?>
            </div>
            <div class="course-social-share">
				<?php vifonic_social_links(); ?>
            </div>
        </div>
    </div>
    <div class="row single-course-secondary">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-tabs">
            <div class="course-tabs-wrapper">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#gioi-thieu" role="tab" data-toggle="tab">Giới thiệu</a></li>
                    <li><a href="#doi-tuong" role="tab" data-toggle="tab">Đối tượng</a></li>
                    <li><a href="#muc-tieu" role="tab" data-toggle="tab">Mục tiêu</a></li>
                    <li><a href="#giao-trinh" role="tab" data-toggle="tab">Giáo trình</a></li>
                    <li><a href="#giang-vien" role="tab" data-toggle="tab">Giảng viên</a></li>
                </ul>
                <!-- TAB CONTENT -->
                <div class="tab-content">
                    <div class="active tab-pane fade in" id="gioi-thieu">
						<?php vifonic_title('Giới thiệu','','left'); ?>
                        <div class="course-content clearfix"><?php the_content() ?></div>
                    </div>
                    <div class="tab-pane fade" id="doi-tuong">
						<?php vifonic_title('Đối tượng','','left'); ?>
                        <div class="course-content clearfix"><?php the_field('course_subjects'); ?></div>
                    </div>
                    <div class="tab-pane fade" id="muc-tieu">
						<?php vifonic_title('Mục tiêu','','left'); ?>
                        <div class="course-content clearfix"><?php the_field('course_target'); ?></div>
                    </div>
                    <div class="tab-pane fade" id="giao-trinh">
						<?php
						vifonic_title('Giáo trình','','left');

						if( have_rows('course_chapter') ): ?>

                            <div class="row course_chapter">
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <ul class="chapter-list">
										<?php
										while( have_rows('course_chapter') ): the_row();
											// vars
											$chapter_title = get_sub_field('chapter_title');
											$course_lesson = get_sub_field('course_lesson');
											echo '<li class="chapter-item"><strong>'.$chapter_title.'</strong>';
											if ($course_lesson){
												echo '<ul class="lesson-list">';
												foreach ($course_lesson as $lesson){
													echo '<li class="lesson-item">'.$lesson['lesson_title'].'</li>';
												}
												echo '</ul>';
											}
											echo '</li>';
										endwhile;
										?>
                                    </ul>
                                </div>
                            </div>

						<?php endif;

						?>

                    </div>
                    <div class="tab-pane fade" id="giang-vien">
						<?php vifonic_title('Giảng viên','','left'); ?>
                        <div class="course-content clearfix">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 teacher-avatar">
                                    <img src="<?php the_field('teacher_avatar',get_the_ID()); ?>" alt="">
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10 teacher-desc">
                                    <p><strong><?php the_field('teacher_name'); ?></strong></p>
                                    <div class="teacher-info">
										<?php the_field('teacher_info') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <hr>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 course-reviews">
            <div class="course-reviews-wrapper">
				<?php
				vifonic_title('Đánh giá của học viên','','left');
				comments_template();
				vifonic_comment_facebook(get_the_permalink());
				?>
            </div>
        </div>
    </div>

    <div class="related-courses">

		<?php vifonic_related_courses(get_the_ID(), 'course') ?>

    </div>



    <div class="tags clearfix">
		<?php echo get_the_tag_list('<i class="fa fa-tags"></i> Tags: ', ', ', '') ?>
    </div>



</article><!-- #post-## -->
