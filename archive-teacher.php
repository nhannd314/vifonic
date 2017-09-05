<?php
/**
 * The archive for projects
 */

get_header(); ?>

    <main class="main main-teacher_category section">
	    <?php vifonic_breadcrumb(); ?>
        <div class="container">

            <div class="section-content">

	            <?php if (have_posts()): ?>

		            <?php
		            vifonic_title("Tất cả giảng viên", "","left");
		            ?>

                    <div class="row">

			            <?php
			            $i = 0;
			            while (have_posts()) {
				            $i++;
				            the_post();
				            echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">';
				            get_template_part('templates/loop/content', 'teacher');
				            echo '</div>';
				            if ($i%6==0){ echo '<div class="clearfix"></div>'; }
			            }
			            ?>

                    </div>

		            <?php vifonic_pagination() ?>

	            <?php endif; wp_reset_query(); ?>

            </div>
        </div>
    </main>

<?php get_footer(); ?>