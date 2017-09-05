<?php
/**
 * Template name: Full Width
 */
get_header();
?>

<?php if (get_field('show_breadcrumbs') == '1'): $breadcrumbs_background = get_field('breadcrumbs_background'); ?>

	<?php vifonic_breadcrumb(); ?>

<?php endif ?>

<main class="main main-page page-fullwidth">
	<div class="container">
		<section class="content" role="main">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post(); ?>

					<div class="post-content clearfix"><?php the_content() ?></div>
					<?php if (get_field('show_comment') == 1) vifonic_comment_facebook(get_the_permalink()) ?>

				<?php endwhile;
			else:
				get_template_part('templates/loop/content', 'none');
			endif;
			?>

		</section>
	</div>
</main><!--/ main -->

<?php get_footer(); ?>