<?php	
	$pagination = sp_isset_option( 'blog_pagination', 'value' );
	$image_width = sp_get_theme_init_setting('post_single_image_size','width'); 
	$image_height = sp_get_theme_init_setting('post_single_image_size','height');
	
	$post_image_url = sp_get_image( $post->ID );
?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('group single'); ?>>
					
                		<?php if (has_post_thumbnail() && $post_image_url) { ?>   
                        <div class="top group">                 
                            <img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="wp-post-image" alt="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format( 'blog_single', $post_image_url, $image_width, $image_height ); ?>" />
                            <div class="title">
                            	<h2 class="entry-title"><?php the_title(); ?></h2>
                                <div class="entry-meta">
                                    <?php sp_posted_on(); ?>
                                    <span class="comments"><span><?php echo get_comments_number(); ?></span></span>
                                </div><!-- .entry-meta -->
                                
                            </div><!--close entry-title-->
                            <div class="entry-utility">
                                <?php sp_posted_in_list(); ?>
                                <?php edit_post_link( __( 'Edit', 'sp' ), '<span class="edit-link">', '</span>' ); ?>
                            </div><!-- .entry-utility -->
					</div><!--close top-->
					<div class="entry-content group">
                        <?php } else { ?>
						<div class="top group no-image">
                            <div class="title">
                            	<h2 class="entry-title"><?php the_title(); ?></h2>
                                <div class="entry-meta">
                                    <?php sp_posted_on(); ?>
                                    <span class="comments"><span><?php echo get_comments_number(); ?></span></span>
                                </div><!-- .entry-meta -->
                                <div class="entry-utility">
                                    <?php sp_posted_in_list(); ?>
                                    <?php edit_post_link( __( 'Edit', 'sp' ), '<span class="edit-link">', '</span>' ); ?>
                                </div><!-- .entry-utility -->
                            </div><!--close entry-title-->
					</div><!--close top-->
					<div class="entry-content no-image group">
                        <?php } ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'sp' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-## -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<div id="entry-author-info" class="group">
                    	<h2><?php printf( esc_attr__( 'About %s', 'sp' ), get_the_author() ); ?></h2>
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'sp_author_bio_avatar_size', 100 ),'',get_the_author_meta( 'display_name' ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							
							<p><?php the_author_meta( 'description' ); ?></p>
							<div id="author-link">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
									<?php printf( __( 'View all posts by %s', 'sp' ), get_the_author() ); ?>
								</a>
							</div><!-- #author-link	-->
						</div><!-- #author-description -->
					</div><!-- #entry-author-info -->
<?php endif; ?>
                <?php if (isset($pagination) && $pagination == 'no-pagination') { 
					// show nothing
				} else { ?>
				<div id="nav-below" class="navigation group">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="arrow">&lt;</span>%title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title<span class="arrow">&gt;</span>' ); ?></div>
				</div><!-- #nav-below -->
                <?php } ?>
				<?php 
				if (sp_isset_option( 'show_related_posts', 'boolean', 'true' )) {
					sp_related_post(); 
				} 
				?>
                
				<div class="btt group"><a href="#top" title="<?php _e('Back to Top', 'sp'); ?>"><?php _e('Back to Top', 'sp'); ?> <span class="icon">&nbsp;</span></a></div>
                        <ul class="social group">
						<?php if (sp_isset_option( 'gplusone_button', 'boolean', 'true' )) :
                                if ( ! sp_isset_option( 'gplusone_counter', 'isset' )) {
                                    $counter = 'false';	
                                } else {
                                    $counter = 'true';	
                                } ?>
                        	<li>
                            <?php    
                            echo sp_gplusonebutton_shortcode(array('url' => 'post','size' => sp_isset_option( 'gplusone_size', 'value' ), 'count' => $counter)); 
							?>
							</li>
                            
                        <?php endif; ?>
							<!--sharethis-->
							<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
	                        <li>
							<div class="st_sharethis" displayText="ShareThis"></div>
                            </li>
							<?php endif; ?>
							<!--end sharethis-->
						<?php if(sp_isset_option( 'facebook_like_button', 'boolean', 'true' )) : ?>
                        <li>                                                
	                        <div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
                       </li>
                        <?php endif; ?>
                        </ul>
