<?php
/**
 * The template for displaying all single posts.
 */

get_header(); ?>

<div id="breadcrumbs-wrapper">
	<div class="container">

		<?php if ( function_exists('yoast_breadcrumb') )
		{yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

	</div>
</div>

<main class="main main-single-course">
	<div class="container">
		<div class="row">
			<section class="content col-lg-12 col-md-12 col-sm-12 col-xs-12" role="main">

				<?php
				if (have_posts()):
					while (have_posts()):
						the_post();
						$case = '';

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

							$lesson_id = isset($_GET['lesson']) ? $_GET['lesson'] : '';

							if ($lesson_id != ''){
								$is_free = get_field('free_course', get_the_ID());
								if($is_free){
									$case = 'free';
								}

								$user = wp_get_current_user();
								$my_course_list = get_field('profile_my_course_list', 'user_'.$user->ID);
								foreach ($my_course_list as $my_course) {
									if (get_the_ID() == $my_course['profile_my_course']) {
										if ( $my_course['profile_is_active_course'] == true ) {
											if ( 0 < intval($lesson_id)
											     && intval($lesson_id) <= $count_lesson && $count_lesson > 0 ) {
												$case = 'learning';
											} else {
												$case = 'none';
											}
											break;
										} elseif ( $my_course['profile_is_active_course'] == false){
											$case = 'not_active';
											break;
										}
									}
								}
							}
						} else {
						    $case = 'none';
                        }

                        switch ($case){
                            case 'learning':
                            case 'free':
	                            get_template_part('templates/loop/content', 'single-course-learning');
                                break;
                            case 'not_active':
	                            printf('<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="alert-message">%1$s</span></div>', __('This course has not been activated!', 'vifonic'));
	                            get_template_part('templates/loop/content', 'single-course');
                                break;
                            case 'none':
	                            printf('<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="alert-message">%1$s</span></div>', __('Nothing found!', 'vifonic'));
	                            get_template_part('templates/loop/content', 'none');
                                break;
                            default: get_template_part('templates/loop/content', 'single-course');
                        }
					endwhile;

					vifonic_pagination();

				else:
					get_template_part('templates/loop/content', 'none');
				endif;
				?>

			</section>
		</div>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>