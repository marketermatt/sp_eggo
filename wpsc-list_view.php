<?php
global $wp_query;

$cat_image_width = sp_get_theme_init_setting('wpec_product_category_size', 'width');
$cat_image_height = sp_get_theme_init_setting('wpec_product_category_size', 'height');

?>
<div id="list_view_products_page_container">

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



	
	<?php if(wpsc_display_products()): ?>
	<?php if(wpsc_is_in_category()) : ?>
		<?php if ((get_option('wpsc_category_description') || get_option('show_category_thumbnails')) && (sp_check_ms_image(wpsc_category_image()) || wpsc_category_description()) ) { ?>
            <div class="wpsc_category_details group">
                <?php if(get_option('show_category_thumbnails') && sp_check_ms_image( wpsc_category_image() )) : ?>
                    <img src="<?php echo sp_timthumb_format( 'product_category_image', sp_check_ms_image( wpsc_category_image() ), $cat_image_width, $cat_image_height ); ?>" width="<?php echo $cat_image_width; ?>" height="<?php echo $cat_image_height; ?>" alt="<?php echo wpsc_category_name(); ?>" />
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
		<table class="list_productdisplay <?php echo wpsc_category_class(); ?>">
			<?php /** start the product loop here */?>
			<?php $alt = 0;	?>
			<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
				<?php
				$alt++;
				if ($alt %2 == 1) { $alt_class = 'alt'; } else { $alt_class = ''; }
				?>
				<tr class="product_view_<?php echo wpsc_the_product_id(); ?> <?php echo $alt_class;?>">
					<td class="title-cell">
						<h2 class="prodtitle">
							<?php if(get_option('hide_name_link') == 1) : ?>
								<?php echo wpsc_the_product_title(); ?>
							<?php else: ?> 
								<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
							<?php endif; ?>
							<?php echo wpsc_edit_the_product_link(); ?>
						</h2>
					</td>
					<?php if(wpsc_show_stock_availability()): ?>	
						<td class="stock">
						<?php if(wpsc_product_has_stock()) : ?>
									<div class="in_stock stock_display_<?php echo wpsc_the_product_id(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/instock.png" alt="In Stock" /><?php _e('Product in stock', 'sp'); ?></div>
							<?php else: ?>
									<div class="out_of_stock stock_display_<?php echo wpsc_the_product_id(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/outofstock.png" alt="Out of Stock" /><?php _e('Product not in stock', 'sp'); ?></div>
							<?php endif; ?>
						</td>
					<?php endif; ?>
					
					<td>
 						<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post); ?>
					</td>
					<td class='wpsc_price_td price-cell'>
                  			<?php if(wpsc_product_on_special()) : ?>
						<p class="oldprice"><?php echo wpsc_product_normal_price(); ?></p><br />
					<?php endif; ?>
						<p id="product_price_<?php echo wpsc_the_product_id(); ?>" class="pricedisplay currentprice"><?php echo wpsc_the_product_price(); ?></p>
					</td>
					
					<td class="quantity-cell">
						<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
							<?php	$action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
						<?php else: ?>
							<?php	$action =  wpsc_this_page_url(); ?>						
						<?php endif; ?>
						<form class='product_form_ajax' id="product_<?php echo wpsc_the_product_id(); ?>" enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>">
							<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>						
							<?php if(wpsc_has_multi_adding()): ?>
                            <div class="quantity_container">
								<label class="wpsc_quantity_update" for="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>"><?php _e('Quantity', 'sp'); ?>:</label>
								<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
								<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
								<input type="hidden" name="wpsc_update_quantity" value="true" />
							</div><!--close quantity_container-->
							<?php endif ;?>		
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />
	
							<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
											<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
											<div class="input-button-buy"><span><input class="wpsc_buy_button external-purchase" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'sp' ) ); ?>" data-external-link="<?php echo $action; ?>" data-link-target="<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>" /></span></div><!--close input-button-buy-->
											<?php else: ?>
                                        <?php if (wpsc_have_variation_groups()) { ?>    
										<a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>" class="more-button"><span><?php _e('More Info','sp'); ?></span></a>
                                        <?php } else { ?>
										<div class="input-button-buy"><span><input type="submit" value="<?php _e('Add To Cart', 'sp'); ?>" name="Buy" class="wpsc_buy_button" /></span>
                                        <div class="alert error"><p><?php _e('Please select product options before adding to cart','sp'); ?></p><span>&nbsp;</span></div>
                                        <div class="alert addtocart"><p><?php _e('Item has been added to your cart!','sp'); ?></p><span>&nbsp;</span></div>                                                                                                                     
                                        </div><!--close input-button-buy-->
										<div class="wpsc_loading_animation">
											<img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" />
											
										</div><!--close wpsc_loading_animation-->                                        
                                        <?php } ?>
											<?php endif; ?>
									</div><!--close wpsc_buy_button_container-->
								<?php else : ?>
								<?php endif ; ?>
							<?php endif ; ?>
							<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
						</form>
					</td>
				</tr>
			<?php endwhile; ?>
			<?php /** end the product loop here */?>
		</table>
		
		
		<?php if(wpsc_product_count() == 0):?>
			<p><?php  _e('There are no products in this group.', 'sp'); ?></p>
		<?php endif ; ?>
	
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

			<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="wpsc_page_numbers_bottom">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close list_view_products_page_container-->
