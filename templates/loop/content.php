<?php
/**
 * Default Content
 */
?>

<article class="post-item clearfix" role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="post-image">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	        <?php vifonic_post_thumbnail('post-thumbnail') ?>
        </a>
    </div>
    <div class="post-text">
        <h3 class="post-title title" itemprop="name">
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			    <?php the_title(); ?>
            </a>
        </h3>

	    <?php vifonic_entry_meta() ?>

        <div class="post-excerpt"><?php vifonic_the_excerpt(20); ?></div>
    </div>
</article>