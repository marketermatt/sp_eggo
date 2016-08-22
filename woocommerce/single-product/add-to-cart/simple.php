<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php 
	// Availability
	$availability = $product->get_availability();
	
	if ($availability['availability']) :
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );
    endif;
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>
	
	<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>

	 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	 	<?php 
	 		if ( ! $product->is_sold_individually() ) 
	 			woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) ); 
	 	?>

        <div class="woo_buy_button_container group">
            <div class="input-button-buy"><span><button type="submit" class="single_add_to_cart_button button alt" data-product_id="<?php echo $product->id; ?>"><?php echo apply_filters('single_add_to_cart_text', __('add to cart', 'sp'), $product->product_type); ?></button></span>
            </div><!--close input-button-buy-->
            <div class="loading_animation">
                <img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" />
                
            </div><!--close woo_loading_animation-->                                        
        
		</div><!--close woo_buy_button_container-->

	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>
	
	<?php do_action('woocommerce_after_add_to_cart_form'); ?>
	
<?php endif; ?>