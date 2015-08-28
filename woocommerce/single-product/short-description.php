<?php
/**
 * Single Product Short Description
 *
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

global $post;

if ( ! $post->post_excerpt ) return;
?>
<div itemprop="description" class="short-description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
</div>