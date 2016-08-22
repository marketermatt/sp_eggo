<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
global $woocommerce, $current_user;

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<?php if (!$load_address) : ?>

	<?php woocommerce_get_template('myaccount/my-address.php'); ?>

<?php else : ?>

	<form action="<?php echo esc_url( add_query_arg( 'address', $load_address, get_permalink( woocommerce_get_page_id('edit_address') ) ) ); ?>" method="post" class="change-address">
		
		<h3><?php if ($load_address=='billing') _e('Billing Address', 'sp'); else _e('Shipping Address', 'sp'); ?></h3>
		
		<?php 
		foreach ($address as $key => $field) :
			$value = (isset($_POST[$key])) ? $_POST[$key] : get_user_meta( get_current_user_id(), $key, true );
			
			// Default values
			if (!$value && ($key=='billing_email' || $key=='shipping_email')) $value = $current_user->user_email;
			if (!$value && ($key=='billing_country' || $key=='shipping_country')) $value = $woocommerce->countries->get_base_country();
			if (!$value && ($key=='billing_state' || $key=='shipping_state')) $value = $woocommerce->countries->get_base_state();
			
			woocommerce_form_field( $key, $field, $value );
		endforeach;
		?>
		
		<input type="submit" class="button" name="save_address" value="<?php _e('Save Address', 'sp'); ?>" />
		
		<?php wc_print_notices('edit_address') ?>
		<input type="hidden" name="action" value="edit_address" />
	
	</form>

<?php endif; ?>