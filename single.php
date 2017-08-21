<?php
/**
 * The template for displaying all single posts.
 */

get_header(); ?>

<main class="main main-single main-blog-post">
    <div id="breadcrumbs-wrapper">
        <div class="container">

			<?php if ( function_exists('yoast_breadcrumb') )
			{ yoast_breadcrumb('<div id="breadcrumbs">','</div>'); } ?>

            <h1 class="vifonic-heading text-left">
                <i class="fa fa-newspaper-o" aria-hidden="true"></i>
				<?php
				the_title();
				?>
            </h1>

        </div>
    </div>
	<div class="container">
		<div class="row blog-post-row">
			<section class="content col-md-9 col-sm-8 col-xs-12" role="main">

				<?php
				if (have_posts()):
					while (have_posts()):
						the_post();
						get_template_part('templates/loop/content', 'single');
					endwhile;

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