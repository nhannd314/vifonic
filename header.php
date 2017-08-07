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
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 header-left pull-left text-left">
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
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 header-right pull-right text-right">
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
                                            <input type="text" class="form-control" name="vifonic_fullname" id="vifonic_fullname" placeholder="<?php _e('Full Name', 'vifonic'); ?>" >
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control" name="vifonic_email" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>" >
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_mobile" id="vifonic_mobile" placeholder="<?php _e('Mobile', 'vifonic'); ?>" >
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="vifonic_pass" id="vifonic_pass" placeholder="<?php _e('Password >= 7 character', 'vifonic'); ?>" >
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="vifonic_pass_confirm" id="vifonic_pass_confirm" placeholder="<?php _e('Confirm Password', 'vifonic'); ?>">
                                        </div>

										<?php wp_nonce_field( 'ajax-register-nonce', 'vifonic_register_security' ); ?>

                                        <p><?php _e('Already have an account?','vifonic') ?> <a class="register-login" data-toggle="modal" href="#modal-login"><?php _e('Login', 'vifonic') ?></a></p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'vifonic') ?></button>
                                        <button type="submit" class="btn btn-primary btn_register vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Register', 'vifonic') ?>"><?php _e('Register', 'vifonic') ?></button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <a class="register-login" data-toggle="modal" href="#modal-login"><?php _e('Login', 'vifonic') ?></a>
                    <div class="modal fade" id="modal-login">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="login-form" action="login" method="post" role="form">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                        </button>
                                        <h4 class="modal-title text-center"><?php _e('Login', 'vifonic') ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p class="status text-danger text-center"></p>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="vifonic_email" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="vifonic_pass" id="vifonic_pass" placeholder="<?php _e('Password >= 7 character', 'vifonic'); ?>">
                                        </div>


										<?php wp_nonce_field( 'ajax-login-nonce', 'vifonic_login_security' ); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <p class="pull-left" style="display: inline-block;margin: 0;line-height: 34px;">
                                            <a data-toggle="modal" href="#modal-forgot-password"><?php _e('Forgot password?','vifonic') ?></a>
                                        </p>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'vifonic') ?></button>
                                        <button type="submit" class="btn btn-primary btn-login vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Login', 'vifonic') ?>" ><?php _e('Login', 'vifonic') ?></button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="modal fade" id="modal-forgot-password">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="forgot-password-form" action="<?php echo wp_lostpassword_url(); ?>" method="post" role="form">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                        </button>
                                        <h4 class="modal-title text-center"><?php _e('Forgot Your Password?', 'vifonic') ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center"><?php _e('Enter your email address and we\'ll send you a link you can use to pick a new password.', 'vifonic'); ?></p>
                                        <p class="status text-danger text-center"></p>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="user_login" id="vifonic_email" placeholder="<?php _e('Email', 'vifonic'); ?>" required>
                                        </div>

										<?php wp_nonce_field( 'ajax-forgot-password-nonce', 'vifonic_forgot_password_security' ); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <p class="pull-left" style="display: inline-block;margin: 0;line-height: 34px;">
                                            <a data-toggle="modal" href="#modal-register"><?php _e('Register','vifonic') ?></a> | <a data-toggle="modal" href="#modal-login"><?php _e('Login', 'vifonic') ?></a>
                                        </p>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'vifonic') ?></button>
                                        <button type="submit" class="btn btn-primary btn-forgot-password vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Reset Password', 'vifonic') ?>" ><?php _e('Reset Password', 'vifonic') ?></button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
					<?php
				} else {
					$user = wp_get_current_user();

					echo '<div id="account-nav-btn" class="register-login text-left" href="'.get_edit_user_link($user->ID).'">'.get_avatar($user->ID, '36').'<ul id="account-menu" class="account-menu">';
					printf('<li class="acc-menu-item %1$s"><a href="%2$s">'.get_avatar($user->ID, '36').'
%3$s</a><div class="vifonic-divider"></div></li>', 'acc-header', '/user/profile', $user->display_name);
					?>
                    <li class="acc-menu-item"><a href="/user/profile"><i class="fa fa-user" aria-hidden="true"></i><?php _e('Profile', 'vifonic') ?></a></li>
                    <li class="acc-menu-item"><a href="/user/my-course"><i class="fa fa-book" aria-hidden="true"></i><?php _e('My Course', 'vifonic') ?></a></li>
                    <li class="acc-menu-item"><a href="/user/active-course"><i class="fa fa-key" aria-hidden="true"></i><?php _e('Active Course', 'vifonic') ?></a></li>
                    <li class="acc-menu-item"><a href="/user/wallet"><i class="fa fa-money" aria-hidden="true"></i><?php _e('Wallet', 'vifonic') ?></a></li>
					<?php
					printf('<li class="acc-menu-item %1$s"><div class="vifonic-divider"></div><a href="%2$s"><i class="fa fa-power-off" aria-hidden="true"></i>
%3$s</a></li>', 'btn_logout', wp_logout_url( home_url() ), __('Logout', 'vifonic'));
                    echo '</ul></div>';
				}
				?>
                <a class="active-course" href="#"><?php _e('Active Course', 'vifonic') ?></a>
                <a class="cart" href="/cart" data-toggle="tooltip" data-placement="top" title="<?php _e('View your cart', 'vifonic' ) ?>">
                    <i class="fa fa-shopping-basket"></i><span id="cart-count">0</span>
                </a>
            </div>
        </div>
    </div>
</header>