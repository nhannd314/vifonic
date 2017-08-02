<?php
/**
 * The template for displaying search result page.
 */

get_header(); ?>

<div id="breadcrumbs-wrapper">
	<div class="container">
		<h1 class="text-center title archive-title">Search Results for: <?php echo get_search_query() ?></h1>
		<?php if ( function_exists('yoast_breadcrumb') )
		{yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
	</div>
</div>

<main class="main main-search">
	<div class="container">
		<div class="row">
			<section class="content col-md-9 col-sm-8 col-xs-12" role="main">

				<?php
				if (have_posts()):

					while (have_posts()):
						the_post();
						get_template_part('templates/loop/content', get_post_format());
					endwhile;

					vifonic_pagination();

				else:
					get_template_part('templates/loop/content', 'none');
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