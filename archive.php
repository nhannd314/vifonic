<?php
/**
 * The template for displaying archive pages.
 */

get_header(); ?>

<main class="main main-archive main-blog-post section">
    <div id="breadcrumbs-wrapper">
        <div class="container">

			<?php if ( function_exists('yoast_breadcrumb') )
			{ yoast_breadcrumb('<div id="breadcrumbs">','</div>'); } ?>

            <h1 class="vifonic-heading text-left">
                <i class="fa fa-newspaper-o" aria-hidden="true"></i>
				<?php
				the_archive_title();
				?>
            </h1>

        </div>
    </div>
    <div class="container">
        <div class="row blog-post-row">
            <section class="content col-xs-12 col-sm-8 col-md-9 col-lg-9" role="main">

				<?php
				if (have_posts()):
					?>
                    <div class="row">
						<?php
						$i = 0;
						while (have_posts()):
							$i++;
							the_post();
							echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
							get_template_part('templates/loop/content', get_post_format());
							echo '</div>';
							if ($i%2==0){ echo '<div class="clearfix"></div>'; }
						endwhile;
						?>
                    </div>
					<?php
					vifonic_pagination();

				else:
					get_template_part('templates/loop/content', 'none');
				endif;
				?>

            </section>
            <aside class="sidebar col-xs-12 col-sm-4 col-md-3 col-lg-3" role="complementary">
                <div class="sidebar-wrapper">
	                <?php get_sidebar() ?>
                </div>
            </aside>
        </div>
    </div>
</main><!--/ main -->

<?php get_footer(); ?>
