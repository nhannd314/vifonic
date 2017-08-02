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

<main class="main main-404">
	<div class="container text-center">

		<h1 class="page-title title"><?php esc_html_e( '404. Page not found!', 'vifonic' ); ?></h1>

		<img src="<?php echo get_template_directory_uri() ?>/img/logo.png" alt="404-page">

		<p><?php esc_html_e('It seem like the content you look is not exist', 'vifonic') ?></p>

		<p><?php esc_html_e('Try to search in website:', 'vifonic') ?></p>

		<?php get_search_form() ?>

		<p><?php esc_html_e('Or return to', 'vifonic') ?> <a href="<?php echo home_url('/') ?>"><?php esc_html_e('Home page', 'vifonic') ?></a></p>

	</div>
</main>

<?php get_footer(); ?>