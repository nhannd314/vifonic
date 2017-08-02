<?php
/**
 * The template for displaying search result page.
 */

get_header(); ?>

<main class="main main-search">
    <div id="breadcrumbs-wrapper">
        <div class="container">

			<?php if ( function_exists('yoast_breadcrumb') )
			{ yoast_breadcrumb('<div id="breadcrumbs">','</div>'); } ?>

            <h1 class="vifonic-heading text-left">
                <i class="fa fa-book" aria-hidden="true"></i>
                 <?php printf(__('Search results for: "%1$s"', 'vifonic'), get_search_query()); ?>
            </h1>

        </div>
    </div>
	<div class="container">
		<div class="row">
			<section class="content col-lg-12 col-md-12 col-sm-12 col-xs-12" role="main">

				<?php
				if (have_posts()):

					vifonic_title("Các khóa học được tìm thấy", "","center");

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

					<?php
					vifonic_pagination();

				else:
					get_template_part('templates/loop/content', 'none');
				endif;
				?>

			</section>
			<!--<aside class="sidebar col-md-3 col-sm-4 col-xs-12" role="complementary">

				<?php /*get_sidebar() */?>

			</aside>-->
		</div>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>