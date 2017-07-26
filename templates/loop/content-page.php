<?php
/**
 * Content For Page
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

	<h1 class="post-title title" itemprop="name">
		<?php the_title(); ?>
	</h1>

	<div class="clearfix post-meta-like-share">
		<div class="pull-left">
			<?php vifonic_entry_meta(true) ?>
		</div>
	</div>

	<div class="post-content clearfix"><?php the_content() ?></div>

	<?php vifonic_comment_facebook(get_the_permalink()) ?>

</article><!-- #post-## -->