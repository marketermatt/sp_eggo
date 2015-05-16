        <!-- FOOTER WIDGETS-->
       <?php if ( sp_isset_option( 'footer_widget', 'isset' ) && sp_isset_option( 'footer_widget', 'value' ) != '0') { ?>
        <section id="footer-widget" class="group">
					  <?php
					  // sets an array with the number of columns to output
					  $columns = array('4' 	=> array('footer-col col4','footer-col col4','footer-col col4','footer-col col4'),
										 '3'	=> array('footer-col col3','footer-col col3','footer-col col3'),
										 '2' 	=> array('footer-col col2','footer-col col2'),
										 '1' 	=> array('') );
					  $i = 0;
					  
						if (is_array($columns[sp_isset_option( 'footer_widget', 'value' )])) {
						foreach($columns[sp_isset_option( 'footer_widget', 'value' )] as $col): 
						
								 $i++;
								 if($i == 1){ 
									  $class = "first"; 
								 } else {
									  $class = "";	
								 }
							?>
							<div class="<?php echo $col;?> <?php echo $class; ?>">
								 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-'.$i) ) ?>
							</div>
					  <?php endforeach; 
						}
					  ?>
        </section><!--close footer-widget-->
        <?php } ?>
        <!--END FOOTER WIDGETS-->
        <footer class="group" id="footer">
        <?php 
if (class_exists('WP_eCommerce')) {
	if (sp_isset_option('footer_carousel_enable', 'boolean', 'true')) { ?>    
        <?php $image_count = 0; ?>
        <section class="footer_featured group">
        	<?php if (sp_isset_option('footer_featured_title', 'isset')) { ?>
        	<h2 class="footer_featured_title"><?php echo sp_isset_option( 'footer_featured_title', 'value' ); ?></h2>
            <?php } ?>
        	<div class="footer_slider">
                <span class="carousel-arrow-left">&lt;</span>
                <?php 
                if (sp_isset_option( 'footer_carousel_display_type', 'isset' ) && sp_isset_option( 'footer_carousel_display_type', 'value' ) == "products" ) {
                    $footer_rand = sp_isset_option( 'footer_featured_random', 'value' );
                    $footer_slider_category = sp_isset_option( 'footer_carousel_category', 'value' );
					$footer_item_count = sp_isset_option( 'footer_carousel_product_count', 'value' );
                    $featured_products = sp_wpec_get_products($footer_slider_category, $footer_item_count, $footer_rand); // limit to 30 products
                                            
					if ( $featured_products->have_posts() ) 
					{
						$image_width = '135';
						$image_height = '85';
						
						echo '<ul class="group">';

						while ( $featured_products->have_posts() ) : $featured_products->the_post();
						
						echo '<li><div class="products">';

						if (sp_get_image(get_the_ID())) {
							echo '<img src="' . sp_timthumb_format("footer_carousel", sp_get_image(get_the_ID()), $image_width, $image_height) . '" alt="'.get_the_title().'" /><a href="' . wpsc_product_url( get_the_ID(), null ) . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>'; 
							echo '<h3 class="prodtitle">'.get_the_title().'</h3>';
						} else {
							echo '<img title="'.esc_attr(get_the_title()).'" src="'. sp_timthumb_format("footer_carousel", get_template_directory_uri(). "/images/no-product-image.jpg", $image_width, $image_height).'" alt="' . get_the_title() . '" width="'.$image_width.'" height="'.$image_height.'" /><a href="' . wpsc_product_url( get_the_ID(), null ) . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';	
							echo '<h3 class="prodtitle">'.get_the_title().'</h3>';
										
						} // end have image
						echo '</li>';
						$image_count++;
						endwhile;  
						echo '</ul>';
						wp_reset_postdata();
				} // end have posts
                } elseif (sp_isset_option( 'footer_carousel_display_type', 'boolean', 'categories') ) {	
                        if (sp_isset_option( 'footer_carousel_categories', 'isset' ) && (is_array(sp_isset_option( 'footer_carousel_categories', 'value' )) ? !in_array( '0', sp_isset_option( 'footer_carousel_categories', 'value' ) ) : '' ) ) {								
                        
                            $footer_carousel_rand = sp_isset_option( 'footer_featured_random', 'value' );
                            $cats = sp_isset_option( 'footer_carousel_categories', 'value' );
							$footer_item_count = sp_isset_option( 'footer_carousel_product_count', 'value' );
                            if ($footer_carousel_rand == "true") {
                                shuffle($cats);	
                            }
                            $output = '';
                            $image_count = 0;
                            if (count($cats) > 0 ) {
                                $output .= '<ul class="group">';
                                foreach ($cats as $cat) {
									if ( $image_count > $footer_item_count )
										break;																			
                                    $cat_obj = get_term($cat, 'wpsc_product_category');
                                    $cat_link = wpsc_category_url((int)$cat);
                                    $dots = '';
                                    $output .= '<li>';
                                    if (strlen(stripslashes( $cat_obj->name )) >= 40) { $dots = '...'; }
                                    $output .= '<div class="products">';
                                    $image_width = '135';
                                    $image_height = '85';
                                    
                                    if (wpsc_category_image($cat) != false) {
                                        $output .= '<img src="' .sp_timthumb_format('footer_carousel', sp_check_ms_image(wpsc_category_image($cat)), $image_width, $image_height).'" title="' . $cat_obj->name . '" alt="' . $cat_obj->name . '" width="'.$image_width.'" height="'.$image_height.'" />';
                                        $output .= '<a href="' . $cat_link . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';
                                    } else {
                                        $output .='<img alt="'. $cat_obj->name . '" title="'.$cat_obj->name.'" src="'.sp_timthumb_format('footer_carousel', get_template_directory_uri(). '/images/no-product-image.jpg', $image_width, $image_height).'" width="'.$image_width.'" height="'.$image_height.'" />';
                                        $output .= '<a href="' . $cat_link . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';	
                                    } // end have images
                                    $output .= '<h3 class="prodtitle">'.substr(stripslashes( $cat_obj->name ),0,26).$dots.'</h3>';
                                    $output .= '</li>';
                                    $image_count++;
                                } // end foreach
                                $output .= '</ul>';
                            } // end have categories
                            echo $output;
                        } // end categories set
                } ?>
                <span class="carousel-arrow-right">&gt;</span>
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_scroll_items', 'value' ); ?>" class="footer_carousel_scroll_items" />
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_interval', 'value' ); ?>" class="footer_carousel_interval" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_speed', 'value' ); ?>" class="footer_carousel_speed" />  
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_circular', 'value' ); ?>" class="footer_carousel_circular" />  
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_easing', 'value' ); ?>" class="footer_carousel_easing" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_reverse', 'value' ); ?>" class="footer_carousel_reverse" />    
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_reverse', 'value' ); ?>" class="footer_carousel_reverse" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_pauseonhover', 'value' ); ?>" class="footer_carousel_pauseonhover" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_effects', 'value' ); ?>" class="footer_carousel_effects" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_autoscrolldirection', 'value' ); ?>" class="footer_carousel_autoscrolldirection" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_infinite', 'value' ); ?>" class="footer_carousel_infinite" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_touchswipe', 'value' ); ?>" class="footer_carousel_touchwipe" /> 
                <input type="hidden" value="<?php echo ($image_count > 5) ? '5' : $image_count; ?>" class="footer_carousel_visible" />  
                
            </div><!--close footer_slider-->
        </section><!--close footer_featured-->
    <?php 
	} // end if carousel enabled
		
} // end WPEC check ?>

		<?php
if (class_exists( 'woocommerce' )) {
	if (sp_isset_option('footer_carousel_enable', 'boolean', 'true')) { ?> 
    	<?php $image_count = 0; ?>   
		<section class="footer_featured group">
			<?php if (sp_isset_option('footer_featured_title', 'isset')) { ?>
			<h2 class="footer_featured_title"><?php echo sp_isset_option( 'footer_featured_title', 'value' ); ?></h2>
			<?php } ?>
			<div class="footer_slider">
				<span class="carousel-arrow-left">&lt;</span>
				<?php 
                if (sp_isset_option( 'footer_carousel_display_type', 'isset' ) && sp_isset_option( 'footer_carousel_display_type', 'value' ) == "products" ) {
                    $footer_rand = sp_isset_option( 'footer_featured_random', 'value' );
                    $footer_slider_category = sp_isset_option( 'footer_carousel_category', 'value' );
					$footer_item_count = sp_isset_option( 'footer_carousel_product_count', 'value' );
                    $featured_products = sp_woo_get_products($footer_slider_category, $footer_item_count, $footer_rand); // limit to 30 products  
                                        					
					if ( $featured_products->have_posts() ) 
					{
						$image_width = '135';
						$image_height = '85';
						$dots = '';
						
						echo '<ul class="group">';
						$image_count = 0;
						while ( $featured_products->have_posts() ) : $featured_products->the_post();
						
						if (strlen(stripslashes( get_the_title() )) >= 26) { $dots = '...'; } 
							
						echo '<li><div class="products">';

						if (sp_get_image(get_the_ID())) {
							echo '<img src="' . sp_timthumb_format("footer_carousel", sp_get_image(get_the_ID()), $image_width, $image_height) . '" /><a href="' . get_permalink() . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>'; 
						} else {
							echo '<img title="'.esc_attr(get_the_title()).'" src="'. sp_timthumb_format("footer_carousel", get_template_directory_uri(). "/images/no-product-image.jpg", $image_width, $image_height).'" alt="' . get_the_title() . '" width="'.$image_width.'" height="'.$image_height.'" /><a href="' . get_permalink(). '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';											
						} // end have image
						echo '<h3 class="prodtitle">'.substr(stripslashes( get_the_title() ),0,26).$dots.'</h3>';						
						echo '</li>';
						$image_count++;
						
						endwhile;
						wp_reset_postdata();
						echo "</ul>";
					} // end have posts check
					
                } elseif (sp_isset_option( 'footer_carousel_display_type', 'boolean', 'categories') ) {	
                        if (sp_isset_option( 'footer_carousel_categories', 'isset' ) && (is_array(sp_isset_option( 'footer_carousel_categories', 'value' )) ? !in_array( '0', sp_isset_option( 'footer_carousel_categories', 'value' ) ) : '' ) ) {								
                        	$output = '';
                            $footer_carousel_rand = sp_isset_option( 'footer_featured_random', 'value' );
                            $cats = sp_isset_option( 'footer_carousel_categories', 'value' );
							$footer_item_count = sp_isset_option( 'footer_carousel_product_count', 'value' );
                            if ($footer_carousel_rand == "true") {
                                shuffle($cats);	
                            }
                            if (count($cats) > 0 ) {
                                $output .= '<ul class="group">';
                                foreach ($cats as $cat) {
									if ( $image_count > $footer_item_count )
										break;																												
									$cat_obj = get_term($cat, 'product_cat');
									if ( ! is_object( $cat_obj ) )
										continue;
									$cat_link = get_term_link( (int)$cat, 'product_cat');
                                    $dots = '';
                                    $output .= '<li>';
                                    if (strlen(stripslashes( $cat_obj->name )) >= 40) { $dots = '...'; }
                                    $output .= '<div class="products">';
                                    $image_width = '135';
                                    $image_height = '85';
                                    
									$term_id = get_woocommerce_term_meta((int)$cat,'thumbnail_id');
									$cat_image = wp_get_attachment_image_src( $term_id, 'full' );
									$cat_image = sp_check_ms_image($cat_image[0]);
									if ($cat_image) {
                                        $output .= '<img src="' .sp_timthumb_format('footer_carousel', $cat_image, $image_width, $image_height).'" title="' . $cat_obj->name . '" alt="' . $cat_obj->name . '" width="'.$image_width.'" height="'.$image_height.'" />';
                                        $output .= '<a href="' . $cat_link . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';
                                    } else {
                                        $output .='<img alt="'. $cat_obj->name . '" title="'.$cat_obj->name.'" src="'.sp_timthumb_format('footer_carousel', get_template_directory_uri(). '/images/no-product-image.jpg', $image_width, $image_height).'" width="'.$image_width.'" height="'.$image_height.'" />';
                                        $output .= '<a href="' . $cat_link . '" class="more" title="'.__("More Details",'sp').'"><span class="icon">&nbsp;</span>'.__("More Details",'sp').'</a></div>';	
                                    } // end have images
                                    $output .= '<h3 class="prodtitle">'.substr(stripslashes( $cat_obj->name ),0,26).$dots.'</h3>';
                                    $output .= '</li>';
                                    $image_count++;
                                } // end foreach
                                $output .= '</ul>';
                            } // end have categories
                            echo $output;
                        } // end categories set
                        ?>
                <?php
                } ?>
				<span class="carousel-arrow-right">&gt;</span>
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_scroll_items', 'value' ); ?>" class="footer_carousel_scroll_items" />
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_interval', 'value' ); ?>" class="footer_carousel_interval" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_speed', 'value' ); ?>" class="footer_carousel_speed" />  
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_circular', 'value' ); ?>" class="footer_carousel_circular" />  
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_easing', 'value' ); ?>" class="footer_carousel_easing" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_reverse', 'value' ); ?>" class="footer_carousel_reverse" />    
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_reverse', 'value' ); ?>" class="footer_carousel_reverse" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_pauseonhover', 'value' ); ?>" class="footer_carousel_pauseonhover" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_effects', 'value' ); ?>" class="footer_carousel_effects" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_autoscrolldirection', 'value' ); ?>" class="footer_carousel_autoscrolldirection" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_infinite', 'value' ); ?>" class="footer_carousel_infinite" /> 
                <input type="hidden" value="<?php echo sp_isset_option( 'footer_carousel_touchswipe', 'value' ); ?>" class="footer_carousel_touchwipe" /> 
                <input type="hidden" value="<?php echo ($image_count > 5) ? '5' : $image_count; ?>" class="footer_carousel_visible" />  
                
			</div><!--close footer_slider-->
		</section><!--close footer_featured-->
	<?php 
	} // end if carousel enabled 

} // end WOO plugin check ?>
        
        <!--FOOTER TESTIMONIALS-->
        <?php if (sp_isset_option( 'footer_testimonials_count', 'isset' ) && sp_isset_option( 'footer_testimonials_count', 'value' ) > '0' && sp_isset_option( 'footer_testimonials_enable', 'boolean', 'true' )) { ?>
        <div id="footer-testimonial">
        	<span class="divider">&nbsp;</span>
            <section id="testimonials" class="group">
            	<span class="left-quote">&nbsp;</span>
                <span class="right-quote">&nbsp;</span>
            	<?php if (sp_isset_option( 'footer_testimonials_title', 'isset' ) ) { ?>
                <h4><?php echo stripslashes(sp_isset_option( 'footer_testimonials_title', 'value' ) ); ?></h4>
                <?php } ?>
                <?php
					if (sp_isset_option( 'footer_testimonials_count', 'value' ) > "1") {
						$count = sp_isset_option( 'footer_testimonials_count', 'value' );
					} else {
						$count = 1;	
					}
					$delay = sp_isset_option( 'footer_testimonials_interval', 'value' );
				?>
                <?php 
					$text = str_replace("|", "####", sp_isset_option( 'footer_testimonials_text', 'value' )); 
					$text = explode("####",$text); 
					$i = 1;
					shuffle($text);
					foreach ($text as $blurb) { ?>
                    	<?php if ($i > $count) { break; } ?>
						<p><?php 
							echo sp_truncate(stripslashes($blurb), sp_isset_option( 'footer_testimonials_characters', 'value' ), sp_isset_option( 'footer_testimonials_denote', 'value' ), true, true);
						 ?></p>
                        <?php $i++;	?>
				<?php } ?>
				<input type="hidden" value="<?php echo $delay; ?>" class="footer_rotator_delay" />                
            </section><!--close testimonials-->
        	<span class="divider">&nbsp;</span>
            
        </div><!--close footer-testimonials-->
		<?php } ?>
        <!--END FOOTER TESTIMONIALS-->
             <?php wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'footer-nav group', 'fallback_cb' => 'footer_menu','theme_location' => 'footer_nav', 'depth' => 1)); ?>     
                <small id="footer-copyright">
                    <?php if (sp_isset_option( 'footer_copyright', 'isset' ) ) : ?>
                        <?php echo stripslashes( sp_isset_option( 'footer_copyright', 'value' ) ); ?>
                    <?php endif; ?>
                </small>
            <!--LOGO-->
            <?php if (sp_isset_option( 'footer_logo', 'boolean', 'true' ) ) { ?>
            <a href="<?php echo home_url(); ?>" title="<?php sp_isset_option( 'logo_alt_text', 'value' ); ?>" id="footer-logo">
            <?php if (sp_isset_option( 'footer_logo_image_text', 'boolean', 'image' ) ) :
            			if (sp_isset_option( 'footer_logo_image', 'isset' ) ) {
							$logo_url = sp_isset_option( 'footer_logo_image', 'value' );
							if (is_ssl()) 
								$logo_url = str_replace('http', 'https', $logo_url);
							echo '<img src="'.$logo_url.'" alt="'.sp_isset_option( 'footer_logo_alt_text', 'value' ).'" />';
						} else {
							if (sp_isset_option( 'skins', 'boolean', '1' ) ) {
								echo '<img src="'.get_template_directory_uri().'/images/logo.png" alt="'.sp_isset_option( 'footer_logo_alt_text', 'value' ).'" />';
							} else {
								echo '<img src="'.get_template_directory_uri().'/skins/images/skin'.sp_isset_option( 'skins', 'value' ).'/logo.png" alt="'.sp_isset_option( 'footer_logo_alt_text', 'value' ).'" />';
							}
						}
            	 elseif (sp_isset_option( 'footer_logo_image_text', 'boolean', 'text' ) ) : 
                		if (sp_isset_option( 'footer_logo_text_title', 'isset' ) ) {
							echo sp_isset_option( 'footer_logo_text_title', 'value' );
						} else {
							_e('Your Logo Here','sp');	
						}
				endif; ?>
            </a>
            <?php } ?>
            <!--END LOGO-->
            </footer>
</div><!--close wrapper-->
			<!--start lightbox hidden values-->
            <input type="hidden" value="<?php echo sp_isset_option( 'lightbox_social', 'value' ); ?>" id="lightbox_social" />
            <input type="hidden" value="<?php echo sp_isset_option( 'lightbox_theme', 'value' ); ?>" id="lightbox_theme" />
            <input type="hidden" value="<?php echo sp_isset_option( 'lightbox_slideshow', 'value' ); ?>" id="lightbox_slideshow" />
            <input type="hidden" value="<?php echo sp_isset_option( 'lightbox_show_overlay_gallery', 'value' ); ?>" id="lightbox_show_overlay_gallery" />
            <input type="hidden" value="<?php echo sp_isset_option( 'lightbox_title', 'value' ); ?>" id="lightbox_title" />
            <input type="hidden" value="<?php echo sp_isset_option( 'variation_image_swap', 'value' ); ?>" id="variation_image_swap" />
            <input type="hidden" value="true" id="quickview_enable" />
            <input type="hidden" value="<?php echo sp_isset_option( 'tabs_start_collapsed', 'value' ); ?>" id="tabs_start_collapsed" />
            
            <!--end lightbox hidden values-->
	</div><!--close site-bg-->
    </div><!--close container-->
</div><!--close wrap_all-->
<?php dynamic_sidebar( 'site-bottom-widget' ); ?>         
<?php wp_footer(); ?>
</body>
</html>