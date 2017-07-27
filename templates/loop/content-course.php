<?php
/**
 * Content for course
 */
?>

<div class="single-course">
	<a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank">
        <div class="course-thumbnail">
            <?php vifonic_post_thumbnail( 'full' ) ?>
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
                    <span class="rating-text">0 đánh giá</span>
                </div>
                <p class="course-teachcher">Giảng viên: Nguyễn Đức Nam</p>
                <div class="course-price">
                    <span class="sale-price">1,200,000đ</span><i class="fa fa-money" aria-hidden="true"></i><span class="regular-price">249,000đ</span>
                </div>
                <div class="course-add-to-cart">
                    <button type="button" class="btn btn-warning btn-add-to-cart"><?php _e('MUA NGAY', 'vifonic'); ?></button>
                </div>
			</div>
		</div>
	</a>
</div>