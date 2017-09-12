<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 23/08/2017
 * Time: 9:07 SA
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope="" itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	        <?php vifonic_post_thumbnail( 'teacher-thumbnail' ) ?>
        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
	        <?php the_content(); ?>
        </div>
    </div>

    <?php
//    vifonic_title('Các khóa học của '.get_the_title(),'','left');
//    vifonic_show_list_courses_by_teacher(get_the_ID(), -1);
    ?>

</article><!-- #post-## -->