<?php
/**
 * Content for my course
 */
?>

<div class="single-course-item">
    <div class="course-thumbnail">
        <a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank">
			<?php vifonic_post_thumbnail( 'course-thumbnail' ) ?>
        </a>
    </div>

    <div class="course-detail">
        <div class="wrapper">
            <h3 class="course-title"><a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank"><?php the_title() ?></a></h3>
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

            <div class="course-cart">
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
                if ($is_active_course){
                    printf('<a href="%1$s?lesson=1" class="btn btn-primary">%2$s</a>', get_the_permalink(), __('LEARN NOW', 'vifonic'));
                } else {
	                printf('<a href="%1$s" class="btn btn-primary">%2$s</a>', '/user/active-course/', __('ACTIVATE YOUR COURSE', 'vifonic'));
                }
                ?>
            </div>
        </div>
    </div>
</div>