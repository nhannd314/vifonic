<?php
/**
 * The header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo vifonic_site_favicon() ?>" type="image/x-icon">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<nav id="top-bar">
    <div class="container">
        <div class="pull-left left">
            <?php dynamic_sidebar('sidebar-top-left') ?>
        </div>
        <div class="pull-right right">
            <?php dynamic_sidebar('sidebar-top-right') ?>
        </div>
    </div>
</nav>

<header id="header">
    <div class="container">
        <div class="left pull-left">
            <nav class="course-nav pull-left">
                <div class="nav-btn" id="course-nav-btn"><i class="fa fa-bars"></i> <span><?php _e('Categories', 'vifonic') ?></span></div>
                <ul class="course-menu" id="course-menu">
                    <li><a href="#"><i class="fa fa-heart"></i> Nha khoa cơ bản</a></li>
                    <li><a href="#"><i class="fa fa-heartbeat"></i> Nha khoa nâng cao</a></li>
                    <li><a href="#"><i class="fa fa-user-plus"></i> Nha khoa lâm sàng</a></li>
                    <li><a href="#"><i class="fa fa-ambulance"></i> Đa khoa chuyên sâu</a></li>
                    <li><a href="#"><i class="fa fa-heart"></i> Nha khoa cơ bản</a></li>
                    <li><a href="#"><i class="fa fa-heart"></i> Nha khoa cơ bản</a></li>
                    <li><a href="#"><i class="fa fa-heart"></i> Nha khoa cơ bản</a></li>
                </ul>
            </nav>
            <div class="search-box pull-left">
                <?php get_search_form() ?>
            </div>
        </div>
        <div class="center pull-left">
            <div class="logo">
                <a href="<?php echo home_url('/') ?>"><?php echo vifonic_site_logo() ?></a>
            </div>
        </div>
        <div class="right pull-left text-right">
            <a class="register-login" href="#"><?php _e('Register', 'vifonic') ?></a>
            <a class="register-login" href="#"><?php _e('Login', 'vifonic') ?></a>
            <a class="active-course" href="#"><?php _e('Active course', 'vifonic') ?></a>
            <a class="cart" href="#" data-toggle="tooltip" data-placement="top" title="<?php _e('View your cart', 'vifonic' ) ?>">
                <i class="fa fa-shopping-basket"></i><span id="cart-count">2</span>
            </a>
        </div>
    </div>
</header>

<div id="slider">
    <img src="<?php echo get_template_directory_uri() ?>/img/slider.jpg" alt="slider" />
</div>