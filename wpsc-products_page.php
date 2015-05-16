<?php
global $wp_query;	

$image_width = get_option('product_image_width');
$image_height = get_option('product_image_height');
$cat_image_width = sp_get_theme_init_setting('wpec_product_category_size', 'width');
$cat_image_height = sp_get_theme_init_setting('wpec_product_category_size', 'height');
?>
<div id="default_products_page_container" class="wrap wpsc_container group">

<?php 
$args = array( 
	'crumb-separator' => ''
);
wpsc_output_breadcrumbs($args); ?>
<?php 
if (sp_isset_option( 'product_view_buttons', 'boolean', 'true' )) {
	if (get_option('show_search') != '1') {
		echo sp_product_view(); 
	} else {
		if (get_option('show_advanced_search') != '1') {
			echo sp_product_view();	
		}
	}
}
?>
	<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
	<?php if(wpsc_display_categories()): ?>
	  <?php if(wpsc_category_grid_view()) :?>
			<div class="wpsc_categories wpsc_category_grid group">
            	<h2><?php _e('Categories','sp'); ?></h2>
				<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
					<div class="category-wrap">
                    <a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
						<?php wpsc_print_category_image(get_option('category_image_width'),get_option('category_image_height')); ?>
                        <span class="meta"><?php wpsc_print_category_name(); ?></span>
					</a>
                    </div><!--close category-wrap-->
					<?php //wpsc_print_subcategory("", ""); ?>
				<?php wpsc_end_category_query(); ?>
				
			</div><!--close wpsc_categories-->
	  <?php else:?>
      	<?php /*
			<ul class="wpsc_categories">
			
				<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
						<li>
							<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_image(get_option('category_image_width'), get_option('category_image_height')); ?><?php wpsc_print_category_name(); ?></a>
							<?php if(wpsc_show_category_description()) :?>
								<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>				
							<?php endif;?>
							
							<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
						</li>
				<?php wpsc_end_category_query(); ?>
			</ul> */ ?>
		<h2>Please switch to category grid view.</h2>
		<?php endif; ?>
	<?php endif; ?>
<?php // */ ?>
	
	<?php if(wpsc_display_products()): ?>
		
	<?php if(wpsc_is_in_category()) : ?>
		<?php if ((get_option('wpsc_category_description') || get_option('show_category_thumbnails')) && (sp_check_ms_image(wpsc_category_image()) || wpsc_category_description()) ) { ?>
            <div class="wpsc_category_details group">
                <?php if(get_option('show_category_thumbnails') && sp_check_ms_image(wpsc_category_image())) : ?>
                    <img src="<?php echo sp_timthumb_format( 'product_category_image', sp_check_ms_image(wpsc_category_image()), $cat_image_width, $cat_image_height); ?>" width="<?php echo $cat_image_width; ?>" height="<?php echo $cat_image_height; ?>" alt="<?php echo wpsc_category_name(); ?>" />
                <?php endif; ?>
                
                <?php if(get_option('wpsc_category_description') &&  wpsc_category_description()) : ?>
                    <p class="description"><?php echo wpsc_category_description(); ?></p>
                <?php endif; ?>
            </div><!--close wpsc_category_details-->
            <?php } ?>
	<?php endif; ?>
		<?php if(wpsc_has_pages_top()) : ?>
			<div class="wpsc_page_numbers_top">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_top-->
		<?php endif; ?>		
		
	
	
		<?php /** start the product loop here */?>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
			
			
			<?php if(wpsc_category_transition()) :?>
		  	<h3 class="wpsc_category_name"><?php echo wpsc_current_category_name(); ?></h3>
			<?php endif; ?>
		
			<div class="default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?> group">   
				<?php if(wpsc_show_thumbnails()) :?>
					<div class="imagecol" id="imagecol_<?php echo wpsc_the_product_id(); ?>">
							<div class="item_image">
						<?php if(wpsc_the_product_thumbnail()) : ?>
                            <div class="inner">
                            <a title="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>" data-id="<?php echo wpsc_the_product_id(); ?>">
                            <img class="product_image" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format( 'product_list', sp_get_image(wpsc_the_product_id()), $image_width, $image_height); ?>" /></a><a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>" class="more-button"><span class="icon">&nbsp;</span><?php _e('More Details','sp'); ?></a>
                        <?php if(wpsc_product_on_special()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
                              <div class="price_display <?php echo $onsale; ?>">
                                  <?php if(wpsc_product_on_special()) : ?>
                                <span class="flex"><span class="pricedisplay"><?php echo wpsc_product_normal_price(); ?></span><br /><span class="pricedisplay new"><?php echo wpsc_the_product_price(); ?></span></span>
                                  <?php else : ?>
                                      <span class="flex"><?php echo wpsc_the_product_price(); ?></span>
                                  <?php endif; ?>
                              </div><!--close price_display-->	 
                        		<img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" class="load loading-<?php echo wpsc_the_product_id(); ?>" />
                                                         
                            </div><!--close inner-->
                        	<span class="divider">&nbsp;</span>                                                  
						<?php else: ?>
                            	<div class="inner">
                            <a title="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo get_template_directory_uri(); ?>/images/no-product-image.jpg" data-id="<?php echo wpsc_the_product_id(); ?>">
                            <img class="no-image" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo sp_timthumb_format( 'product_list', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" /></a><a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>" class="more-button"><span class="icon">&nbsp;</span><?php _e('More Details','sp'); ?></a>
                        <?php if(wpsc_product_on_special()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
                              <div class="price_display <?php echo $onsale; ?>">
                                  <?php if(wpsc_product_on_special()) : ?>
                                <span class="flex"><span class="pricedisplay"><?php echo wpsc_product_normal_price(); ?></span><br /><span class="pricedisplay new"><?php echo wpsc_the_product_price(); ?></span></span>
                                  <?php else : ?>
                                      <span class="flex"><?php echo wpsc_the_product_price(); ?></span>
                                  <?php endif; ?>
                              </div><!--close price_display-->	                            
                        		<img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" class="load loading-<?php echo wpsc_the_product_id(); ?>" />
                              </div><!--close inner-->
                        <span class="divider">&nbsp;</span>                                                    
						<?php endif; ?>    
                        </div><!--close item_image-->
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
					</div><!--close imagecol-->
				<?php endif; ?>
					<div class="productcol">
						<?php							
							do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
							do_action('wpsc_product_addons', wpsc_the_product_id());
						?>
						<div class="leftcol">
                        <h2 class="prodtitle entry-title">
							<?php if(get_option('hide_name_link') == 1) : ?>
								<?php echo wpsc_the_product_title(); ?>
							<?php else: ?> 
								<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
							<?php endif; ?>
						</h2>   
						<div class="wpsc_description">
							<?php echo sp_wpsc_the_product_description(); ?>
                        </div><!--close wpsc_description-->
				
						<?php /*if(wpsc_the_product_additional_description()) : ?>
						<div class="additional_description_container">
							
								<img class="additional_description_button"  src="<?php echo get_template_directory_uri(); ?>/images/icon_plus.gif" alt="Additional Description" /><a href="<?php echo wpsc_the_product_permalink(); ?>" class="additional_description_link"><?php _e('More Details', 'sp'); ?>
							</a>
							<div class="additional_description">
								<?php echo sp_wpsc_the_product_additional_description(); ?>
							</div><!--close additional_description-->
						</div><!--close additional_description_container-->
						<?php endif; */?>
						
						<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
							<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
						<?php else: ?>
						<?php $action = htmlentities(wpsc_this_page_url(), ENT_QUOTES, 'UTF-8' ); ?>					
						<?php endif; ?>		
                        </div><!--close leftcol-->			
						<form class="product_form_ajax"  enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" >
                        <?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />                        
						<?php /** the variation group HTML and loop */?>
                        <?php if (wpsc_have_variation_groups()) { ?>
						<div class="wpsc_variation_forms">
                        	<table>
							<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
								<tr><td class="col1"><label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label><br />
								<?php /** the variation HTML and loop */?>
								<select class="wpsc_select_variation_ajax" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
								<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
									<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
								<?php endwhile; ?>
								</select></td></tr> 
							<?php endwhile; ?>
                            </table>
						</div><!--close wpsc_variation_forms-->
						<?php } ?>
						<?php /** the variation group HTML and loop ends here */?>
							
							<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
							<?php if(wpsc_has_multi_adding()): ?>
                            	<table class="quantity">
                                <tr><td>
                            	<label><?php _e('Quantity:', 'sp'); ?></label>
                                </td>
                                <td>
								<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
								<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
								<input type="hidden" name="wpsc_update_quantity" value="true" />
              
                                </td></tr>
                                </table>
							<?php endif ;?>
					
							<!-- END OF QUANTITY OPTION -->
							<?php if ( wpsc_product_has_personal_text() ) : ?>
								<fieldset class="custom_text">
									<p><span><?php _e( 'Personalize Your Product', 'sp' ); ?></span><br />
									<?php _e( 'Complete this form to include a personalized message.', 'sp' ); ?></p>
									<textarea name="custom_text"></textarea>
								</fieldset>
							<?php endif; ?>
						
							<?php if ( wpsc_product_has_supplied_file() ) : ?>

								<fieldset class="custom_file">
									<legend><?php _e( 'Upload a File', 'sp' ); ?></legend>
									<p><?php _e( 'Select a file from your computer to include with this purchase.', 'sp' ); ?></p>
									<input type="file" name="custom_file" />
								</fieldset>
							<?php endif; ?>	
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
									<!-- multi currency code -->
									<?php if(wpsc_product_has_multicurrency()) : ?>
	                                	<?php echo wpsc_display_product_multicurrency(); ?>
                                    <?php endif; ?>
									
									<?php if(wpsc_show_pnp()) : ?>
                                    	<?php if (!preg_match('/.[0].[0][0]/',wpsc_product_postage_and_packaging())) : ?>
										<p class="pricedisplay"><?php _e('Shipping', 'sp'); ?>:<span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
									<?php endif; ?>
                                    	<?php endif; ?>							
								<?php endif; ?>
									<?php if(wpsc_product_on_special()) : ?>
										<p class="pricedisplay_oldprice product_<?php echo wpsc_the_product_id(); ?>"><span class="oldprice old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span><br /><span class="currentprice pricedisplay product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_the_product_price(); ?></span></p>
                                        <p class="pricedisplay_save product_<?php echo wpsc_the_product_id(); ?>"><?php _e('You save', 'sp'); ?>: <span class="yousave yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>!</span></p>
									<?php else: ?>
									<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><span class="currentprice pricedisplay product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_the_product_price(); ?></span>
</p>                                    
                                  <?php endif; ?>
                                
							</div><!--close wpsc_product_price-->
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
							<div class="entry-utility wpsc_product_utility">
								<?php edit_post_link( __( 'Edit', 'sp' ), '<span class="edit-link">', '</span>' ); ?>
							</div>
                            <?php do_action ( 'wpsc_product_form_fields_end' ); ?>
						</form><!--close product_form-->
						<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
                        	<div class="paypal-buynow">
							<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
                            </div><!--close paypal-buynow-->
						<?php endif ; ?>						
						
					<?php // */ ?>
				</div><!--close productcol-->
		</div><!--close default_product_display-->

		<?php endwhile; ?>
		<?php /** end the product loop here */?>
		<?php if(wpsc_product_count() == 0):?>
			<h3><?php  _e('There are no products in this group.', 'sp'); ?></h3>
		<?php endif ; ?>
        <?php echo sp_fancy_notifications(); ?>
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="wpsc_page_numbers_bottom">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
    <input type="hidden" value="<?php echo get_option("fancy_notifications"); ?>" class="fancy-notification" />
</div><!--close default_products_page_container-->
