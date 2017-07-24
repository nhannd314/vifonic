<?php
/**
 * The header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
global $vifonic_options;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo $vifonic_options['favicon']['url'] ?>" type="image/x-icon">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<nav id="top-bar">
    <div class="container">
        <div class="pull-left">
            <?php dynamic_sidebar('sidebar-top-left') ?>
        </div>
        <div class="pull-right">
            <?php dynamic_sidebar('sidebar-top-right') ?>
        </div>
    </div>
</nav>

<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 header-left">
                <div class="logo">

                    <?php if (is_front_page()): ?>
                        <h1 style="width: 150px; height: 100px; margin: 0 0 -100px 0; position: relative; top: -250px; font-size: 18px" class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home" title="<?php bloginfo('name') ?>">
                                <?php bloginfo( 'name' ) ?>
                            </a>
                        </h1>
                    <?php endif; ?>

                    <a href="<?php echo home_url('/') ?>" title="<?php bloginfo('name') ?>">
                        <img src="<?php echo $vifonic_options['site-logo']['url'] ?>" alt="<?php bloginfo('name') ?>">
                    </a>

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 header-right text-right">
                <a rel="nofollow" title="<?php bloginfo('name') ?>" href="<?php echo home_url() ?>">
                    <img src="<?php echo $vifonic_options['header-banner']['url'] ?>" alt="<?php bloginfo('name') ?>" title="<?php bloginfo('name') ?>">
                </a>
            </div>
        </div>
    </div>
</header>
<style>
    #header .logo img { max-width: <?php echo $vifonic_options['site-logo-width'] ?>px; margin-top: <?php echo $vifonic_options['site-logo-mgt'] ?>px }
</style>
<nav id="main-nav">
    <div class="container">
        <div class="pull-left">

            <?php wp_nav_menu(array(
                'theme_location' => 'main-nav-left'
            )) ?>

        </div>
        <div class="pull-right">

            <?php wp_nav_menu(array(
                'theme_location' => 'main-nav-right'
            )) ?>

        </div>
    </div>
</nav>

<div id="main-nav-mobile">
    <div id="mobile-menu-toggle"><i class="fa fa-reorder"></i></div>
    <div id="mobile-menu-wrapper">

        <?php
        wp_nav_menu(array(
            'theme_location' => 'main-nav-left'
        ));
        wp_nav_menu(array(
            'theme_location' => 'main-nav-right'
        ));
        ?>

    </div>
</div>