<?php
global $wp_query;
$image_width = get_option('product_image_width');
$image_height = get_option('product_image_height');

$grid_cat = sp_isset_option( 'homepage_featured_grid_cat', 'value' );
$grid_rand = sp_isset_option( 'homepage_featured_grid_random', 'value' );
$product_count = sp_isset_option( 'homepage_featured_grid_product_count', 'value' );

$products = sp_wpec_get_products( $grid_cat, $product_count, $grid_rand ); // limit to 30 products
if ( isset( $products ) ) {
	list( $wp_query, $products ) = array( $products, $wp_query ); 
	$GLOBALS['nzshpcrt_activateshpcrt'] = true;
	?>
	<div id="grid_view_products_page_container_home">
	<?php if(wpsc_display_products()): ?>
		
		<div class="product_grid_display group">
	    	<?php $count = 1; ?>
			<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
				<div class="product_grid_item product_view_<?php echo wpsc_the_product_id(); ?>">                    	
						<div class="item_image">
							<?php if(wpsc_the_product_thumbnail()) :?> 	   
							<div class="inner">
	                        <?php if (! sp_isset_option( 'quickview', 'isset' )) { ?>
	                        <a title="<?php echo wpsc_the_product_title(); ?>" href="<?php echo wpsc_the_product_permalink(); ?>">
	                        <?php } ?>                        
							<img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="product_image" alt="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format( 'product_grid', sp_get_image(wpsc_the_product_id()), $image_width, $image_height ); ?>" />
	                        <?php if (! sp_isset_option( 'quickview', 'isset' )) { ?>
	                        </a>
	                        <?php } ?>
	                        <?php if (sp_isset_option( 'quickview', 'boolean', 'true' ) ) { ?>
	                        <span class="quickview-button"><span class="icon">&nbsp;</span><?php _e('QUICKVIEW','sp'); ?></span>
							<?php } ?>
	                            <a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>" class="more-button"><span class="icon">&nbsp;</span><?php _e('More Details','sp'); ?></a>                    
							<?php if(get_option('show_images_only') != 1): ?>
	                        <?php if(wpsc_product_on_special()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
	                        <div class="price_display <?php echo $onsale; ?>">
	                            <?php if(wpsc_product_on_special()) : ?>
	                                <span class="flex"><span class="pricedisplay"><?php echo wpsc_product_normal_price(); ?></span><br /><span class="pricedisplay new"><?php echo wpsc_the_product_price(); ?></span></span>
	                            <?php else : ?>
	                            	<span class="flex"><?php echo wpsc_the_product_price(); ?></span>
	                            <?php endif; ?>
	                        </div><!--close price_display-->	
	                        <?php endif; ?>
							</div><!--close inner-->
	                        <input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" class="hidden-id" />
	                        <span class="divider">&nbsp;</span>                      
					<?php else: ?> 
							<div class="inner">
	                        <?php if (! sp_isset_option( 'quickview', 'isset' )) { ?>                        
	                        <a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>">
	                        <?php } ?>                        
							<img alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format('product_grid', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height ); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" />
	                        <?php if (! sp_isset_option( 'quickview', 'isset' )) { ?>                        
							</a>
	                        <?php } ?>
	                        <?php if (sp_isset_option( 'quickview', 'boolean', 'true' )) { ?>
	                        <span class="quickview-button"><span class="icon">&nbsp;</span><?php _e('QUICKVIEW','sp'); ?></span>
							<?php } ?>
	                            <a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>" class="more-button"><span class="icon">&nbsp;</span><?php _e('More Details','sp'); ?></a>                    
							<?php if(get_option('show_images_only') != 1): ?>
	                        <?php if(wpsc_product_on_special()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
	                        <div class="price_display <?php echo $onsale; ?>">
	                            <?php if(wpsc_product_on_special()) : ?>
	                                <span class="flex"><span class="pricedisplay"><?php echo wpsc_product_normal_price(); ?></span><br /><span class="pricedisplay new"><?php echo wpsc_the_product_price(); ?></span></span>
	                            <?php else : ?>
	                            	<span class="flex"><?php echo wpsc_the_product_price(); ?></span>
	                            <?php endif; ?>
	                        </div><!--close price_display-->	
	                        <?php endif; ?>
							</div><!--close inner-->
	                        <input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" class="hidden-id" /> 
	                        <span class="divider">&nbsp;</span>                      
					<?php endif; ?> 	
						</div><!--close item_image-->
	                <h2 class="prodtitle"><a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>"><?php echo wpsc_the_product_title(); ?></a></h2>	
	                					
				</div><!--close product_grid_item-->
	            <?php /*
					if ((($wp_query->current_post + 1) % 4) == 0 ) { echo '<div class="group">&nbsp;</div>'; }
					$count++;
					*/
				?>
			<?php endwhile; ?>
			
			<?php if(wpsc_product_count() == 0):?>
				<p><?php  _e('There are no products in this group.', 'sp'); ?></p>
			<?php endif ; ?>
			
		</div><!--close product_grid_display-->

	<!--BEGIN QUICKVIEW CONTAINER-->
		<?php if (sp_isset_option( 'quickview', 'boolean', 'true' )) { ?>
		<div class="quickview_product_display group">
			<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
	            <div class="product_item product_view_<?php echo wpsc_the_product_id(); ?> group" style="display:none">   
						<div class="imagecol">
	                    	<div class="meta">
			                	<h2 class="prodtitle entry-title"><?php echo wpsc_the_product_title(); ?></h2>   
	                        </div><!--close meta-->
					<?php if(wpsc_show_thumbnails()) :?>
							<?php if(wpsc_the_product_thumbnail()) : ?>
							<?php
								$sizes = sp_quickview_image_size( sp_get_image($post->ID) );
								$image_width = $sizes['image_width'];
								$image_height = $sizes['image_height'];
	                        	?>
								<a data-rel="prettyPhoto[<?php echo wpsc_the_product_id(); ?>]" title="<?php echo wpsc_the_product_title(); ?>" href="<?php echo wpsc_the_product_image(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" onclick="return false;" data-id="<?php echo wpsc_the_product_id(); ?>">
							<img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="product_image" alt="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format( 'quickview_main', sp_get_image(wpsc_the_product_id()), $image_width, $image_height); ?>" />
	                        <img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" class="load loading-<?php echo wpsc_the_product_id(); ?>" />                        
								</a>
							<?php else: 
								$image_width = '347';
								$image_height = '347';						
							?>
									<a data-rel="prettyPhoto[<?php echo wpsc_the_product_id(); ?>]" title="<?php echo wpsc_the_product_title(); ?>" href="<?php echo get_template_directory_uri(); ?>/images/no-product-image.jpg" class="<?php echo wpsc_the_product_image_link_classes(); ?>" onclick="return false;" data-id="<?php echo wpsc_the_product_id(); ?>">
										<img class="no-image" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format( 'quickview_main', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height ); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" />
	                        <img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" class="load loading-<?php echo wpsc_the_product_id(); ?>" />                                    
									</a>
							<?php endif; ?>
							<?php
							if ( sp_isset_option( 'show_gallery', 'boolean', 'true' ) ) :					
								echo sp_main_display_gallery(wpsc_the_product_id(), $image_height);
							endif;
							?>	
					<?php endif; ?>
						</div><!--close imagecol-->
						<div class="productcol group">
	                    	<div class="meta">
							<?php
	                        if(get_option( 'product_ratings' ) == 1) :
								echo sp_product_rating(get_the_ID()); 
							endif;						
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
								<!--sharethis-->
								<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
	                        <li>
								<div class="st_sharethis" displayText="ShareThis"></div>
	                		</li>
								<?php endif; ?>
								<!--end sharethis-->
	                        
	                        
							<?php if(wpsc_show_fb_like()): ?>
	                        <li>                        
	                            <div class="fb-like" data-href="<?php echo wpsc_the_product_permalink(); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
	                        </li>
	                        <?php endif; ?>
	                            
	                        </ul>
	                    	</div><!--close meta-->					
							<?php							
								do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
								do_action('wpsc_product_addons', wpsc_the_product_id());
							?>
							
							
							<div class="wpsc_description">
								<?php echo sp_wpsc_the_product_description(); ?>
	                        </div><!--close wpsc_description-->
											
							<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
								<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
							<?php else: ?>
							<?php $action = htmlentities(wpsc_this_page_url(), ENT_QUOTES, 'UTF-8' ); ?>					
							<?php endif; ?>					
							<form class="product_form_ajax group"  enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>">
	                        <?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
							<?php /** the variation group HTML and loop */?>
	                        <?php if (wpsc_have_variation_groups()) { ?>
	                        <fieldset>
							<div class="wpsc_variation_forms">
	                        	<table><?php $i = 1; ?>
								<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
									<?php if ($i&1) { ?><tr><?php } ?>
	                                <td class="col1"><label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label><br />
									<?php /** the variation HTML and loop */?>
									<p class="select-style"><select class="wpsc_select_variation_ajax" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
									<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
										<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
									<?php endwhile; ?>
									</select></p></td>
	                                <?php if (!$i&1) { ?></tr><?php } ?> 
	                                <?php $i++; ?>
								<?php endwhile; ?>
	                            </table>
							</div><!--close wpsc_variation_forms-->
	                        </fieldset>
							<?php } ?>
							<?php /** the variation group HTML and loop ends here */?>
								
								<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
								<?php if(wpsc_has_multi_adding()): ?>
	                            	
									<div class="wpsc_quantity_update">
	                                <label for="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>"><?php _e('Quantity', 'sp'); ?>:
									<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" /></label>
									<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
									<input type="hidden" name="wpsc_update_quantity" value="true" />
	                                </div><!--close wpsc_quantity_update-->
	                                
								<?php endif ;?>

								<div class="wpsc_product_price">
									<?php if( wpsc_show_stock_availability() ): ?>
										<?php if(wpsc_product_has_stock()) : ?>
											<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><img src="<?php echo get_template_directory_uri(); ?>/images/instock.png" alt="In Stock" width="16" height="16" /><?php _e('Product in stock', 'sp'); ?></div>
										<?php else: ?>
											<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><img src="<?php echo get_template_directory_uri(); ?>/images/outofstock.png" alt="Out of Stock" width="16" height="16" /><?php _e('Product not in stock', 'sp'); ?></div>
										<?php endif; ?>
									<?php endif; ?>
									<?php if(wpsc_product_is_donation()) : ?>
										<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'sp'); ?>: </label>
										<input type="text" class="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />

									<?php else : ?>
										<?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay_oldprice product_<?php echo wpsc_the_product_id(); ?>"><?php _e('Old Price', 'sp'); ?>: <span class="oldprice old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span></p>
										<?php endif; ?>
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('Price', 'sp'); ?>: <span class="currentprice pricedisplay product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_the_product_price(); ?></span></p>
										<?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay_save product_<?php echo wpsc_the_product_id(); ?>">(<?php _e('You save', 'sp'); ?>: <span class="yousave yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>!)</span></p>
										<?php endif; ?>
										
										<!-- multi currency code -->
										<?php if(wpsc_product_has_multicurrency()) : ?>
		                                	<?php echo wpsc_display_product_multicurrency(); ?>
	                                    <?php endif; ?>
										
										<?php if(wpsc_show_pnp()) : ?>
											<p class="pricedisplay"><?php _e('Shipping', 'sp'); ?>:<span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
										<?php endif; ?>							
									<?php endif; ?>
								</div><!--close wpsc_product_price-->
								
								<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
								<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
						
								<!-- END OF QUANTITY OPTION -->
								<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div class="wpsc_buy_button_container group">
												<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
												<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
												<div class="input-button-buy"><span><input class="wpsc_buy_button external-purchase" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'sp' ) ); ?>" data-external-link="<?php echo $action; ?>" data-link-target="<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>" /></span></div><!--close input-button-buy-->
												<?php else: ?>
											<div class="input-button-buy"><span><input type="submit" value="<?php _e('Add To Cart', 'sp'); ?>" name="Buy" class="wpsc_buy_button" /></span>
	                                        <div class="alert error"><p><?php _e('Please select product options before adding to cart','sp'); ?></p><span>&nbsp;</span></div>
	                                        <div class="alert addtocart"><p><?php _e('Item has been added to your cart!','sp'); ?></p><span>&nbsp;</span></div>                                                                                                                     
	                                        </div><!--close input-button-buy-->
											<div class="wpsc_loading_animation">
												<img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" />
												
											</div><!--close wpsc_loading_animation-->                                        
												<?php endif; ?>
										</div><!--close wpsc_buy_button_container-->
									<?php endif ; ?>
								<?php endif ; ?>
	                            <?php if (edit_post_link()) { ?>
								<div class="entry-utility wpsc_product_utility">
									<?php edit_post_link( __( 'Edit', 'sp' ), '<span class="edit-link">', '</span>' ); ?>
								</div>
	                            <?php } ?>
	                            <a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php _e('More','sp'); ?>" class="more-link"><?php _e('MORE INFO','sp'); ?></a>
	                            <?php do_action ( 'wpsc_product_form_fields_end' ); ?>
							</form><!--close product_form-->
							
							<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
	                        	<div class="paypal-buynow">
								<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
	                            </div><!--close paypal-buynow-->
							<?php endif ; ?>						
							
						<?php // */ ?>
					</div><!--close productcol-->
				<a href="#" title="<?php _e('Close','sp'); ?>" class="close"><?php _e('Close', 'sp' ); ?></a>
			</div><!--close product_item-->
			<?php endwhile; ?>
			
			<?php if(wpsc_product_count() == 0):?>
				<p><?php  _e('There are no products in this group.', 'sp'); ?></p>
			<?php endif ; ?>
			<input type="hidden" value="<?php echo sp_isset_option( 'quickview', 'value' ); ?>" class="quickview_enabled" />
		</div><!--close quickview_product_display-->
		<?php } ?>
		<?php list( $products, $wp_query ) = array( $wp_query, $products ); ?>
	<?php endif; ?>
		
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

	</div><!--close grid_view_products_page_container-->
	<?php wp_reset_postdata(); ?>
<?php
} // close isset products
?>