<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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
global $woocommerce;
?>

<?php wc_print_notices(); ?>

<form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post" class="change-password">

	<p class="form-row form-row-first">
		<label for="password_1"><?php _e('New password', 'sp'); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password_1" id="password_1" />
	</p>
	<p class="form-row form-row-last">
		<label for="password_2"><?php _e('Re-enter new password', 'sp'); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password_2" id="password_2" />
	</p>
	<div class="group"></div>
	
	<p><input type="submit" class="button" name="change_password" value="<?php _e('Save', 'sp'); ?>" /></p>
	
	<?php wc_print_notices('change_password')?>
	<input type="hidden" name="action" value="change_password" />
	
</form>