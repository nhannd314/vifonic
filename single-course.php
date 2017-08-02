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
						get_template_part('templates/loop/content', 'single-course');
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