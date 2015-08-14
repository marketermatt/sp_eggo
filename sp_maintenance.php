<?php 
/* Template Name: Maintenance */

// redirect back to homepage if maintenance is not enabled
if ( sp_isset_option( 'maintenance_enable', 'isset' ) == false || ! sp_isset_option( 'maintenance_enable', 'isset' ) )
{
	wp_redirect( home_url() );
	exit;	
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js <?php echo sp_get_browser_agent();?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'sp' ), max( $paged, $page ) );

?>
</title>
<?php if ( sp_isset_option( 'mobile_zoom', 'boolean', 'true' ) ) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php } else { ?>
<meta name="viewport" content="width=device-width, intital-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.2'></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js?ver=2.6.1'></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/maintenance.js?ver=2.0.3'></script>
</head>
<body>
	<div id="maintenance">
		<?php while ( have_posts() ) : the_post(); ?>
            <article class="group">
            <!--LOGO--> 
            <?php if ( sp_isset_option( 'maintenance_logo', 'boolean', 'true' ) ) { ?>
				<?php $alt_text = sprintf( __( '%s', 'sp' ), sp_isset_option( 'logo_alt_text', 'value' ) ); ?>
                <a href="<?php echo home_url(); ?>" title="<?php echo $alt_text; ?>" id="logo">
                <?php if (sp_isset_option( 'site_logo_image_text', 'boolean', 'image' ) ) :
                            if (sp_isset_option( 'logo_image', 'isset' ) ) {
                                $logo_url = sp_isset_option( 'logo_image', 'value' );
                                if (is_ssl())
                                    $logo_url = str_replace('http', 'https', $logo_url); 
                                echo '<img src="'.$logo_url.'" alt="'.sp_isset_option( 'logo_alt_text', 'value' ).'" />';
                            } else {
                                if (sp_isset_option( 'skins', 'boolean', '1')) {
                                    echo '<img src="'.get_template_directory_uri().'/images/logo.png" alt="'.sp_isset_option( 'logo_alt_text', 'value' ).'" />';
                                } else {
                                    echo '<img src="'.get_template_directory_uri().'/skins/images/skin'.sp_isset_option( 'skins', 'value' ).'/logo.png" alt="'.sp_isset_option( 'logo_alt_text', 'value' ).'" />';
                                }
                            }
                     elseif (sp_isset_option( 'site_logo_image_text', 'boolean', 'text' )) : 
                            if (sp_isset_option( 'site_logo_text_title', 'isset')) {
                                echo stripslashes(sp_isset_option( 'site_logo_text_title', 'value' ));
                            } else {
                                _e('Your Logo Here','sp');	
                            }
                    endif; ?>
                </a>
            <?php } ?>
            <!--END LOGO-->
                <header class="page-header">
                    <h2 class="entry-title"><?php _e('Maintenance In Progress', 'sp'); ?></h2>
                </header>
                <div class="entry-content">
                	<?php if (sp_isset_option( 'maintenance_countdown', 'boolean', 'true' )) { ?>
                    <div id="countdown"></div>
                    <?php } ?>
            
                    <div class="text"><?php the_content(); ?></div><!--close text-->
                    <input type="hidden" class="maintenance_datetime" value="<?php echo (strlen( (string)sp_isset_option( 'maintenance_datetime', 'isset' ))) ? sp_isset_option( 'maintenance_datetime', 'value' ) : '0'; ?>" />
                    <input type="hidden" class="maintenance_timezone" value="<?php echo (strlen( (string)sp_isset_option( 'maintenance_timezone', 'isset' ))) ? sp_isset_option( 'maintenance_timezone', 'value' ) : '0'; ?>" />
                    <?php if ( sp_isset_option( 'maintenance_twitter_enable', 'boolean', 'true' ) ) { 
                    			if ( sp_isset_option( 'maintenance_twitter_account', 'isset' ) && strlen(sp_isset_option( 'maintenance_twitter_account', 'value' )) ) { ?>
                        			<a href="<?php echo sp_isset_option( 'maintenance_twitter_account', 'value' ); ?>" title="<?php _e('Follow Us on Twitter', 'sp' ); ?>" class="maintenance-twitter"><?php _e('Follow Us on Twitter', 'sp' ); ?></a>
							<?php } ?>
                    <?php } ?>
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
        <?php endwhile; // end of the loop. ?>
    </div><!--close maintenance-->	

</body>
</html>
