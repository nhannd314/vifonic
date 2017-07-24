<?php
/**
 * The main template file.
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() ) : ?>

	<div id="breadcrumbs-wrapper">
		<div class="container">
			<h1 class="text-center title archive-title"><?php single_post_title() ?></h1>
			<?php if ( function_exists('yoast_breadcrumb') )
			{yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
		</div>
	</div>

<?php endif; ?>

<main class="main main-index">
	<div class="container">
		<div class="row">
			<section class="content col-md-9 col-sm-8 col-xs-12" role="main">

				<?php if (have_posts()):

					while (have_posts()):
						the_post();
						get_template_part('content', get_post_format());
					endwhile;

					vifonic_pagination();

				else:
					get_template_part('content', 'none');
				endif;
				?>

			</section>
			<aside class="sidebar col-md-3 col-sm-4 col-xs-12" role="complementary">

				<?php get_sidebar() ?>

			</aside>
		</div>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>
