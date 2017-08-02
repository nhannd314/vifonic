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

<!--<header id="header">
    <div class="container">
        <div class="left pull-left">
            <nav class="course-nav pull-left">
                <div class="nav-btn" id="course-nav-btn"><i class="fa fa-bars"></i> <span><?php /*_e('Categories', 'vifonic') */?></span></div>
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
                <?php /*get_search_form() */?>
            </div>
        </div>
        <div class="center pull-left">
            <div class="logo">
                <a href="<?php /*echo home_url('/') */?>"><?php /*echo vifonic_site_logo() */?></a>
            </div>
        </div>
        <div class="right pull-left text-right">
            <a class="register-login" href="#"><?php /*_e('Register', 'vifonic') */?></a>
            <a class="register-login" href="#"><?php /*_e('Login', 'vifonic') */?></a>
            <a class="active-course" href="#"><?php /*_e('Active course', 'vifonic') */?></a>
            <a class="cart" href="#" data-toggle="tooltip" data-placement="top" title="<?php /*_e('View your cart', 'vifonic' ) */?>">
                <i class="fa fa-shopping-basket"></i><span id="cart-count">2</span>
            </a>
        </div>
    </div>
</header>-->

<header id="header-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 header-left pull-left">
                <nav class="course-nav pull-left">
                    <div class="nav-btn" id="course-nav-btn"><i class="fa fa-bars"></i> <span><?php _e('Categories', 'vifonic') ?></span></div>
					<?php
					$args = array(
						'menu_class' => 'course-menu',
						'menu_id' => 'course-menu',
						'container' => 'nav',
						'container_id' => 'nav-course-categories',
						'depth' => 1,
						'theme_location' => 'main-nav',
					);
					wp_nav_menu($args);
					?>
                </nav>
                <div class="search-box pull-left">
					<?php get_search_form() ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 header-center text-center">
                <div class="logo">
                    <a href="<?php echo home_url('/') ?>"><?php echo vifonic_site_logo() ?></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 header-right pull-right">
				<?php
				if (!is_user_logged_in()){
					?>
                    <a class="register-login" data-toggle="modal" href="#modal-register"><?php _e('Register', 'vifonic') ?></a>
                    <div class="modal fade" id="modal-register">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="register-form" action="register" method="post" role="form">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                        </button>
                                        <h4 class="modal-title text-center"><?php _e('Register', 'vifonic') ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p class="status text-danger text-center"></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_fullname" id="vifonic_fullname" placeholder="<?php _e('Full Name', 'vifonic'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control" name="vifonic_email" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_mobile" id="vifonic_mobile" placeholder="<?php _e('Mobile', 'vifonic'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="vifonic_pass" id="vifonic_pass" placeholder="<?php _e('Password >= 7 character', 'vifonic'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="vifonic_pass_confirm" id="vifonic_pass_confirm" placeholder="<?php _e('Confirm Password', 'vifonic'); ?>">
                                        </div>

	                                    <?php wp_nonce_field( 'ajax-register-nonce', 'vifonic_register_security' ); ?>

                                        <p><?php _e('Already have an account?','vifonic') ?> <a class="register-login" data-toggle="modal" href="#modal-login"><?php _e('Login', 'vifonic') ?></a></p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'vifonic') ?></button>
                                        <button type="submit" class="btn btn-primary btn_register" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Register', 'vifonic') ?>"><?php _e('Register', 'vifonic') ?></button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <a class="register-login" data-toggle="modal" href="#modal-login"><?php _e('Login', 'vifonic') ?></a>
                    <div class="modal fade" id="modal-login">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                    </button>
                                    <h4 class="modal-title">Modal title</h4>
                                </div>
                                <div class="modal-body">
                                    Modal body ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
					<?php
				} else {
					$user = _wp_get_current_user();
					printf('<a class="register-login" href="%1$s">'.get_avatar($user->ID, '36').' %2$s</a>', get_edit_user_link($user->ID),$user->display_name);
				}
				?>
                <a class="active-course" href="#"><?php _e('Active course', 'vifonic') ?></a>
                <a class="cart" href="#" data-toggle="tooltip" data-placement="top" title="<?php _e('View your cart', 'vifonic' ) ?>">
                    <i class="fa fa-shopping-basket"></i><span id="cart-count">2</span>
                </a>
            </div>
        </div>
    </div>
</header>