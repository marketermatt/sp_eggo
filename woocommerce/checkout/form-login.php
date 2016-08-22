<?php
/**
 * Checkout login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-login.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if (is_user_logged_in()) return;
if (get_option('woocommerce_enable_signup_and_login_from_checkout')=="no") return;

$info_message = apply_filters('woocommerce_checkout_login_message', __('Already registered?', 'sp'));
?>

<p class="woocommerce_info"><?php echo $info_message; ?> <a href="#" class="showlogin"><?php _e('Click here to login', 'sp'); ?></a></p>

<?php woocommerce_login_form( array( 'message' => __('If you have shopped with us before, please enter your username and password in the boxes below. If you are a new customer please proceed to the Billing &amp; Shipping section.', 'sp'), 'redirect' => get_permalink(woocommerce_get_page_id('checkout')) ) ); ?>