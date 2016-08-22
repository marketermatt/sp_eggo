<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 ?>

<?php global $woocommerce; $woocommerce_checkout = $woocommerce->checkout(); ?>

<div id="status-bg">
	<span class="cart active"><span><?php _e('Your Cart','sp'); ?></span></span>
    <span class="info active"><span><?php _e('Info','sp'); ?></span></span>
    <span class="final"><span><?php _e('Final','sp'); ?></span></span>
</div><!--close status-bg-->

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_checkout_form');

// If checkout registration is disabled and not logged in, the user cannot checkout
if (get_option('woocommerce_enable_signup_and_login_from_checkout')=="no" && get_option('woocommerce_enable_guest_checkout')=="no" && !is_user_logged_in()) :
	echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'sp'));
	return;
endif;

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', $woocommerce->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">
	
	<?php if (sizeof($woocommerce_checkout->checkout_fields)>0) : ?>
	
	<div class="col2-set group" id="customer_details">
		<div class="col-1">

			<?php do_action('woocommerce_checkout_billing'); ?>
						
		</div>
		<div class="col-2">
		
			<?php do_action('woocommerce_checkout_shipping'); ?>
					
		</div>
	</div>
	
	<h3 id="order_review_heading"><?php _e('Your order', 'sp'); ?></h3>
	
	<?php endif; ?>

	<?php do_action('woocommerce_checkout_order_review'); ?>
	
</form>

<?php do_action('woocommerce_after_checkout_form'); ?>