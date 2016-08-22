<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<?php if($product->is_on_sale()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
	<p itemprop="price" class="price <?php echo $onsale; ?>"><span class="align"><?php echo $product->get_price_html(); ?></span></p>
	
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
	
</div>
<?php 
if ( sp_isset_option( 'product_rating_stars', 'boolean', 'true' ) )
	echo sp_get_star_rating(); 
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

<?php if (sp_isset_option( 'facebook_like_button', 'boolean', 'true' )) : ?>
<li>                                                
    <div class="fb-like" data-href="<?php echo the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
</li>                            
<?php endif; ?>
</ul>

</div><!--close top-meta-->