<?php
/**
 * The template for displaying all single teacher.
 */

get_header(); ?>

	<main class="main main-single-teacher">
		<?php vifonic_breadcrumb(); ?>
		<div class="container">
			<div class="row">
				<section class="content col-lg-12 col-md-12 col-sm-12 col-xs-12" role="main">

					<?php
					if (have_posts()):
						while (have_posts()):
							the_post();
							get_template_part('templates/loop/content', 'single-teacher');
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