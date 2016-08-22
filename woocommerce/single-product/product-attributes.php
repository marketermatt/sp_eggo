<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
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
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;

$alt = 1;
$attributes = $product->get_attributes();

if ( empty( $attributes ) && ( ! $product->enable_dimensions_display() || ( ! $product->has_dimensions() && ! $product->has_weight() ) ) ) return;
?>
<table class="shop_attributes">
			
	<?php if ( $product->enable_dimensions_display() ) : ?>	
		
		<?php if ( $product->has_weight() ) : $alt = $alt * -1; ?>
		
			<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
				<th><?php _e('Weight', 'sp') ?></th>
				<td><?php echo $product->get_weight() . ' ' . get_option('woocommerce_weight_unit'); ?></td>
			</tr>
		
		<?php endif; ?>
		
		<?php if ($product->has_dimensions()) : $alt = $alt * -1; ?>
		
			<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
				<th><?php _e('Dimensions', 'sp') ?></th>
				<td><?php echo $product->get_dimensions(); ?></td>
			</tr>		
		
		<?php endif; ?>
		
	<?php endif; ?>
			
	<?php foreach ($attributes as $attribute) : 
		
		if ( ! isset( $attribute['is_visible'] ) || ! $attribute['is_visible'] ) continue;
		if ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) continue;
		
		$alt = $alt * -1; 
		?>
			
		<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
			<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
			<td><?php
				if ( $attribute['is_taxonomy'] ) {
					
					$values = woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
					
				} else {
				
					// Convert pipes to commas and display values
					$values = explode( '|', $attribute['value'] );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
					
				}
			?></td>
		</tr>
				
	<?php endforeach; ?>
	
</table>