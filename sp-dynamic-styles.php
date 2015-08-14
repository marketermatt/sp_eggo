<?php
/**
* SP FRAMEWORK FILE - DO NOT EDIT!
* 
* dynamic code
******************************************************************/
if ( class_exists( 'WP_eCommerce' ) ) 
{
$image_width = get_option('product_image_width');
$single_image_width  = get_option( 'single_view_image_width' );
$post_image_width = get_option('thumbnail_size_w');

/*$output .= '.product_grid_display .product_grid_item {width:'.($image_width + 8).'px;}';
$output .= '.default_product_display .imagecol {width:'.($image_width + 8).'px;}';
$output .= '.default_product_display .productcol {width:'.(620 - ($image_width + 20)).'px;}';
$output .= '.default_product_display .productcol .leftcol {width:'.(510 - ($image_width + 20) - 200).'px;}';
$output .= '#container.no-sidebars .default_product_display .productcol {width:'.(880 - ($image_width + 20)).'px;}';
$output .= '#container.no-sidebars .default_product_display .productcol .leftcol {width:'.(770 - ($image_width + 20) - 200).'px;}';
$output .= '#single_product_page_container .productcol {width:'.(830 - $single_image_width).'px;}'; */
$output .= 'article.list {width:'.($post_image_width + 10).'px;}'; 
$output .= '.single_product_display .imagecol {width:' . ( $single_image_width + 8 ) . 'px;}';
}

if ( class_exists( 'woocommerce' ) )
{
	$image_width  = get_option( 'shop_catalog_image_size' );
	$post_image_width = get_option('thumbnail_size_w');
	
	$output .= 'article.list {width:'.($post_image_width + 10).'px;}'; 

}

?>