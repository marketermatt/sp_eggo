<?php 
$image_width = get_option('thumbnail_size_w');
$image_height = get_option('thumbnail_size_h');
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('group list isotope'); ?>>
        	<?php $post_width = ($image_width + 20); ?>
                <div class="image-wrap">
        	<?php  
			$post_image_url = sp_get_image( $post->ID );
			if (has_post_thumbnail() && $post_image_url) { ?>
                <img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="wp-post-image" alt="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format( 'blog_list', $post_image_url, $image_width, $image_height ); ?>" />	
                <a href="<?php the_permalink(); ?>" title="<?php _e('READ MORE','sp'); ?>" class="post-image-link"><span class="readmore"><span class="icon">&nbsp;</span><?php _e('READ MORE','sp'); ?></span></a>
     <?php } ?>
                </div><!--close image-wrap-->
     
        	<div class="post-meta">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'sp' ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark"><?php the_title(); ?></a></h2>
    
                <div class="entry-meta">
                    <?php sp_posted_on(); ?>
                </div><!-- .entry-meta -->
                <span class="comments"><span><?php echo get_comments_number(); ?></span></span>
            </div><!--close post-meta-->
            <div class="post-bottom">
                <div class="entry-summary">
                	<p>
                	<?php
					$count = get_post_meta($post->ID, '_sp_truncate_count', true);
					$denote = get_post_meta($post->ID, '_sp_truncate_denote', true);
					$disabled = get_post_meta($post->ID, '_sp_truncate_disabled', true);
					?>
                    <?php if ( $disabled != '1' )
					{
                    echo sp_truncate(get_the_excerpt(), (!isset($count) || $count == null) ? 200 : $count, (!isset($denote) || $denote == null) ? '...' : $denote, get_post_meta($post->ID, '_sp_truncate_precision', true), true); 
					} else {
						the_excerpt();	
					}
					?>
                    </p>
                </div><!-- .entry-summary -->
                <div class="entry-utility">
                    <?php sp_posted_in_list(); ?>
                    <p><span class="comments-link"><span class="comment-icon">&nbsp;</span><?php comments_popup_link('', __( '1', 'sp' ), __( '%', 'sp' ) ); ?></span></p>
                    <?php edit_post_link( __( 'Edit', 'sp' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
                </div><!-- .entry-utility -->
            </div><!--close post-bottom-->
		</article><!-- #post-## -->
