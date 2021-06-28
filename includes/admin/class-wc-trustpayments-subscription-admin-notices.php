<?php
if (!defined('ABSPATH')) {
	exit();
}
/**
 * Trust Payments WooCommerce
 *
 * This WooCommerce plugin enables to process payments with Trust Payments (https://www.trustpayments.com/).
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */
/**
 * WC TrustPayments Subscription Admin Notices class
 */
class WC_TrustPayments_Subscription_Admin_Notices {

	public static function migration_failed_notices(){
	    require_once WC_TRUSTPAYMENTS_SUBSCRIPTION_ABSPATH.'views/admin-notices/migration-failed.php';
	}
	
	public static function plugin_deactivated(){
	    require_once WC_TRUSTPAYMENTS_SUBSCRIPTION_ABSPATH.'views/admin-notices/plugin-deactivated.php';
	}
}