<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 05/08/2017
 * Time: 9:39 SA
 */
?>
<?php
$user = wp_get_current_user();
$my_course_id_list = array();

if (have_rows('profile_my_course_list', 'user_'.$user->ID)) {
    while (have_rows('profile_my_course_list','user_'.$user->ID)){
        the_row();
	    $profile_my_course = get_sub_field('profile_my_course', 'user_'.$user->ID);
	    $profile_my_course_key = get_sub_field('profile_my_course_key', 'user_'.$user->ID);
	    array_push($my_course_id_list, $profile_my_course);
    }
}
?>

<ul class="breadcrumb">
	<li><?php _e('Home', 'vifonic'); ?></li>
	<li><?php _e('Member', 'vifonic'); ?></li>
	<li class="active"><?php _e('My Course', 'vifonic') ?></li>
</ul>

<div class="main-inner">
	<h1 class="user-page-header"><i class="fa fa-book" aria-hidden="true"></i><?php _e('My Course', 'vifonic') ?></h1>

	<div class="container-fluid">
		<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    if (!empty($my_course_id_list)){
	                    vifonic_show_list_courses_by_id($my_course_id_list);
                    }
                ?>
            </div>
		</div>
	</div>
</div>