<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
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
?>
<?php do_action('woocommerce_before_add_to_cart_button'); ?>
        <div class="woo_buy_button_container group">
			<a href="<?php echo $product_url; ?>" rel="nofollow" class="external-button alt add_to_cart_button"><span><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></span></a>
            <div class="loading_animation">
                <img title="Loading" alt="Loading" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" />
            </div><!--close loading_animation-->                                        
       
		</div><!--close wpsc_buy_button_container-->

<?php do_action('woocommerce_after_add_to_cart_button'); ?>