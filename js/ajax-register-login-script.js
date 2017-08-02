jQuery(document).ready(function() {

    jQuery('#register-form .btn').on('click', function() {
        var $this = jQuery(this);
        $this.button('loading');
        setTimeout(function() {
            $this.button('reset');
        }, 2000);
    });

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
                "password_comfirm": jQuery("#register-form #vifonic_pass_confirm").val(),
                "security": jQuery("#register-form #vifonic_register_security").val()
            },
            success: function(response){
                jQuery("#register-form .status").html(response.message);

                if (response.success == true){
                    jQuery("#register-form .status").html(__("Account registration successful! Please check your email to confirm your registration!", 'vifonic'));
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
    /*jQuery("#login-form").on("submit", function(e) {
        jQuery("#login-form > .hover").show();
        jQuery("#login-form > .loading").show();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_login_object.ajaxurl,
            data: {
                "action": "ajaxlogin", //calls wp_ajax_nopriv_ajaxlogin
                "email": jQuery("#na_email").val(),
                "password": jQuery("#na_pass").val(),
                "security": jQuery("#login-security").val() },
            success: function(response){
                jQuery("#login-form > .hover").hide();
                jQuery("#login-form > .loading").hide();
                if (response.success == true){
                    jQuery("#login-form .status").html("Logged in successfully. Redirecting ...");
                    location.reload(true);
                }
                else {
                    jQuery("#login-form .status").html(response.error);
                    console.log(response.error);
                }
            }
        });
        e.preventDefault();
        return false;
    });*/
});