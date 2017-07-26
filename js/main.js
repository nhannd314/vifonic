jQuery(document).ready(function ()
{
    // tool tip
    jQuery('[data-toggle="tooltip"]').tooltip();

    // course menu toggle
    jQuery("#course-nav-btn").click(function() {
        jQuery("#course-menu").stop().slideToggle();
    });
    jQuery(document).click(function(evt) {
        console.log(evt.target.id);
        if( evt.target.id != 'course-menu' && !jQuery('#course-menu').find(evt.target).length && evt.target.id != 'course-nav-btn' && !jQuery('#course-nav-btn').find(evt.target).length) {
            jQuery("#course-menu").stop().hide();
            console.log('hide');
        }
    });
});