<?php

// ============== Display post thumbnail ===========

if (!function_exists('vifonic_post_thumbnail'))
{
    function vifonic_post_thumbnail($size = 'thumbnail', $args = array())
    {
        if (has_post_thumbnail() && !post_password_required() || has_post_format('image')): ?>
            <?php the_post_thumbnail($size, $args); ?>
        <?php endif;
    }
}


// ============== Display post entry meta ===========

if (!function_exists('vifonic_entry_meta'))
{
    function vifonic_entry_meta($is_single = false)
    {
        ?>
        <div class="post-meta">
            <span class="author">Posted by <?php the_author_posts_link(); ?></span> |
            <span itemprop="datePublished"><?php the_time('m/d/Y') ?></span>
            <?php if ($is_single): ?>
                | <span class="list-categories"><?php echo get_the_category_list(', ') ?></span>
            <?php endif; ?>
        </div>
        <?php
    }
}


// ============== Social links ===========

if (!function_exists('vifonic_social_links'))
{
    function vifonic_social_links()
    {
        $title = get_the_title();
        $link = get_permalink();
        ?>

        <ul class="vifonic-social-share list-inline clearfix">
            <li>
                <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $link ?>','Share', 'toolbar=0,status=0,width=620,height=280');" data-toggle="tooltip" title="Share on Facebook" href="javascript:" data-original-title="Share on Facebook"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
                <a onclick="popUp=window.open('http://twitter.com/home?status=<?php echo $title ?> <?php echo $link ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-toggle="tooltip" title="Share on Twitter" href="javascript:" data-original-title="Share on Twitter"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="Share on Google +" href="javascript:" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo $link ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-original-title="Share on Google +"><i class="fa fa-google-plus"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="Share on Linkedin" onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo $link ?>&amp;title=<?php echo $title ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="Share on Linkedin"><i class="fa fa-linkedin"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="Share on Tumblr" onclick="popUp=window.open('http://www.tumblr.com/share/link?url=<?php echo $link ?>&amp;name=<?php echo $title ?>&amp;description=<?php the_excerpt() ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="Share on Tumblr"><i class="fa fa-tumblr"></i></a>
            </li>
            <li>
                <a data-toggle="tooltip" title="Share Pinterest" onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo $link ?>&amp;description=<?php echo $title ?>&amp;media=<?php the_post_thumbnail_url('full') ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:" data-original-title="Share Pinterest"><i class="fa fa-pinterest"></i></a>
            </li>
        </ul>

        <?php
    }
}


// ============= Comment Facebook ==============

if (!function_exists('vifonic_comment_facebook'))
{
    function vifonic_comment_facebook($link = '')
    {
        if ($link == '') $link = home_url('/');
        ?>
        <div class="facebook-comment responsive">
            <h4 class="title"><?php _e('Your comment', 'vifonic') ?></h4>
            <div class="fb-comments" data-href="<?php echo $link ?>" data-width="817px" data-numposts="20"></div>
        </div>
        <?php
    }
}


// ============== Show Related Posts =============

function vifonic_related_posts($ID, $content_template = '')
{
    $terms = wp_get_post_tags($ID);
    if ($terms) {
        $term_ids = array();
        foreach ($terms as $item) $term_ids[] = $item->term_id;
        $args = array(
            'tag__in' => $term_ids,
            'post__not_in' => array($ID),
            'posts_per_page' => 8,
            'ignore_sticky_posts' => 1
        );
        query_posts($args);
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('content', $content_template);
            }
        }
        wp_reset_query();
    }
}


// ============== Get excerpt ==============

function vifonic_get_the_excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . ' ...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
//    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

function vifonic_the_excerpt($limit)
{
    echo vifonic_get_the_excerpt($limit);
}

// ================ Pagination ===============

function vifonic_pagination()
{
    global $wp_query;
    if ($wp_query->max_num_pages > 1) : ?>
        <div class="pagination">
            <?php
            if (get_previous_posts_link()) echo '<li class="archive-nav-newer">' . get_previous_posts_link('&larr; ' . __('Previous', 'vifonic')) . '</li>';
            $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            $max = intval($wp_query->max_num_pages);
            /**    Add current page to the array */
            if ($paged >= 1)
                $links[] = $paged;
            /**    Add the pages around the current page to the array */
            if ($paged >= 3) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }
            if (($paged + 2) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }
            /**    Link to first page, plus ellipses if necessary */
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? ' active' : '';
                printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
                if (!in_array(2, $links))
                    echo '<li>...</li>';
            }
            /**    Link to current page, plus 2 pages in either direction if necessary */
            sort($links);
            foreach ((array)$links as $link) {
                $class = $paged == $link ? ' active' : '';
                printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
            }
            /**    Link to last page, plus ellipses if necessary */
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links))
                    echo '<li class="number">...</li>' . "\n";
                $class = $paged == $max ? ' active' : '';
                printf('<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            }
            if (get_next_posts_link()) echo '<li class="archive-nav-older">' . get_next_posts_link(__('Next', 'vifonic') . ' &rarr;') . '</li>';
            ?>
            <div class="clear"></div>
        </div> <!-- /archive-nav -->
    <?php endif;
}

// ============== Site favicon ============

function vifonic_site_favicon() {
    global $vifonic_options;
    return $vifonic_options['site_favicon']['url'];
}

function vifonic_site_logo() {
    global $vifonic_options;
    return '<img src="' . $vifonic_options['site_logo']['url'] .'" alt="' . get_bloginfo('name') .'" />';
}