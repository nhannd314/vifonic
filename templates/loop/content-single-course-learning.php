<?php
/**
 * Content For Single Post
 */
?>

<?php
$course_chapter = get_field('course_chapter');
$lesson_list = array();
$count_lesson = 0;
if( !empty($course_chapter) ){
	foreach ($course_chapter as $chapter) {
		$lessons = $chapter['course_lesson'];
		if ($lessons){
			foreach ($lessons as $lesson){
				array_push($lesson_list, $lesson);
			}
			$count_lesson += count($lessons);
		}
	}
}

$lesson_id = isset($_GET['lesson']) ? $_GET['lesson'] : 0;
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
				<?php
				$lesson_video = $lesson_list[$lesson_id-1]['lesson_video'];
				echo '<iframe width="100%" height="403" src="https://www.youtube.com/embed/'.$lesson_video.'/?&autoplay=0" frameborder="0" allowfullscreen></iframe>';
				?>
            </div>

            <div class="course-tabs-wrapper">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#giao-trinh" role="tab" data-toggle="tab"><?php _e('Curriculum', 'vifonic'); ?></a></li>
                    <li><a href="#tai-lieu" role="tab" data-toggle="tab"><?php _e('Document', 'vifonic'); ?></a></li>
                    <!--                    <li><a href="#thao-luan" role="tab" data-toggle="tab">--><?php //_e('Discussion', 'vifonic'); ?><!--</a></li>-->
                    <li><a href="#gioi-thieu" role="tab" data-toggle="tab"><?php _e('Introduce', 'vifonic'); ?></a></li>
                    <li><a href="#doi-tuong" role="tab" data-toggle="tab"><?php _e('Target', 'vifonic'); ?></a></li>
                    <li><a href="#muc-tieu" role="tab" data-toggle="tab"><?php _e('Aim', 'vifonic'); ?></a></li>

                    <li><a href="#giang-vien" role="tab" data-toggle="tab"><?php _e('Teacher', 'vifonic'); ?></a></li>
                </ul>
                <!-- TAB CONTENT -->
                <div class="tab-content">
                    <div class="active tab-pane fade in" id="giao-trinh">
				        <?php
				        if( get_field('course_chapter') ): ?>

                            <div class="row course_chapter">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <ul class="chapter-list">
								        <?php
								        $i = 0;
								        while( has_sub_field('course_chapter') ):
									        $chapter_title = get_sub_field('chapter_title');
									        $course_lesson = get_sub_field('course_lesson');
									        echo '<li class="chapter-item"><span><strong>'.$chapter_title.'</strong></span>';
									        if ($course_lesson){
										        echo '<ul class="lesson-list">';
										        foreach ($course_lesson as $lesson){
											        $i++;
											        printf('<li class="lesson-item"><a href="%1$s?lesson=%2$s">%3$s</a></li>', get_the_permalink(), $i, $lesson['lesson_title']);
										        }
										        echo '</ul>';
									        }
									        echo '</li>';
								        endwhile;
								        ?>
                                    </ul>
                                </div>
                            </div>

				        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="tai-lieu">
                        <div class="file-list">
					        <?php
					        $document = get_field('course_document');
					        if( get_field('course_document') ){
						        while( has_sub_field('course_document') ){
							        $file = get_sub_field('course_file');
							        printf('<p><a href="%1$s"><i class="fa fa-download" aria-hidden="true"></i>%2$s</a></p>', esc_url($file['url']), $file['filename']);
						        }
					        }
					        ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="gioi-thieu">
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
                    <div class="tab-pane fade" id="giang-vien">
				        <?php vifonic_title('Giảng viên','','left'); ?>
                        <div class="course-content clearfix">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 teacher-avatar">
                                    <img src="<?php the_field('teacher_avatar',get_the_ID()); ?>" alt="">
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-9 col-lg-9 teacher-desc">
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
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 course-reviews">
            <div class="course-reviews-wrapper">
			    <?php
			    vifonic_title('Thảo luận','','left');
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