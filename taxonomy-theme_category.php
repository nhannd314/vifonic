<?php
/**
 * The archive for theme
 */

get_header(); ?>

    <div id="breadcrumbs-wrapper">
        <div class="container">

            <?php if ( function_exists('yoast_breadcrumb') )
            {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

        </div>
    </div>
    <div class="theme-cat-menu-wrap">
        <div class="container">
            <div class="hidden-xs">

                <?php wp_nav_menu(array(
                    'theme_location' => 'theme-cat-nav',
                    'menu_id' => 'theme-cat-menu'
                )) ?>

            </div>
            <div class="visible-xs">
                <div id="theme-cat-menu-mobile-toggle"><i class="fa fa-reorder"></i></div>

                <?php wp_nav_menu(array(
                    'theme_location' => 'theme-cat-nav',
                    'menu_id' => 'theme-cat-menu-mobile'
                )) ?>

            </div>
        </div>
    </div>

    <main class="main main-theme section">
        <div class="container">
            <h1 class="vifonic-heading text-center">
                <?php
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                echo 'Danh mục: '.$term->name;
                ?>
            </h1>
            <div class="section-content">

                <?php if (have_posts()): ?>

                    <div class="row">

                        <?php
                        $i = 0;
                        while (have_posts()) {
                            $i++;
                            the_post();
                            get_template_part('content', 'theme');
                            if ($i%4 == 0) echo '<div class="col-xs-12 hidden-xs"></div>';
                        }
                        ?>

                    </div>

                    <?php vifonic_pagination() ?>

                <?php endif; wp_reset_query(); ?>

            </div>
        </div>
    </main>

<?php get_footer(); ?>