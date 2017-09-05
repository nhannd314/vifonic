<?php
/**
 * Template name: Contact
 */
get_header();

?>

<main class="main main-page page-contact full-width">
	<div class="container">
		<section class="content vifonic-section" role="main">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post(); ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h1 class="title">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="post-content clearfix">
                                <?php
                                the_content();
                                echo do_shortcode('[vifonic_social_follow]');
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="contact-map"><?php the_field('contact_map'); ?></div>
                        </div>
                    </div>



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