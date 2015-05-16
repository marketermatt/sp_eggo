<?php
// displays also bought items
function sp_wpsc_also_bought( $product_id ) {
	/*
	 * Displays products that were bought aling with the product defined by $product_id
	 * most of it scarcely needs describing
	 */
	global $wpdb;

	if ( get_option( 'wpsc_also_bought' ) == 0 ) {
		//returns nothing if this is off
		return '';
	}
	

	// to be made customiseable in a future release
	$also_bought_limit = 4;
	$element_widths = 96;
	$image_height = sp_get_theme_init_setting('wpec_also_bought_image_size','height');
	$image_width = sp_get_theme_init_setting('wpec_also_bought_image_size','width');
	
	$output = '';
	$also_bought = $wpdb->get_results( $wpdb->prepare( "SELECT `" . $wpdb->posts . "`.* FROM `" . WPSC_TABLE_ALSO_BOUGHT . "`, `" . $wpdb->posts . "` WHERE `selected_product`='" . $product_id . "' AND `" . WPSC_TABLE_ALSO_BOUGHT . "`.`associated_product` = `" . $wpdb->posts . "`.`id` AND `" . $wpdb->posts . "`.`post_status` IN('publish','protected') AND `" . $wpdb->posts . "`.`post_type` IN ('wpsc-product') ORDER BY `" . WPSC_TABLE_ALSO_BOUGHT . "`.`quantity` DESC LIMIT $also_bought_limit", $product_id ), ARRAY_A );
	if ( count( $also_bought ) > 0 ) {
		$output .= '<div class="wpsc_also_bought group">';
		$output .= '<span class="divider">&nbsp;</span>';
		if (sp_isset_option( 'cross_sales_title', 'isset' )) {
			$cross_sales_title = sp_isset_option( 'cross_sales_title', 'value' );
		}
		$output .= '<h2>' . sprintf( __( '%s', 'sp' ), $cross_sales_title ) . "</h2>";			
		$output .= "<ul>";
		foreach ( (array)$also_bought as $also_bought_data ) {
			$output .= '<li class="wpsc_also_bought_item">';
			if ( get_option( 'show_thumbnails' ) == 1 ) {
				if ( sp_check_ms_image(wpsc_the_product_thumbnail(96,96,$also_bought_data['ID']))) {
					$output .= '<div class="also_bought_item_image"><div class="inner">';
					$image_src = sp_get_image($also_bought_data['ID']);
					$output .= '<img src="'.sp_timthumb_format('also_bought', $image_src, $image_width, $image_height ).'" class="product_image" alt="'.get_the_title($also_bought_data['ID']).'">';
					$output .= '<a href="'.get_permalink($also_bought_data['ID']).'" title="'.get_the_title($also_bought_data['ID']).'" class="more-button"><span class="icon">&nbsp;</span>'.__('More Details','sp').'</a>';
					$price = get_product_meta($also_bought_data['ID'], 'price', true);
					$special_price = get_product_meta($also_bought_data['ID'], 'special_price', true);					
					if (!empty($special_price)) { $onsale = 'sale'; } else { $onsale = ''; }
					$output .= '<div class="also_bought_price_display '.$onsale.'">';
					if (!empty($special_price)) {
					$output .= '<span class="flex">'.wpsc_currency_display( $price ).'<br /><span class="pricedisplay new">'.wpsc_currency_display( $special_price ).'</span></span></div>';
					} else {
					$output .= '<span class="flex">'.wpsc_currency_display( $price ).'</span></div>';
                    }
                    $output .= '</div><span class="also_bought_divider">&nbsp;</span></div>';
				} else {
					$output .= '<div class="also_bought_item_image"><div class="inner">';
					$output .= '<img src="'.sp_timthumb_format( 'also_bought', get_template_directory_uri().'/images/no-product-image.jpg', $image_width, $image_height ).'" class="product_image" alt="'.get_the_title($also_bought_data['ID']).'">';
					$output .= '<a href="'.get_permalink($also_bought_data['ID']).'" title="'.get_the_title($also_bought_data['ID']).'" class="more-button"><span class="icon">&nbsp;</span>'.__('More Details','sp').'</a>';
					$price = get_product_meta($also_bought_data['ID'], 'price', true);
					$special_price = get_product_meta($also_bought_data['ID'], 'special_price', true);					
					if (!empty($special_price)) { $onsale = 'sale'; } else { $onsale = ''; }
					$output .= '<div class="also_bought_price_display '.$onsale.'">';
					if (!empty($special_price)) {
					$output .= '<span class="flex">'.wpsc_currency_display( $price ).'<br /><span class="pricedisplay new">'.wpsc_currency_display( $special_price ).'</span></span></div>';
					} else {
					$output .= '<span class="flex">'.wpsc_currency_display( $price ).'</span></div>';
                    }
                    $output .= '</div><span class="also_bought_divider">&nbsp;</span></div>';
				}
			}

			$output .= '<h2 class="prodtitle"><a class="wpsc_product_name" href="' . get_permalink($also_bought_data['ID']) . '">' . get_the_title($also_bought_data['ID']) . '</a></h2>';
			$output .= "</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}
?>