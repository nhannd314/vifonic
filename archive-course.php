<?php
/**
 * The archive for projects
 */

get_header(); ?>

<div id="breadcrumbs-wrapper">
    <div class="container">
        <h1 class="text-center title archive-title">DỰ ÁN THIẾT KẾ WEBSITE</h1>
        <h2 class="text-center title archive-description">Những dự án thiết kế website gần đây nhất mà Vifonic đã thực hiện</h2>

        <?php if ( function_exists('yoast_breadcrumb') )
        {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

    </div>
</div>

<main class="main main-project section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">DỰ ÁN THIẾT KẾ WEBSITE TIÊU BIỂU</h2>
            <img class="header-bottom-line" src="<?php echo get_template_directory_uri() ?>/img/styled-line.png" alt="">
            <p class="text-center section-sub-title">
                Mỗi dự án là một đứa con cưng, mỗi khách hàng là một ông chủ lớn!
            </p>
        </div>
        <div class="section-content">

            <?php if (have_posts()): ?>

                <div class="row">

                    <?php
                    $i = 0;
                    while (have_posts()) {
                        $i++;
                        the_post();
                        echo '<div class="col-md-4 col-sm-6 col-xs-12 col">';
                        get_template_part('content', 'project2');
                        echo '</div>';
                        if ( $i % 3 == 0) echo '<div class="col-xs-12 hidden-xs"></div>';
                    }
                    ?>

                </div>

                <?php vifonic_pagination() ?>

            <?php endif; wp_reset_query(); ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>