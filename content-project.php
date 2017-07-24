<?php
/**
 * Content for project
 */
?>

<div class="project">
	<a class="relative" rel="nofollow" href="<?php the_field('link_to') ?>" target="_blank">
		<?php the_post_thumbnail( 'full' ) ?>
		<div class="caption">
			<div class="wrapper">
				<h3 class="title"><?php the_title() ?></h3>
				<div class="link"><?php the_field('link_to') ?></div>
				<div class="content"><?php the_content() ?></div>
			</div>
		</div>
		<div class="hover"></div>
		<div class="plus"><i class="fa fa-link"></i></div>
	</a>
</div>