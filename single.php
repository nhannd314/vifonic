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

<main class="main main-single">
	<div class="container">
		<div class="row">
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
			<aside class="sidebar col-md-3 col-sm-4 col-xs-12" role="complementary">

				<?php get_sidebar() ?>

			</aside>
		</div>
	</div>
</main><!--/ main -->

<div class="random-posts">
	<div class="container">
		<h3 class="title random-posts-title">CÓ THỂ BẠN QUAN TÂM</h3>
		<div class="row">

			<?php
			query_posts(array(
				'post_type'			=> 'post',
				'posts_per_page'	=> 4,
				'orderby' => 'rand',
				'meta_query'	    => array()
			));

			if (have_posts()) {
				$i = 0;
				while (have_posts()) {
					$i++;
					the_post();
					echo '<div class="col-md-6 col-sm-6 col-xs-12 col">';
					get_template_part('templates/loop/content', 'home');
					echo '</div>';
					if ($i % 2 == 0) echo '<div class="col-xs-12 hidden-xs"></div>';
				}
			}
			wp_reset_query();
			?>

		</div>
	</div>
</div>

<?php get_footer(); ?>