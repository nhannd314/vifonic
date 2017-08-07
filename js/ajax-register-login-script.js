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

/*    jQuery('.vifonic-ajax-button').on('click', function() {
        var $this = jQuery(this);
        $this.button('loading');
        btn_timeout = setTimeout(function() {
            $this.button('reset');
        }, 10000);
    });*/


    // Ajax register new user
    jQuery("#register-form").on("submit", function(e) {

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_register_login_object.ajaxurl,
            data: {
                "action": "ajaxregister", //calls wp_ajax_nopriv_ajaxregister
                "fullname": jQuery("#register-form #vifonic_fullname").val(),
                "email": jQuery("#register-form #vifonic_email").val(),
                "mobile": jQuery("#register-form #vifonic_mobile").val(),
                "password": jQuery("#register-form #vifonic_pass").val(),
                "password_confirm": jQuery("#register-form #vifonic_pass_confirm").val(),
                "security": jQuery("#register-form #vifonic_register_security").val()
            },
            success: function(response){
                clearTimeout(btn_timeout);
                jQuery('#register-form .vifonic-ajax-button').button('reset');

                if (response.success == true){
                    jQuery("#register-form .status").html(response.message);
                }
                else {
                    jQuery("#register-form .status").html(response.error.join("<br>"));
                    //console.log(response.error);
                }

            }
            // end success
        });

        e.preventDefault();
        return false;
    });

    // Perform AJAX login on form submit
    jQuery("#login-form").on("submit", function(e) {

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_register_login_object.ajaxurl,
            data: {
                "action": "ajaxlogin", //calls wp_ajax_nopriv_ajaxlogin
                "email": jQuery("#login-form #vifonic_email").val(),
                "password": jQuery("#login-form #vifonic_pass").val(),
                "security": jQuery("#login-form #vifonic_login_security").val() },
            success: function(response){

                clearTimeout(btn_timeout);
                jQuery('#login-form .vifonic-ajax-button').button('reset');

                if (response.success == true){
                    jQuery("#login-form .status").html(response.message);
                    location.reload(true);
                } else {
                    jQuery("#login-form .status").html(response.error);
                    console.log(response.error);
                }
            }
        });
        e.preventDefault();
        return false;
    });

    // Perform AJAX forgot-password on form submit
    jQuery("#forgot-password-form").on("submit", function(e) {

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_register_login_object.ajaxurl,
            data: {
                "action": "ajaxforgotpassword", //calls wp_ajax_nopriv_ajaxlogin
                "email": jQuery("#forgot-password-form #vifonic_email").val(),
                "security": jQuery("#forgot-password-form #vifonic_forgot_password_security").val() },
            success: function(response){
                clearTimeout(btn_timeout);
                jQuery('#forgot-password-form .vifonic-ajax-button').button('reset');

                if (response.success == true){
                    jQuery("#forgot-password-form .status").html(response.message);
                    location.reload(true);
                } else {
                    jQuery("#forgot-password-form .status").html(response.error);
                    console.log(response.error);
                }
            }
        });
        e.preventDefault();
        return false;
    });
});