<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @version 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $woocommerce;
?>

<?php if ( $woocommerce->cart->ship_to_billing_address_only() && $woocommerce->cart->needs_shipping() ) : ?>
	
	<h3><?php _e('Billing &amp; Shipping', 'sp'); ?></h3>
	
<?php else : ?>

	<h3><?php _e('Billing Address', 'sp'); ?></h3>

<?php endif; ?>

<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

<?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
	
	<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>	
	
<?php endforeach; ?>

<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>

<?php if (!is_user_logged_in() && get_option('woocommerce_enable_signup_and_login_from_checkout')=="yes") : ?>

	<?php if (get_option('woocommerce_enable_guest_checkout')=='yes') : ?>
		
		<p class="form-row">
			<input class="input-checkbox" id="createaccount" <?php checked($checkout->get_value('createaccount'), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e('Create an account?', 'sp'); ?></label>
		</p>
		
	<?php endif; ?>
	
	<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
	
	<div class="create-account">
	
		<p class="message"><?php _e('Create an account by entering the information below. If you are a returning customer please login with your username at the top of the page.', 'sp'); ?></p>
	
		<?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>
		
			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
		
		<?php endforeach; ?>
	
	</div>
	
	<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
					
<?php endif; ?>