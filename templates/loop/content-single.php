<?php
/**
 * Content For Single Post
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="single-header">
        <h1 class="post-title title single-title" itemprop="name">
		    <?php the_title(); ?>
        </h1>

        <div class="clearfix post-meta-like-share">
            <div class="pull-left">
			    <?php vifonic_entry_meta() ?>
            </div>

        </div>
    </div>


	<div class="post-content clearfix"><?php the_content() ?></div>

	<div class="tags clearfix">
		<?php echo get_the_tag_list('<i class="fa fa-tags"></i> Tags: ', ', ', '') ?>
	</div>

    <?php vifonic_related_posts(get_the_ID()) ?>

	<?php vifonic_comment_facebook(get_the_permalink()) ?>



</article><!-- #post-## -->
