<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package storefront
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
			<?php
			printf( _nx( 'One thought on &ldquo;%2jQuerys&rdquo;', '%1jQuerys thoughts on &ldquo;%2jQuerys&rdquo;', get_comments_number(), 'comments title', 'storefront' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
        </h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'storefront' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'storefront' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'storefront' ) ); ?></div>
            </nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

        <ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      	=> 'ol',
				'short_ping' 	=> true,
			) );
			?>
        </ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'storefront' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'storefront' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'storefront' ) ); ?></div>
            </nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'storefront' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->


<script type="text/javascript">
    jQuery('document').ready(function(){
        // Get the comment form
        var commentform = jQuery('#commentform');
        // Add a Comment Status message
        commentform.prepend('<div id="comment-status" ></div>');
        // Defining the Status message element
        var statusdiv = jQuery('#comment-status');


        //Set action for Reply Link
        jQuery('a.comment-reply-link').each(function () {
            jQuery(this).prop('onclick',null).off('click');
            jQuery(this).on("click", function (e) {
                statusdiv.html("");
                var comment_id = jQuery(this).parent().parent().parent().attr("id");
                var comment_author = jQuery("#"+comment_id+" .comment-author b.fn:first").text();
                jQuery("html, body").animate( { scrollTop: jQuery("#respond").offset().top }, 500, function() { jQuery("textarea#comment").focus(); } );

                jQuery('#reply-title').html('<?php _e('Reply to', 'vifonic'); ?> <a href="#'+comment_id+'">'+comment_author+'</a> <small><a id="cancel-comment-reply-link" href="#"><?php _e( 'Cancel', 'vifonic'); ?></a></small>');

                var comment_parent = comment_id.substr(comment_id.indexOf("-") + 1);
                commentform.find(".form-submit input#comment_parent").val(comment_parent);

                jQuery('a#cancel-comment-reply-link').click(function () {
                    jQuery('#reply-title').html('<?php echo __('Comment', 'vifonic'); ?>');
                    jQuery("html, body").animate( { scrollTop: jQuery("#respond").offset().top }, 500, function() { jQuery("textarea#comment").focus(); } );
                    commentform.find(".form-submit input#comment_parent").val(0);
                    e.preventDefault();
                    return false;
                });

                e.preventDefault();
                return false;
            });
        });


        //=========== On submit ==================
        commentform.submit(function(){
            // Serialize and store form data
            var formdata = commentform.serialize();
			<?php
			$action = isset($_GET['action']) ? "&action=".$_GET['action'] : "" ;
			$lesson = isset($_GET['lesson']) ? "&lesson=".$_GET['lesson'] : "" ;
			?>

            formdata += "<?php if ($action != '') echo $action; ?>";
            formdata += "<?php if ($lesson != '') echo $lesson; ?>";
            //Add a status message
            statusdiv.html('<p class="ajax-placeholder"><?php _e("Processing...", "vifonic"); ?></p>');
            //Extract action URL from commentform
            var formurl = commentform.attr('action');
            //Post Form with data
            jQuery.ajax({
                type: 'post',
                url: formurl,
                data: formdata,
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    statusdiv.html('<p class="ajax-error" ><?php _e("You might have left one of the fields blank, or be posting too quickly", "vifonic"); ?></p>');
                },
                success: function(data, textStatus){
                    //console.log("Data: " + data);
                    if(textStatus == "success") {
                        jQuery(".comment-list").html(data);
                        statusdiv.html('<p class="ajax-success" ><?php _e("Thanks for your comment. We appreciate your response.", "vifonic"); ?></p>');
                    } else {
                        statusdiv.html('<p class="ajax-error" ><?php _e("Please wait a while before posting your next comment", "vifonic"); ?></p>');
                    }
                    commentform.find('textarea[name=comment]').val('');

                    //Set action for Reply Link
                    jQuery('a.comment-reply-link').each(function () {
                        jQuery(this).prop('onclick',null).off('click');
                        jQuery(this).on("click", function (e) {
                            statusdiv.html("");
                            var comment_id = jQuery(this).parent().parent().parent().attr("id");
                            var comment_author = jQuery("#"+comment_id+" .comment-author b.fn:first").text();
                            jQuery("html, body").animate( { scrollTop: jQuery("#respond").offset().top }, 500, function() { jQuery("textarea#comment").focus(); } );

                            jQuery('#reply-title').html('<?php _e('Reply to', 'vifonic'); ?> <a href="#'+comment_id+'">'+comment_author+'</a> <small><a id="cancel-comment-reply-link" href="#"><?php _e( 'Cancel', 'vifonic'); ?></a></small>');

                            var comment_parent = comment_id.substr(comment_id.indexOf("-") + 1);
                            commentform.find(".form-submit input#comment_parent").val(comment_parent);

                            jQuery('a#cancel-comment-reply-link').click(function () {
                                jQuery('#reply-title').html('<?php echo __('Comment', 'vifonic'); ?>');
                                jQuery("html, body").animate( { scrollTop: jQuery("#respond").offset().top }, 500, function() { jQuery("textarea#comment").focus(); } );
                                commentform.find(".form-submit input#comment_parent").val(0);
                                e.preventDefault();
                                return false;
                            });

                            e.preventDefault();
                            return false;
                        });
                    });
                }
            });
            return false;
        });
    });
</script>
