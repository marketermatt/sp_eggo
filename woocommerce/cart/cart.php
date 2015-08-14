<?php
/**
 * Cart Page
 *
 * @package WooCommerce/Templates
 * @version 2.3.8
 */
 
global $woocommerce;
?>


<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post" class="woo_cart">
<?php do_action( 'woocommerce_before_cart_table' ); ?>

<div id="status-bg">
	<span class="cart active"><span><?php _e('Your Cart','sp'); ?></span></span>
    <span class="info"><span><?php _e('Info','sp'); ?></span></span>
    <span class="final"><span><?php _e('Final','sp'); ?></span></span>
</div><!--close status-bg-->
	<div class="yourtotal"><span class="title"><?php _e('Sub-Total:', 'sp'); ?></span><span class="total"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></div>
<?php wc_print_notices(); ?>
<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e('Product', 'sp'); ?></th>
			<th class="product-price"><?php _e('Price', 'sp'); ?></th>
			<th class="product-quantity"><?php _e('Quantity', 'sp'); ?></th>
			<th class="product-subtotal"><?php _e('Total', 'sp'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		
		<?php
		if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				if ( $_product->exists() && $values['quantity'] > 0 ) {
					?>
					<tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">
						<!-- Remove from cart link -->
						<td class="product-remove">
							<?php 
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'sp') ), $cart_item_key ); 
							?>
						</td>
						
						<!-- The thumbnail -->
						<td class="product-thumbnail">
							<?php 
								$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );
								printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail ); 
							?>
						</td>
						
						<!-- Product Name -->
						<td class="product-name">
							<?php 
								if ( ! $_product->is_visible() || ( $_product instanceof WC_Product_Variation && ! $_product->parent_is_visible() ) )
									echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
								else
									printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );
														
								// Meta data
								echo $woocommerce->cart->get_item_data( $values );
                   				
                   				// Backorder notification
                   				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                   					echo '<p class="backorder_notification">' . __('Available on backorder', 'sp') . '</p>';
							?>
						</td>
						
						<!-- Product price -->
						<td class="product-price">
							<?php 							
								$product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
							
								echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key ); 
							?>
						</td>
						
						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $values['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
						</td>
						
						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php 
								echo apply_filters( 'woocommerce_cart_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ), $values, $cart_item_key ); 
							?>
						</td>
					</tr>
					<?php
				}
			}
		}
		
		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( get_option( 'woocommerce_enable_coupons' ) == 'yes' ) { ?>
					<div class="coupon">
					
						<label for="coupon_code"><?php _e('Coupon', 'sp'); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'sp'); ?>" />
						
						<?php do_action('woocommerce_cart_coupon'); ?>
						
					</div>
				<?php } ?>

				<input type="submit" class="update button" name="update_cart" value="<?php _e('Update Cart', 'sp'); ?>" /> 
				<?php wc_print_notices('cart') ?>
                <?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>
		
		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>
<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
<div class="cart-collaterals group">
	
	<?php do_action('woocommerce_cart_collaterals'); ?>
	
	<?php //woocommerce_cart_totals(); ?>
	
	<?php //woocommerce_shipping_calculator(); ?>
    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="checkout-button alt"><span><?php _e('Proceed to Checkout &rarr;', 'sp'); ?></span></a>
    <?php //do_action('woocommerce_proceed_to_checkout'); ?>
	
</div>
