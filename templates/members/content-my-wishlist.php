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

$my_course_id_list = get_field('profile_wishlist', 'user_'.get_current_user_id());
if (!$my_course_id_list){
	$my_course_id_list = array();
}

?>

<ul class="breadcrumb">
	<li><?php _e('Home', 'vifonic'); ?></li>
	<li><?php _e('Member', 'vifonic'); ?></li>
	<li class="active"><?php _e('My Wishlist', 'vifonic') ?></li>
</ul>

<div class="main-inner">
	<h1 class="user-page-header"><i class="fa fa-heart" aria-hidden="true"></i><?php _e('My Wishlist', 'vifonic') ?></h1>

	<div class="container-fluid">
		<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    if (!empty($my_course_id_list)){
	                    vifonic_show_list_courses_by_id($my_course_id_list);
                    } else {
	                    printf('<h4 class="text-center">%1$s</h4>', __('There are no course in your wishlist', 'vifonic'));
                    }
                ?>
            </div>
		</div>
	</div>
</div>