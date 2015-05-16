<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.6
 */
 
global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) 
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) 
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibilty
if ( ! $product->is_visible() ) 
	return; 

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product product_grid_item <?php 
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ) 
		echo 'last'; 
	elseif ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 ) 
		echo 'first'; 
	?>">
    
	<div class="item_image">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <div class="inner">	
        	<?php if (! sp_isset_option( 'quickview', 'isset' )) { ?>
            <a title="<?php the_title(); ?>" href="<?php echo the_permalink(); ?>">
            <?php }
				do_action( 'woocommerce_before_shop_loop_item_title', 'product_grid' ); 
			if (! sp_isset_option( 'quickview', 'isset' )) { ?>
            </a>
            <?php } ?>
			<?php if (sp_isset_option( 'quickview', 'boolean', 'true' ) ) { ?>
            <span class="quickview-button"><span class="icon">&nbsp;</span><?php _e('QUICKVIEW','sp'); ?></span>
            <?php } ?>
                <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="more-button"><span class="icon">&nbsp;</span><?php _e('More Details','sp'); ?></a>                   
            <?php if($product->is_on_sale()) { $onsale = 'sale'; } else { $onsale = ''; } ?>
            <div class="price_display <?php echo $onsale; ?>"> 
                <?php if($product->is_on_sale()) : ?>
                    <span class="flex"><?php echo $product->get_price_html(); ?></span>
                <?php else : ?>
                    <span class="flex"><?php echo $product->get_price_html(); ?></span>
                <?php endif; ?>
            </div><!--close price_display-->	
             
        </div><!--close inner-->
        <input type="hidden" value="<?php echo $post->ID; ?>" class="hidden-id product-id" />
        <span class="divider">&nbsp;</span> 
	</div><!--close item_image-->
	<h2 class="prodtitle"><a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
    <?php //do_action('woocommerce_after_shop_loop_item_title'); ?> 
    
</li>