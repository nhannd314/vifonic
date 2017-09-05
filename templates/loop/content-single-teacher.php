<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 23/08/2017
 * Time: 9:07 SA
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <?php the_content(); ?>

    <?php
    vifonic_title('Các khóa học của '.get_the_title(),'','left');
    vifonic_show_list_courses_by_teacher(get_the_ID(), -1);
    ?>

</article><!-- #post-## -->