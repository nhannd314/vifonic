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

$action = isset($_GET['action']) ? $_GET['action'] : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="course-overview">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="curriculum-wrapper">
				    <?php
				    if( get_field('course_chapter') ): ?>

                        <div class="row course_chapter">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
											    printf('<li class="lesson-item"><a href="%1$s?action=learning&lesson=%2$s"><div class="lesson-wrapper"><p class="lesson-number">%3$s %2$s:</p><p class="lesson-title">%4$s</p></div></a></li>', get_the_permalink(), $i, __('Lesson', 'vifonic'), $lesson['lesson_title']);
											    $i++;
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
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			    <?php comments_template(); ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
