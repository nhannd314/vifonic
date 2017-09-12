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
$next_lesson = 1;
if ($lesson_id < $count_lesson) {
    $next_lesson = $lesson_id + 1;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

    <div class="row single-course-primary">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-content">
            <div class="course-top-action clearfix">
                <a class="btn-action btn-go-back" href="<?php the_permalink() ?>?action=overview"><i class="fa fa-backward"></i><?php _e('Go back', 'vifonic'); ?></a>
                <a class="btn-action btn-full-width" href="#"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
            </div>
            <div class="course-video-wrapper">
				<?php $lesson_video = $lesson_list[$lesson_id-1]['lesson_video']; ?>
                <iframe class="video-frame" src="https://www.youtube.com/embed/<?php echo $lesson_video ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="course-bottom-action clearfix">
                <?php
                if ($lesson_id < $count_lesson) {
	                ?>
                    <a class="btn-action btn-next-lesson" href="<?php the_permalink() ?>?action=learning&lesson=<?php echo $next_lesson; ?>">Bài tiếp theo <i class="fa fa-fast-forward"></i></a>
	                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sidebar">
            <div class="course-detail-wrapper">
                <div class="course-tabs">
                    <div class="course-tabs-wrapper">
                        <!-- TAB NAVIGATION -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#giao-trinh" role="tab" data-toggle="tab"><?php _e('Curriculum', 'vifonic'); ?></a></li>
                            <li><a href="#tai-lieu" role="tab" data-toggle="tab"><?php _e('Document', 'vifonic'); ?></a></li>
                            <li><a href="#trac-nghiem" role="tab" data-toggle="tab"><?php _e('Test', 'vifonic'); ?></a></li>
                            <li><a href="#thao-luan" role="tab" data-toggle="tab"><?php _e('Comment', 'vifonic'); ?></a></li>
                        </ul>
                        <!-- TAB CONTENT -->
                        <div class="tab-content">
                            <div class="active tab-pane fade in" id="giao-trinh">
						        <?php
						        if( get_field('course_chapter') ): ?>

                                    <div class="course_chapter">
                                        <ul class="chapter-list">
                                            <?php
                                            $i = 1;
                                            while( have_rows('course_chapter') ): the_row();
                                                // vars
                                                $chapter_title = get_sub_field('chapter_title');
                                                $course_lesson = get_sub_field('course_lesson');
                                                echo '<li class="chapter-item"><h4 class="chapter-title">'.$chapter_title.'</h4>';
                                                if ($course_lesson){
                                                    echo '<ul class="lesson-list">';
                                                    foreach ($course_lesson as $lesson){
                                                        $current_class = '';
                                                        if ($lesson_id == $i) {
                                                            $current_class = 'current';
                                                        } else {
                                                            $current_class = '';
                                                        }
                                                        printf('<li class="lesson-item %1$s"><a href="%2$s?action=learning&lesson=%3$s"><div class="lesson-wrapper"><p class="lesson-number">%4$s %3$s:</p><p class="lesson-title">%5$s</p></div></a></li>', $current_class, get_the_permalink(), $i, __('Lesson', 'vifonic'), $lesson['lesson_title']);
                                                        $i++;
                                                    }
                                                    echo '</ul>';
                                                }
                                                echo '</li>';
                                            endwhile;
                                            ?>
                                        </ul>
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
                            <div class="tab-pane fade" id="trac-nghiem">
                                <h4>Trắc nghiệm khóa học</h4>
						        <?php //vifonic_title('Trắc nghiệm khóa học','','left'); ?>
                                <div class="course-content clearfix"><?php the_field('course_test'); ?></div>
                            </div>
                            <div class="tab-pane fade" id="thao-luan">
                                <div class="course-reviews">
                                    <div class="course-reviews-wrapper">
			                            <?php
			                            //vifonic_title('Thảo luận','','left');
			                            comments_template();
			                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</article><!-- #post-## -->

<style type="text/css">

</style>
<script type="text/javascript">
    jQuery("main.main-single-course > .main-single-course-wrapper").removeClass("container");
    jQuery("main.main-single-course > .main-single-course-wrapper").addClass("single-course-learning-wrapper container-fluid");
    jQuery("body").addClass("single-course-learning");

    jQuery(document).ready(function () {
        var col_content = jQuery(".col-content");
        var col_sidebar = jQuery(".col-sidebar");
        jQuery(".course-top-action .btn-full-width").click(function () {
            if(!col_content.hasClass("full-width")){
                col_content.css("width","100%");
                col_content.addClass("full-width");
                col_sidebar.css("display","none");
            } else {
                col_content.css("width","");
                col_content.removeClass("full-width");
                col_sidebar.css("display","");
            }
        });
    });
</script>