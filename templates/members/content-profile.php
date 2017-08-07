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
$fullname = $user->display_name;

$date = get_field('profile_birthday', 'user_'.$user->ID, false);
$date2 = new DateTime($date);
$birthday = $date2->format('d/m/Y');

$sex_meta = get_field('profile_sex', 'user_'.$user->ID);
$sex = '';
if($sex_meta == 'male'){ $sex = __('Male','vifonic'); }
elseif($sex_meta == 'female'){ $sex = __('Female','vifonic'); }

$email = $user->user_email;
$mobile = get_field('profile_mobile', 'user_'.$user->ID);
?>

<ul class="breadcrumb">
	<li><?php _e('Home', 'vifonic'); ?></li>
	<li><?php _e('Member', 'vifonic'); ?></li>
	<li class="active"><?php _e('Profile', 'vifonic'); ?></li>
</ul>

<div class="main-inner">
	<h1 class="user-page-header"><i class="fa fa-user" aria-hidden="true"></i><?php _e('Profile', 'vifonic'); ?></h1>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-sm-offset-2">
				<table class="table table-user-information">
					<tbody>
					<tr>
						<td><?php _e('Full Name', 'vifonic'); ?> :</td>
						<td><?php echo $fullname; ?></td>
					</tr>
					<tr>
						<td><?php _e('Birthday', 'vifonic'); ?> :</td>
						<td><?php echo $birthday; ?></td>
					</tr>

					<tr>
						<td><?php _e('Sex', 'vifonic'); ?> :</td>
						<td><?php echo $sex; ?></td>
					</tr>
					<tr>
						<td><?php _e('Email', 'vifonic'); ?> :</td>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<td><?php _e('Mobile', 'vifonic'); ?> :</td>
						<td><?php echo $mobile; ?></td>
					</tr>
					</tbody>
				</table>

				<!--FORM UPDATE PROFILE-->
				<a class="btn btn-primary update-profile-link" data-toggle="modal" href="#modal-update-profile"><i class="fa fa-pencil" aria-hidden="true"></i><?php _e('Update profile', 'vifonic'); ?></a>
				<div class="modal fade" id="modal-update-profile">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="update-profile-form" action="/user/profile/update-profile" method="post" role="form">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
									</button>
									<h4 class="modal-title text-center"><?php _e('Update profile', 'vifonic'); ?></h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<label for="vifonic_fullname"><?php _e('Full Name', 'vifonic'); ?></label>
										<input type="text" class="form-control" name="vifonic_fullname" id="vifonic_fullname" placeholder="<?php _e('Full Name', 'vifonic'); ?>" value="<?php echo $fullname; ?>">
									</div>
									<div class="form-group">
										<label for="vifonic_birthday"><?php _e('Birthday', 'vifonic'); ?></label>
										<input type="text" class="form-control" name="vifonic_birthday" id="vifonic_birthday" placeholder="<?php _e('Birthday', 'vifonic'); ?>" value="<?php echo $birthday; ?>">
									</div>
									<div class="form-group">
										<label for="vifonic_mobile"><?php _e('Mobile', 'vifonic'); ?></label>
										<input type="text" class="form-control" name="vifonic_mobile" id="vifonic_mobile" placeholder="<?php _e('Mobile', 'vifonic'); ?>" value="<?php echo $mobile ?>">
									</div>

									<div class="form-group">
										<label for="vifonic_sex"><?php _e('Sex', 'vifonic'); ?></label>
										<div class="radio">
											<?php
											$male_checked = '';
											$female_checked = '';
											if($sex_meta == 'male'){ $male_checked = 'checked'; }
											elseif($sex_meta == 'female'){ $female_checked = 'checked'; }
											?>
											<label>
												<input type="radio" name="vifonic_sex" id="vifonic_sex" value="male" <?php echo esc_attr($male_checked); ?>><?php _e('Male','vifonic'); ?>
											</label>
											<label>
												<input type="radio" name="vifonic_sex" id="vifonic_sex" value="female" <?php echo esc_attr($female_checked);  ?>><?php _e('Female','vifonic'); ?>
											</label>
										</div>
									</div>
									<hr>
									<div class="update-password-wrapper">
										<a role="button" data-toggle="collapse" href="#collapseUpdatePassword" aria-expanded="false" aria-controls="collapseUpdatePassword">
											<label class="update-password-link"><?php _e('Change Password', 'vifonic'); ?></label>
										</a>

										<div class="password-input-wrapper collapse" id="collapseUpdatePassword">
											<p><?php _e('If you do not want to change your password, leave this blank!', 'vifonic'); ?></p>
											<div class="form-group">
												<input type="password" class="form-control" name="vifonic_current_pass" id="vifonic_current_pass" placeholder="<?php _e('Current Password', 'vifonic'); ?>">
											</div>

											<div class="form-group">
												<input type="password" class="form-control" name="vifonic_new_pass" id="vifonic_new_pass" placeholder="<?php _e('Password >= 7 character', 'vifonic'); ?>">
											</div>

											<div class="form-group">
												<input type="password" class="form-control" name="vifonic_new_pass_confirm" id="vifonic_new_pass_confirm" placeholder="<?php _e('Confirm Password', 'vifonic'); ?>">
											</div>
										</div>
									</div>

									<?php wp_nonce_field( 'ajax-update-profile-nonce', 'vifonic_update_profile_security' ); ?>
                                    <p class="status text-danger text-center"></p>
                                </div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'vifonic') ?></button>
									<button type="submit" class="btn btn-primary btn_update_profile vifonic-ajax-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php _e('Save changes', 'vifonic') ?>"><?php _e('Save changes', 'vifonic') ?></button>
								</div>
							</form>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!--END FORM-->
			</div>
		</div>
	</div>
</div>

<script>
    jQuery(document).ready(function($) {
        jQuery("#vifonic_birthday").datepicker();
    });
</script>