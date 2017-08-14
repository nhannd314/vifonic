jQuery(document).ready(function() {
    var btn_timeout;

    jQuery('.vifonic-ajax-button').each(function () {
        jQuery(this).on('click', function() {
            var $this = jQuery(this);
            $this.button('loading');
            btn_timeout = setTimeout(function() {
                $this.button('reset');
            }, 10000);
        });
    });

    // Ajax buy now
    jQuery("button.btn-buy-now").on("click", function(e) {
            var btn_buynow = jQuery(this);

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: ajax_add_to_cart_object.ajaxurl,
                data: {
                    "action": "ajaxAddToCart",
                    "course_id": jQuery(this).closest("form.buy-now-form").find("#vifonic_course_id").val(),
                    "security": jQuery(this).closest("form.buy-now-form").find("#vifonic_add_to_cart_security").val()
                },
                success: function(response){
                    console.log(response);
                    clearTimeout(btn_timeout);
                    btn_buynow.button('reset');

                    if (response.success == true){
                        window.location.href = '/order/detail/';
                    } else {
                        console.log(response.error);
                        alert(response.error);
                    }
                }
                // end success
            });

            e.preventDefault();
            return false;
        });
    // Ajax add to cart
    jQuery("button.btn-add-to-cart").on("click", function(e) {
        var btn_addtocart = jQuery(this);
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_add_to_cart_object.ajaxurl,
            data: {
                "action": "ajaxAddToCart",
                "course_id": jQuery(this).closest("form.add-to-cart-form").find("#vifonic_course_id").val(),
                "security": jQuery(this).closest("form.add-to-cart-form").find("#vifonic_add_to_cart_security").val()
            },
            success: function(response){
                console.log(response);
                clearTimeout(btn_timeout);
                btn_addtocart.button('reset');

                if (response.success == true){
                    var x = parseInt(jQuery('#cart-count').html());
                    var y = ++x;
                    jQuery('#cart-count').html( y );
                    alert(response.message);
                } else {
                    console.log(response.error);
                    alert(response.error);
                }
            }
            // end success
        });

        e.preventDefault();
        return false;
    });
    // Ajax remove item
    jQuery("button.btn-remove-item").on("click", function(e) {
        $this = jQuery(this);
        var course_id = jQuery(this).data('course-id');
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_remove_item_object.ajaxurl,
            data: {
                "action": "ajaxRemoveItem",
                "course_id": course_id,
                "security": jQuery(".page-cart .cart-table #vifonic_remove_item_security").val(),
            },
            success: function(response){
                console.log(response);
                clearTimeout(btn_timeout);
                $this.button('reset');

                if (response.success == true){
                    $this.closest(".cart-item").remove();
                    //alert(response.message);
                } else {
                    console.log(response.error);
                    alert(response.error);
                }
            }
            // end success
        });

        e.preventDefault();
        return false;
    });
    // Ajax add coupon
    jQuery("button.btn-add-coupon").on("click", function(e) {
        var btn_addcoupon = jQuery(this);
        jQuery('form#add-coupon-form p.status').html("");
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_add_coupon_object.ajaxurl,
            data: {
                "action": "ajaxAddCoupon",
                "coupon_code": jQuery(this).closest("form#add-coupon-form").find("#vifonic_coupon").val(),
                "security": jQuery(this).closest("form#add-coupon-form").find("#vifonic_add_coupon_security").val()
            },
            success: function(response){
                console.log(response);
                clearTimeout(btn_timeout);
                btn_addcoupon.button('reset');

                if (response.success == true){
                    jQuery('form#add-coupon-form p.status').html(response.message);
                    alert(response.message);
                    window.location.reload();
                } else {
                    console.log(response.error);
                    jQuery('form#add-coupon-form p.status').html(response.error);
                    //alert(response.error);
                }
            }
            // end success
        });

        e.preventDefault();
        return false;
    });
});