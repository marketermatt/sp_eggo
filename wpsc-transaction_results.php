<?php
	/**
	 * The Transaction Results Theme.
	 *
	 * Displays everything within transaction results.  Hopefully much more useable than the previous implementation.
	 *
	 * @package WPSC
	 * @since WPSC 3.8
	 */

	global $purchase_log, $errorcode, $sessionid, $echo_to_screen, $cart, $message_html;
?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
			jQuery("#header_cart em.count").html("<span>Items: </span><span class='number'> 0 </span>");
			jQuery("#header_cart .pricedisplay").html("0");
			jQuery("#header_cart .shopping-cart-wrapper").html('<p class="empty"> Your shopping cart is empty </p>');
	});
	</script>

<div class="wpsc-transaction-results-wrap">
	<?php echo wpsc_transaction_theme(); ?>
</div>