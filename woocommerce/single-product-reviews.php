<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php global $woocommerce; ?>
<?php if ( comments_open() ) : ?><div id="reviews"><?php 
	
	echo '<div id="comments">';
	
	$count = $wpdb->get_var("
		SELECT COUNT(meta_value) FROM $wpdb->commentmeta 
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $post->ID
		AND comment_approved = '1'
		AND meta_value > 0
	");
	
	$rating = $wpdb->get_var("
		SELECT SUM(meta_value) FROM $wpdb->commentmeta 
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $post->ID
		AND comment_approved = '1'
	");
	
	if ( $count > 0 ) :
		
		$average = number_format($rating / $count, 2);
		
		echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		
		echo '<div class="star-rating" title="'.sprintf(__('Rated %s out of 5', 'sp'), $average).'"><span style="width:'.($average*16).'px"><span itemprop="ratingValue" class="rating">'.$average.'</span> '.__('out of 5', 'sp').'</span></div>';
		
		echo '<h2>'.sprintf( _n('%s review for %s', '%s reviews for %s', $count, 'sp'), '<span itemprop="ratingCount" class="count">'.$count.'</span>', wptexturize($post->post_title) ).'</h2>';

		echo '</div>';
		
	else :
	
		echo '<h2>'.__('Reviews', 'sp').'</h2>';
		
	endif;

	$title_reply = '';

	if ( have_comments() ) : 

		echo '<ol class="commentlist">';
		
		wp_list_comments( array( 'callback' => 'woocommerce_comments' ) );

		echo '</ol>';
	
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Previous', 'sp' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'sp' ) ); ?></div>
			</div>
		<?php endif;
		
		echo '<p class="add_review"><a href="#review_form" class="inline show_review_form button">'.__('Add Review', 'sp').'</a></p>';
		
		$title_reply = __('Add a review', 'sp');
		
	else : 

		$title_reply = __('Be the first to review', 'sp').' &ldquo;'.$post->post_title.'&rdquo;';
		
		echo '<p>'.__('There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'sp').'</p>';
	
	endif;
	
	$commenter = wp_get_current_commenter();
	
	echo '</div><div id="review_form_wrapper"><div id="review_form">';
	
	$comment_form = array(
		'title_reply' => $title_reply,
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'sp' ) . '</label> ' . '<span class="required">*</span>' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'sp' ) . '</label> ' . '<span class="required">*</span>' .
			            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
		),
		'label_submit' => __('Submit Review', 'sp'),
		'logged_in_as' => '',
		'comment_field' => ''
	);
		
	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	
		$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __('Rating', 'sp') .'</label><select name="rating" id="rating">
			<option value="">'.__('Rate&hellip;', 'sp').'</option>
			<option value="5">'.__('Perfect', 'sp').'</option>
			<option value="4">'.__('Good', 'sp').'</option>
			<option value="3">'.__('Average', 'sp').'</option>
			<option value="2">'.__('Not that bad', 'sp').'</option>
			<option value="1">'.__('Very Poor', 'sp').'</option>
		</select></p>';
			
	}
	
	$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'sp' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>' . wc_print_notices('comment_rating', true, false);
	
	comment_form( $comment_form ); 

	echo '</div></div>';
	
?><div class="group"></div></div>
<?php endif; ?>