<?php if(isset($cart_messages) && count($cart_messages) > 0) { ?>
	<?php foreach((array)$cart_messages as $cart_message) { ?>
	  <span class="cart_message"><?php echo $cart_message; ?></span>
	<?php } ?>
<?php } ?>

<?php if(wpsc_cart_item_count() > 0): ?>
    <div class="shoppingcart">
	<table>
		<thead>
			<tr>
			    <th>&nbsp;</th>
				<th class="product"><?php _e('Product', 'sp'); ?></th>
				<th class="quantity"><?php _e('Qty', 'sp'); ?></th>
				<th class="price"><?php _e('Price', 'sp'); ?></th>
	            <th class="remove">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
        <?php 	$image_width = 30;
				$image_height = 30;
		?>
        
		<?php while(wpsc_have_cart_items()): wpsc_the_cart_item(); ?>
			<tr>
            		<td><?php if('' != wpsc_cart_item_image()): ?>
            <a href="<?php echo wpsc_cart_item_url(); ?>"><img src="<?php echo sp_cart_item_image(wpsc_cart_item_product_id(),$image_width, $image_height); ?>" alt="<?php echo wpsc_cart_item_name(); ?>" title="<?php echo wpsc_cart_item_name(); ?>" class="product_image" /></a>
         <?php else:
         /* I dont think this gets used anymore,, but left in for backwards compatibility */
         ?>
               <a href="<?php echo wpsc_cart_item_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/no-product-image.jpg " height="<?php echo $image_height; ?>" width="<?php echo $image_width; ?>" alt="<?php echo wpsc_cart_item_name(); ?>" title="<?php echo wpsc_cart_item_name(); ?>" class="product_image" /></a>
         <?php endif; ?>
					</td>
					<td class='product-name'><a href="<?php echo wpsc_cart_item_url(); ?>"><?php echo wpsc_cart_item_name(); ?></a></td>
					<td><?php echo wpsc_cart_item_quantity(); ?></td>
					<td><?php echo wpsc_cart_item_price(); ?></td>
                    <td class="cart-widget-remove"><form action="#" method="post" class="adjustform">
					<input type="hidden" name="quantity" value="0" />
					<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
					<input type="hidden" name="wpsc_update_quantity" value="true" />
					<input class="remove_button" type="submit" />
				</form></td>
			</tr>	
		<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr class="cart-widget-total">
				<td class="cart-widget-count" colspan="2">
					<?php printf( _n('%d item', '%d items', wpsc_cart_item_count(), 'sp'), wpsc_cart_item_count() ); ?>
				</td>
				<td class="pricedisplay checkout-total" colspan='3'>
					<?php _e('Sub Total', 'sp'); ?>: <?php echo wpsc_cart_total_widget(false,false,false); ?>
				</td>
			</tr>
			<?php if(wpsc_cart_show_plus_postage()) : ?>
			<tr>
				<td class="pluspostagetax" colspan='3'>
					+ <?php _e('Postage &amp; Tax ', 'sp'); ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class='cart-widget-links' colspan="5">
					<a target="_parent" href="<?php echo get_option('shopping_cart_url'); ?>" title="<?php _e('Checkout', 'sp'); ?>" class="buy-button"><span><?php _e('CheckOut', 'sp'); ?></span></a>
					<form action="#" method="post" class="wpsc_empty_the_cart">
						<input type="hidden" name="wpsc_ajax_action" value="empty_cart" />
							<a target="_parent" href="<?php echo esc_url( add_query_arg( 'wpsc_ajax_action', 'empty_cart', remove_query_arg( 'ajax' ) ) ); ?>" class="emptycart_ajax" title="<?php _e('Empty Your Cart', 'sp'); ?>"><span class="icon">&nbsp;</span><?php _e('Clear cart', 'sp'); ?></a>                        
                            <img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" class="empty-cart-loading" />                                                             
					</form>
				</td>
			</tr>
		</tfoot>
	</table>
	<?php 
    if (array_search("google",(array)get_option('custom_gateway_options')) !== false ) { ?>
    <div class="google-checkout">
    <?php wpsc_google_checkout(); ?>
    </div><!--close google-checkout-->
    <?php } ?>   
    <div class="group"></div> 
	</div><!--close shoppingcart-->		
<?php else: ?>
	<p class="empty">
		<?php _e('Your shopping cart is empty', 'sp'); ?>
	</p>
<?php endif; ?>

