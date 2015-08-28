<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @package WooCommerce
 * @version 2.4.0
 * @since WooCommerce 1.0
 * @todo replace loop-shop with a content template and include query/loop here instead.
 */

get_header('shop'); ?>
	  
	<?php 
		/** 
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */	 
		do_action('woocommerce_before_main_content');
	?>

		<h1 class="page-title">
			<?php if ( is_search() ) : ?>
				<?php 
					printf( __( 'Search Results: &ldquo;%s&rdquo;', 'sp' ), get_search_query() ); 
					if ( get_query_var( 'paged' ) )
						printf( __( '&nbsp;&ndash; Page %s', 'sp' ), get_query_var( 'paged' ) );
				?>
			<?php elseif ( is_tax() ) : ?>
				<?php echo single_term_title( "", false ); ?>
			<?php else : ?>
				<?php 
					$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
					
					echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
				?>
			<?php endif; ?>
		</h1>
				
		<?php if ( is_tax() && get_query_var( 'paged' ) == 0 ) : ?>
			<?php echo '<div class="term-description">' . wpautop( wptexturize( term_description() ) ) . '</div>'; ?>
		<?php elseif ( ! is_search() && get_query_var( 'paged' ) == 0 && ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
			<?php echo '<div class="page-description">' . apply_filters( 'the_content', $shop_page->post_content ) . '</div>'; ?>
		<?php endif; ?>
				
		<?php if ( have_posts() ) : ?>
		
			<?php do_action('woocommerce_before_shop_loop'); ?>
			
			<?php woocommerce_product_subcategories( array( 'before' => '<div class="categories-list group"><h3>'.__( 'Quick Category Change', 'sp' ).'</h3><ul class="cat">', 'after' => '</ul></div>' )); ?>
		
			<ul class="products">
					
				<?php while ( have_posts() ) : the_post(); ?>
		
					<?php woocommerce_get_template_part( 'content', 'product' ); ?>
		
				<?php endwhile; // end of the loop. ?>
				
			</ul>
			<input type="hidden" value="<?php echo sp_isset_option( 'quickview', 'value' ); ?>" class="quickview_enabled" />
			<?php do_action('woocommerce_after_shop_loop'); ?>
<!--BEGIN QUICKVIEW CONTAINER-->
	<?php if (sp_isset_option('quickview', 'boolean', 'true')) { ?>
	<div class="quickview_product_display group">
    <?php
	if ( have_posts()) : while (have_posts()) : the_post(); 
		global $product, $post, $woocommerce_loop;
		
		if (!$product->is_visible()) continue; 
		$woocommerce_loop['loop']++; ?>
			
            <div id="product-<?php echo $post->ID; ?>" class="product_item product product_view_<?php echo $post->ID; ?> group" style="display:none" itemtype="http://schema.org/Product" itemscope="">   
                        
					<div class="imagecol images">
                    	<div class="meta">
		                	<h2 class="prodtitle entry-title"><?php the_title(); ?></h2>   
                        </div><!--close meta-->
						<?php if(has_post_thumbnail()) :
							$sizes = sp_quickview_image_size( sp_get_image($post->ID) );
							$image_width = $sizes['image_width'];
							$image_height = $sizes['image_height'];
                        	?>
							<a data-rel="prettyPhoto[<?php echo $post->ID; ?>]" title="<?php the_title_attribute(); ?>" href="<?php echo sp_get_image($post->ID); ?>" class="zoom thickbox preview_link" onclick="return false;" data-id="<?php echo $post->ID; ?>">
						<img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="product_image" alt="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format('quickview_main', sp_get_image($post->ID), $image_width, $image_height); ?>" />
                        							
                            </a>
						<?php else: 
							$image_width = '347';
							$image_height = '347';
						?>
								<a data-rel="prettyPhoto[<?php echo $post->ID; ?>]" title="<?php the_title_attribute(); ?>" href="<?php echo get_template_directory_uri(); ?>/images/no-product-image.jpg" class="zoom thickbox preview_link" onclick="return false;" data-id="<?php echo $post->ID; ?>">
									<img class="no-image" alt="No Image" title="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format('quickview_main', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" />
								</a>
						<?php endif; ?>
                        <?php
							global $main_image_height; 
							$main_image_height = $image_height; 							
                            do_action('woocommerce_product_thumbnails');
                        ?>
                        
					</div><!--close imagecol-->
					<div class="productcol group">	
                    	<div class="meta">	
						<?php 
                        if ( sp_isset_option( 'product_rating_stars', 'boolean', 'true' ) )
                            echo sp_get_star_rating(); 
                        ?>			
                        				
                        <ul class="social group">
							<?php if (sp_isset_option( 'gplusone_button', 'boolean', 'true' )) : ?>
                            <li>
                            
                                  <?php if (sp_isset_option( 'gplusone_counter', 'value' ) == '' || ! sp_isset_option( 'gplusone_counter', 'isset' )) {
                                        $counter = 'false';	
                                    } else {
                                        $counter = 'true';	
                                    }
                                echo sp_gplusonebutton_shortcode(array('url' => 'post','size' => sp_isset_option( 'gplusone_size', 'value' ), 'count' => $counter)); ?>
                            </li>
                            <?php endif; ?>
						<?php if (sp_isset_option('facebook_like_button', 'boolean', 'true')) : ?>
                        <li>                                                
	                        <div class="fb-like" data-href="<?php echo the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
                        </li>  
                        <?php endif; ?>                          
                        </ul>
                        </div><!--close meta-->
						<div class="woo_description">
							<?php echo the_content(); ?>
                        </div><!--close wpsc_description-->
                        <?php if ($product->get_price_html()) { ?>
                        <p class="price"><?php echo $product->get_price_html(); ?></p>
                        <?php } ?>
                        <?php 
						switch($product->product_type) :
							case 'simple' : 
								woocommerce_simple_add_to_cart();
							break;
							
							case 'variable' :
								woocommerce_variable_add_to_cart();
							break;
														
							case 'grouped' :
								woocommerce_grouped_add_to_cart();
							break;
							
							case 'external' :
								woocommerce_external_add_to_cart();
							break;
						endswitch;
						
						?>
                        <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="more"><?php _e('More Info', 'sp'); ?></a>
				</div><!--close productcol-->
			<a href="#" title="<?php _e('Close','sp'); ?>" class="close"><?php _e('Close', 'sp'); ?></a>
		</div><!--close product_item-->        
	<?php endwhile; endif;
	?>
    </div><!--close quickview_product_display-->
	<?php } ?>
		
		<?php else : ?>
		
			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
					
				<p><?php _e( 'No products found which match your selection.', 'sp' ); ?></p>
					
			<?php endif; ?>
		
		<?php endif; ?>
		
		<div class="group"></div>

		<?php 
			/** 
			 * woocommerce_pagination hook
			 *
			 * @hooked woocommerce_pagination - 10
			 * @hooked woocommerce_catalog_ordering - 20
			 */		
			do_action( 'woocommerce_pagination' ); 
		?>

	<?php
		/** 
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */	 
		do_action('woocommerce_after_main_content'); 
	?>

	<?php 
		/** 
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */		
		do_action('woocommerce_sidebar'); 
	?>

<?php get_footer('shop'); ?>