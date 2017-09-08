jQuery(document).ready(function ()
{
    jQuery("#comments").prepend(jQuery("#respond"));

    jQuery(".dashboard-menu").css("height", jQuery(".dashboard-content").parent().height());
    //Sidebar scroll
    if(jQuery('.course-information').length != 0){
        jQuery(window).scroll(function () {
            if (jQuery(this).width() < 1200){
                return;
            }
            var scroll = jQuery(this).scrollTop();

            var height1 = jQuery('.course-information').height();
            var height2 = jQuery('.course-information').offset().top;
            var height3 = jQuery('.info-wrapper').height();
            var length = height1+height2-height3;
            var height = jQuery('.info-wrapper').height() + 'px';

            /*console.log("Scroll:"+scroll);
            console.log("Length:"+length);*/

            if (scroll < jQuery('.course-information').offset().top) {

                jQuery('.info-wrapper').css({
                    'position': 'absolute',
                    'top': '0',
                    'bottom': 'auto'
                });

            } else if (scroll > length ) {

                jQuery('.info-wrapper').css({
                    'position': 'absolute',
                    'bottom': '0',
                    'top': 'auto'
                });

            } else if(scroll > jQuery('.course-information').offset().top && scroll < length) {

                jQuery('.info-wrapper').css({
                    'position': 'fixed',
                    'top': '50px',
                    'bottom': 'auto',
                    'height': height
                });
            }
        });
    }

    //Up to top
    jQuery(window).scroll(function () {
        var scroll = jQuery(this).scrollTop();
        if (scroll > 100){
            jQuery('#up-to-top').fadeIn("slow");
        } else {
            jQuery('#up-to-top').fadeOut("slow");
        }
    });
    jQuery('#up-to-top').click(function () {
        jQuery("html, body").animate({ scrollTop: 0 }, 500, 'swing');
        return false;
    });
    
    // tool tip
    jQuery('[data-toggle="tooltip"]').tooltip();

    // course menu toggle
    jQuery(".course-nav").hover(function() {
        jQuery("#course-menu").stop().slideToggle();
    });

    // account menu toggle
    jQuery("#account-nav-btn").click(function() {
        jQuery("#account-menu").stop().slideToggle();
    });

    jQuery(document).click(function(evt) {
        console.log(evt.target.id);
        if( evt.target.id != 'course-menu' && !jQuery('#course-menu').find(evt.target).length && evt.target.id != 'course-nav-btn' && !jQuery('#course-nav-btn').find(evt.target).length) {
            jQuery("#course-menu").stop().hide();
            console.log('hide');
        }

        //Account menu
        if( evt.target.id != 'account-menu' && !jQuery('#account-menu').find(evt.target).length && evt.target.id != 'account-nav-btn' && !jQuery('#account-nav-btn').find(evt.target).length) {
            jQuery("#account-menu").stop().hide();
            console.log('hide');
        }
    });
});