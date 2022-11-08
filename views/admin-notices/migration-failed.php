<?php
/**
 *
 * Migration failed View
 *
 * TrustPayments
 * This plugin will add support for process WooCommerce Subscriptions with Trust Payments
 *
 * @category View
 * @package  TrustPayments
 * @author   wallee AG (http://www.wallee.com/)
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly.
}
?>

<div class="error notice">
	<p><?php esc_html_e( 'There was an issue executing the migration for Trust Payments Subscription.', 'woo-trustpayments-subscription' ); ?></p>
</div>
