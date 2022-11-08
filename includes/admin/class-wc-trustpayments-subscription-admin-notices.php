<?php
/**
 *
 * WC_TrustPayments_Subscription_Admin_Notices Class
 *
 * TrustPayments
 * This plugin will add support for process WooCommerce Subscriptions with Trust Payments
 *
 * @category Class
 * @package  TrustPayments
 * @author   wallee AG (http://www.wallee.com/)
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * WC TrustPayments Subscription Admin Notices class
 */
class WC_TrustPayments_Subscription_Admin_Notices {

	/**
	 * Migration failed notices.
	 *
	 * @return void
	 */
	public static function migration_failed_notices() {
		require_once WC_TRUSTPAYMENTS_SUBSCRIPTION_ABSPATH . 'views/admin-notices/migration-failed.php';
	}

	/**
	 * Plugin deactivated.
	 *
	 * @return void
	 */
	public static function plugin_deactivated() {
		require_once WC_TRUSTPAYMENTS_SUBSCRIPTION_ABSPATH . 'views/admin-notices/plugin-deactivated.php';
	}
}
