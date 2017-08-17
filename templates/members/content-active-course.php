<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 04/08/2017
 * Time: 5:49 CH
 */
?>
<ul class="breadcrumb">
    <li><?php _e('Home', 'vifonic'); ?></li>
    <li><?php _e('Member', 'vifonic'); ?></li>
    <li class="active"><?php _e('Active Course', 'vifonic') ?></li>
</ul>

<div class="main-inner">
    <h1 class="user-page-header"><i class="fa fa-key" aria-hidden="true"></i><?php _e('Active Course', 'vifonic') ?></h1>

    <div class="container-fluid">
        <div class="row active-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="text-center">
                    <label class="label label-danger"><?php _e('Note!', 'vifonic'); ?></label>
                    <span><?php _e('Each course only needs to be activated once. Do not repeat this step the next time.', 'vifonic'); ?></span>
                </div>
                <form id="active-course-form" class="text-center" action="/user/active-course/" method="post" role="form">
                    <div class="form-group form-inline">
                        <input type="text" class="form-control" name="vifonic_acive_course_code" id="vifonic_acive_course_code" placeholder="<?php _e('Input active code here...', 'vifonic') ?>">
                        <button type="submit" class="btn btn-primary btn-active-course"><?php _e('Active now', 'vifonic') ?> <i class="fa fa-unlock" aria-hidden="true"></i></button>
                    </div>
                </form>
				<?php
				$active_course_code = isset($_POST['vifonic_acive_course_code']) ? $_POST['vifonic_acive_course_code'] : '';
				if($active_course_code != ''){
					$user = wp_get_current_user();
					if (have_rows('profile_my_course_list', 'user_'.$user->ID)) {
						$active_code_exist = false;
						while (have_rows('profile_my_course_list','user_'.$user->ID)){
							the_row();
							if ($active_course_code == get_sub_field('profile_my_course_key', 'user_'.$user->ID)) {
								$active_code_exist = true;
								if (get_sub_field('profile_is_active_course', 'user_'.$user->ID) == false){
									update_sub_field('profile_is_active_course', true);
                                    printf('<div class="alert alert-success" role="alert"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="alert-message">%1$s</span></div>', __('Activation successful!', 'vifonic'));
								} else {
									printf('<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="alert-message">%1$s</span></div>', __('This activation code has been activated for your course!', 'vifonic'));
                                }
								break;
							}
						}
						if ($active_code_exist == false) {
							printf('<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="alert-message">%1$s</span></div>', __('This activation code was not found!', 'vifonic'));
                        }
					}
				}
				?>
            </div>
        </div>
    </div>
</div>