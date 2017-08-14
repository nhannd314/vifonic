jQuery(document).ready(function () {
    jQuery(".post-type-orders .acf-postbox:not(.acf-hidden) .acf-readonly input").attr('readonly', 'readonly');

    jQuery(".post-type-orders .acf-postbox:not(.acf-hidden) .order_course_list.acf-readonly ul.acf-actions.acf-hl").remove();
    jQuery(".post-type-orders .acf-postbox:not(.acf-hidden) .order_course_list.acf-readonly .acf-row-handle.remove a").remove();
});