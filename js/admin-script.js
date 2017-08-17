jQuery(document).ready(function () {
    jQuery('.post-type-orders .acf-postbox:not(.acf-hidden) .acf-readonly input').attr('readonly', 'readonly');

    jQuery(".post-type-orders .acf-postbox:not(.acf-hidden) .order_course_list.acf-readonly ul.acf-actions.acf-hl").remove();
    jQuery(".post-type-orders .acf-postbox:not(.acf-hidden) .order_course_list.acf-readonly .acf-row-handle.remove a").remove();

    jQuery('.profile-php table.form-table .profile_my_course_list.acf-readonly input[type="text"]').attr('readonly', 'readonly');
    jQuery('.profile-php table.form-table .profile_my_course_list.acf-readonly td.acf-field-post-object').css('pointer-events', 'none');
    jQuery('.profile-php table.form-table .profile_my_course_list.acf-readonly td.acf-field-post-object').css('cursor', 'default');

    jQuery(".profile-php table.form-table .profile_my_course_list.acf-readonly ul.acf-actions.acf-hl").remove();
    jQuery(".profile-php table.form-table .profile_my_course_list.acf-readonly .acf-row-handle.remove a").remove();
});