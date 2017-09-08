<?php
/**
 * Created by PhpStorm.
 * User: zkenc
 * Date: 07/09/2017
 * Time: 3:26 CH
 */

add_filter('comment_form_defaults', 'vifonic_set_my_comment_title', 20);
function vifonic_set_my_comment_title( $defaults ){
	$defaults['title_reply'] = __('Comment', 'vifonic');
	return $defaults;
}
function comment_form_submit_button($button) {
	$button = '<input name="submit" type="submit" id="submit" class="submit btn btn-primary" value="'.__('Comment','vifonic').'">'.get_comment_id_fields();
	return $button;
}
add_filter('comment_form_submit_button', 'comment_form_submit_button');


add_filter('comment_post_redirect', 'vifonic_redirect_after_comment');
function vifonic_redirect_after_comment($location)
{
	return $_SERVER["HTTP_REFERER"];
}

//===================================
// Method to handle comment submission
function ajaxComment($comment_ID, $comment_status) {
	// If it's an AJAX-submitted comment
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		// Get the comment data
		$comment = get_comment($comment_ID);
		// Allow the email to the author to be sent
		wp_notify_postauthor($comment_ID);
		// Get the comment HTML from my custom comment HTML function
		$args = array(
			'max_depth' => 2,
			'style' => 'ol',
		);
		$comments = get_comments(array(
			'post_id' => $comment->comment_post_ID,
			'orderby' => 'comment_ID',
			'order' => 'ASC',
		));
		wp_list_comments($args, $comments);
		die();
	}
}
// Send all comment submissions through my "ajaxComment" method
add_action('comment_post', 'ajaxComment', 20, 2);
