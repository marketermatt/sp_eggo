<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product;


// if less than 2.0
if ( version_compare( WOOCOMMERCE_VERSION, '2.0', '<' ) ) {	
	$image_width = get_option( 'woocommerce_single_image_width' );
	$image_height = get_option( 'woocommerce_single_image_height' );
} else {			
	$image_sizes = wc_get_image_size( 'shop_single' );
	$image_width = $image_sizes['width'];
	$image_height = $image_sizes['height'];
}
?>
<div class="imagecol images">
<div class="image-wrapper">
    <div class="item_image">
	<?php if ( has_post_thumbnail() ) : ?>

		<a data-rel="prettyPhoto[<?php echo $post->ID; ?>]" href="<?php echo sp_get_image($post->ID); ?>" class="zoom thickbox preview_link" title="<?php the_title_attribute(); ?>" data-id="<?php echo $post->ID; ?>" onclick="return false;">
        <img width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" class="product_image attachment-shop_single wp-post-image" alt="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format('single_main', sp_get_image($post->ID), $image_width, $image_height); ?>" /><span class="hover-icon">&nbsp;</span>
        </a>

	<?php else : ?>
	
        <a data-rel="prettyPhoto[<?php echo $post->ID; ?>]" class="zoom thickbox preview_link" href="<?php echo get_template_directory_uri(); ?>/images/no-product-image.jpg" title="<?php the_title_attribute(); ?>" data-id="<?php echo $post->ID; ?>" onclick="return false;">
        <img class="no-image" alt="No Image" title="<?php the_title_attribute(); ?>" src="<?php echo sp_timthumb_format('single_main', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height; ?>" /><span class="hover-icon">&nbsp;</span>
        </a>
	
	<?php endif; ?>
	</div><!--close item_image-->
	<?php if($product->is_on_sale() && sp_isset_option('saletag', 'boolean', 'true')) : ?><span class="sale"><?php _e('Sale', 'sp'); ?></span><?php endif; ?>
            
</div><!--image-wrapper-->
  <?php	
	  global $main_image_height; 
	  $main_image_height = $image_height; 
      do_action('woocommerce_product_thumbnails');
  ?>
</div><!--close imagecol-->
