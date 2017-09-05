jQuery(document).ready(function() {
    var btn_timeout;

    jQuery('[id^="modal-"]').each(function () {
        jQuery(this).on('show.bs.modal', function () {
            // Load up a new modal...
            jQuery('[id^="modal-"]').not(jQuery(this)).modal('hide');
        });
    });

    jQuery('.vifonic-ajax-button').each(function () {
        jQuery(this).on('click', function() {
            var $this = jQuery(this);
            $this.button('loading');
            btn_timeout = setTimeout(function() {
                $this.button('reset');
            }, 10000);
        });
    });

    // Ajax register new user
    jQuery("#update-profile-form").on("submit", function(e) {

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_update_profile_object.ajaxurl,
            data: {
                "action": "ajaxUpdateProfile",
                // "avatar": jQuery("#update-profile-form #vifonic_avatar").val(),
                "fullname": jQuery("#update-profile-form #vifonic_fullname").val(),
                "birthday": jQuery("#update-profile-form #vifonic_birthday").val(),
                "mobile": jQuery("#update-profile-form #vifonic_mobile").val(),
                "sex": jQuery("#update-profile-form #vifonic_sex").val(),
                "current_pass": jQuery("#update-profile-form #vifonic_current_pass").val(),
                "new_pass": jQuery("#update-profile-form #vifonic_new_pass").val(),
                "new_pass_confirm": jQuery("#update-profile-form #vifonic_new_pass_confirm").val(),
                "security": jQuery("#update-profile-form #vifonic_update_profile_security").val()
            },
            success: function(response){
                console.log(response);

                clearTimeout(btn_timeout);
                jQuery('#update-profile-form .vifonic-ajax-button').button('reset');

                if (response.success == true){
                    jQuery("#update-profile-form .status").html(response.message);
                    location.reload(true);
                }
                else {
                    console.log('Error: '+response.error);
                    jQuery("#update-profile-form .status").html(response.error);
                }
            }
            // end success
        });

        e.preventDefault();
        return false;
    });
});