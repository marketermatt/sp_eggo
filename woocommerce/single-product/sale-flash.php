<?php
/**
 * Single Product Sale Flash
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

global $post, $product;
?>
<?php if ($product->is_on_sale()) : ?>
	
	<?php echo apply_filters('woocommerce_sale_flash', '<span class="sale">'.__('Sale!', 'sp').'</span>', $post, $product); ?>
	
<?php endif; ?>