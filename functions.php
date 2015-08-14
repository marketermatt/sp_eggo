<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * if you want to add your own functions, create a file called custom_functions.php inside your theme root folder and put your functions in there
 *
 * include all the functions
 ******************************************************************/
 
// Make theme available for translation
add_action( 'after_setup_theme', 'sp_load_textdomain' );
function sp_load_textdomain() {
	load_theme_textdomain( 'sp', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
}

/**
 * checks to see if custom_functions is used and if so check if child theme is active
 ******************************************************************/
if ( is_child_theme() ) 
{
	if ( is_file( get_stylesheet_directory() . '/custom_functions.php' ) ) 
	{
		require_once( get_stylesheet_directory() . '/custom_functions.php' );
	}
} 
else 
{
	if ( is_file( get_template_directory() . '/custom_functions.php' ) ) 
	{
		require_once( get_template_directory() . '/custom_functions.php' );
	}	
}

require_once( get_template_directory() . '/sp-framework/sp-framework.php' );

function paulund_remove_default_image_sizes( $sizes) {
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['large']);
     
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'paulund_remove_default_image_sizes');

function wpmayor_filter_image_sizes( $sizes) {

unset( $sizes['medium']);
unset( $sizes['large']);
unset( $sizes['wysija-newsletters-max']);

return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'wpmayor_filter_image_sizes');

function wpmayor_custom_image_sizes($sizes) {
$myimgsizes = array(
"image-in-post" => __( "Image in Post" ),
"full" => __( "Original size" )
);
return $myimgsizes;
}
add_filter('image_size_names_choose', 'wpmayor_custom_image_sizes');

 add_image_size( 'portfolio_single', 890, 360, true );
  //add_image_size( 'prod-thumb', 300, 300, true );
 




 
  if ( !function_exists( 'vt_resize') ) {
	global $woocommerce;  
	  
 function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

  // this is an attachment, so we have the ID
  if ( $attach_id ) {

   $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
   $file_path = get_attached_file( $attach_id );

  // this is not an attachment, let's use the image url
  } else if ( $img_url ) {

   $file_path = parse_url( $img_url );
   $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

   // Look for Multisite Path
   if(file_exists($file_path) === false){
    global $blog_id;
    $file_path = parse_url( $img_url );
    if (preg_match("/files/", $file_path['path'])) {
     $path = explode('/',$file_path['path']);
     foreach($path as $k=>$v){
      if($v == 'files'){
       $path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
      }
     }
     $path = implode('/',$path);
    }
    $file_path = $_SERVER['DOCUMENT_ROOT'].$path;
   }
   //$file_path = ltrim( $file_path['path'], '/' );
   //$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];

   $orig_size = getimagesize( $file_path );

   $image_src[0] = $img_url;
   $image_src[1] = $orig_size[0];
   $image_src[2] = $orig_size[1];
  }

  $file_info = pathinfo( $file_path );

  // check if file exists
  $base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
  if ( !file_exists($base_file) )
   return;

  $extension = '.'. $file_info['extension'];

  // the image path without the extension
  $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

  $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

  // checking if the file size is larger than the target size
  // if it is smaller or the same size, stop right here and return
  if ( $image_src[1] > $width ) {

   // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
   if ( file_exists( $cropped_img_path ) ) {

    $cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

    $vt_image = array (
     'url' => $cropped_img_url,
     'width' => $width,
     'height' => $height
    );

    return $vt_image;
   }

   // $crop = false or no height set
   if ( $crop == false OR !$height ) {

    // calculate the size proportionaly
    $proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
    $resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;

    // checking if the file already exists
    if ( file_exists( $resized_img_path ) ) {

     $resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

     $vt_image = array (
      'url' => $resized_img_url,
      'width' => $proportional_size[0],
      'height' => $proportional_size[1]
     );

     return $vt_image;
    }
   }

   // check if image width is smaller than set width
   $img_size = getimagesize( $file_path );
   if ( $img_size[0] <= $width ) $width = $img_size[0];

   // Check if GD Library installed
   if (!function_exists ('imagecreatetruecolor')) {
       echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
       return;
   }

   // no cache files - let's finally resize it
   $new_img_path = image_resize( $file_path, $width, $height, $crop );   
   $new_img_size = getimagesize( $new_img_path );
   $new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

   // resized output
   $vt_image = array (
    'url' => $new_img,
    'width' => $new_img_size[0],
    'height' => $new_img_size[1]
   );

   return $vt_image;
  }

  // default output - without resizing
  $vt_image = array (
   'url' => $image_src[0],
   'width' => $width,
   'height' => $height
  );

  return $vt_image;
 }
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 3;' ), 20 );