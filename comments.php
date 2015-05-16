			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'sp' ); ?></p>
			</div><!-- #comments -->
<?php
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation group">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&lt;</span> Older Comments', 'sp' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&gt;</span>', 'sp' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					wp_list_comments( array( 'callback' => 'sp_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation group">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&lt;</span> Older Comments', 'sp' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&gt;</span>', 'sp' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	if ( ! comments_open() ) :
		if (get_post_type() == 'post') {
?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'sp' ); ?></p>
<?php 
		}
	endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>
<?php if ( have_comments() ) : ?>
<div class="btt group"><a href="#top" title="<?php _e( 'Back to Top', 'sp' ); ?>"><?php _e('Back to Top', 'sp'); ?> <span class="icon">&nbsp;</span></a></div>
<?php endif; ?>
<?php
if (esc_attr( $commenter['comment_author'] ) == null) { $name = 'Name'; } else { $name = esc_attr( $commenter['comment_author'] ); }
if (esc_attr(  $commenter['comment_author_email'] ) == null) { $email = 'Email'; } else { $email = esc_attr(  $commenter['comment_author_email'] ); }
if (esc_attr( $commenter['comment_author_url'] ) == null) { $site = 'Url'; } else { $site = esc_attr( $commenter['comment_author_url'] ); }

?>
<?php
(isset($aria_req)) ? $aria_req : $aria_req = '';

$fields =  array(
	'author' => '<div class="left"><p class="comment-form-author">'.
	            '<input id="author" class="required" name="author" type="text" value="' .$name. '" size="30"' . $aria_req . ' /><span class="required">*</span></p>',
	'email'  => '<p class="comment-form-email">'.
	            '<input id="email" class="required email" name="email" type="text" value="' .$email. '" size="30"' . $aria_req . ' /><span class="required">*</span></p>',
	'url'    => '<p class="comment-form-url">'.
	            '<input id="url" name="url" type="text" value="' .$site. '" size="30" /></p></div>',
); ?>
<?php comment_form(array('title_reply' => 'Leave a Comment','comment_notes_after' => '','fields' => apply_filters( 'comment_form_default_fields', $fields ),'comment_field' => '<div class="right"><p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="7" aria-required="true" class="required"></textarea><span class="required">*</span><span class="arrow">&nbsp;</span></p></div><div class="group"></div>')); ?>
<div class="group"></div>
</div><!-- #comments -->
