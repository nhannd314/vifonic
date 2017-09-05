<?php
/**
 * Content for teacher
 */
?>

<div class="single-teacher-item">
    <div class="teacher-thumbnail">
        <a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank">
			<?php vifonic_post_thumbnail( 'teacher-thumbnail' ) ?>
        </a>
    </div>

    <div class="teacher-detail">
        <div class="wrapper">
            <h3 class="teacher-title"><a class="relative" rel="nofollow" href="<?php the_permalink(); ?>" target="_blank"><?php the_title() ?></a></h3>
        </div>
    </div>
</div>