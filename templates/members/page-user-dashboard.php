<?php
/**
 * Template name: Member Dashboard
 */

get_header();
$user = wp_get_current_user();
?>
	<main class="main main-page page-dashboard">
		<div class="container-fluid">
			<section class="content" role="main">
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 sidebar-left">
						<div class="dashboard-menu">
							<div class="user-info">
								<div class="content">
									<div class="user-avatar">
										<?php echo get_avatar($user->ID,'40'); ?>
									</div>
									<div class="user-name"><?php echo $user->display_name; ?></div>
								</div>
							</div>
							<div class="user-menu">
								<label><?php _e('PERSONAL INFORMATION', 'vifonic'); ?></label>
								<div class="content">
									<h3 class="user-menu-title"><?php _e('STUDENT', 'vifonic'); ?></h3>
									<ul class="student-menu">
                                        <li class="acc-menu-item"><a href="/user/profile"><i class="fa fa-user" aria-hidden="true"></i><?php _e('Profile', 'vifonic') ?></a></li>
                                        <li class="acc-menu-item"><a href="/user/my-course"><i class="fa fa-book" aria-hidden="true"></i><?php _e('My Course', 'vifonic') ?></a></li>
                                        <li class="acc-menu-item"><a href="/user/active-course"><i class="fa fa-key" aria-hidden="true"></i><?php _e('Active Course', 'vifonic') ?></a></li>
                                        <li class="acc-menu-item"><a href="/user/wallet"><i class="fa fa-money" aria-hidden="true"></i><?php _e('Wallet', 'vifonic') ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 ">
						<div class="dashboard-content">

							<?php
							$user_page = (null !== get_query_var('user_page')) ? get_query_var('user_page') : '';
							switch ($user_page){
								case 'profile':
									get_template_part('templates/members/content', 'profile');
									break;
								case 'my-course':
									get_template_part('templates/members/content', 'my-course');
									break;
								case 'active-course':
									get_template_part('templates/members/content', 'active-course');
									break;
								case 'wallet':
									get_template_part('templates/members/content', 'wallet');
									break;
								default:
									get_template_part('templates/members/content', 'profile');
							}
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</main>
<?php
get_footer();