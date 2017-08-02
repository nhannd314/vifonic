<?php
/**
 * The archive for projects
 */

get_header(); ?>

    <main class="main main-course_category section">
        <div id="breadcrumbs-wrapper">
            <div class="container">

				<?php if ( function_exists('yoast_breadcrumb') )
				{ yoast_breadcrumb('<div id="breadcrumbs">','</div>'); } ?>

                <h1 class="vifonic-heading text-left">
                    <i class="fa fa-book" aria-hidden="true"></i>
					<?php
					the_archive_title();
					?>
                </h1>

            </div>
        </div>
        <div class="container">

            <div class="section-content">

	            <?php if (have_posts()): ?>

		            <?php
		            vifonic_title("Các khóa học nổi bật", "","left");
		            vifonic_show_featured_courses_slider_by_category('',8);

		            vifonic_title("Tất cả khóa học", "","left");
		            ?>

                    <div class="row">

			            <?php
			            $i = 0;
			            while (have_posts()) {
				            $i++;
				            the_post();
				            echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
				            get_template_part('templates/loop/content', 'course');
				            echo '</div>';
				            if ($i%4==0){ echo '<div class="clearfix"></div>'; }
			            }
			            ?>

                    </div>

		            <?php vifonic_pagination() ?>

		            <?php
		            vifonic_title("KHÓA HỌC ONLINE MIỄN PHÍ", "","center");
		            vifonic_show_free_courses_slider_by_category();
		            ?>

	            <?php endif; wp_reset_query(); ?>

            </div>
        </div>
    </main>

<?php get_footer(); ?>