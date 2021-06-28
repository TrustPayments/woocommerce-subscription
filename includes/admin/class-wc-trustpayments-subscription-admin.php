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
 * WC_TrustPayments_Subscription_Admin  class
 */
class WC_TrustPayments_Subscription_Admin {
	
	/**
	 * The single instance of the class.
	 *
	 * @var WC_TrustPayments_Subscription_Admin
	 */
	protected static $_instance = null;

	/**
	 * Main WooCommerce TrustPayments Plugin Admin Instance.
	 *
	 * Ensures only one instance of WC_TrustPayments_Subscription_Admin is loaded or can be loaded.
	 *
	 * @return WC_TrustPayments_Subscription_Admin - Main instance.
	 */
	public static function instance(){
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WC TrustPayments Admin Constructor.
	 */
	protected function __construct(){
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	private function includes(){
	    require_once (WC_TRUSTPAYMENTS_SUBSCRIPTION_ABSPATH . 'includes/admin/class-wc-trustpayments-subscription-admin-notices.php');
	}

	private function init_hooks(){		
		add_action('admin_init', array(
			$this,
			'handle_modules_active'
		));

	}
	
	public function handle_modules_active(){
		// Subscription plugin or base plugin not activated
	    if (!is_plugin_active('woocommerce-subscriptions/woocommerce-subscriptions.php') || !is_plugin_active('woo-trustpayments/woocommerce-trustpayments.php'))
		{
			// Deactivate myself
		    deactivate_plugins(WC_TRUSTPAYMENTS_SUBSCRIPTION_PLUGIN_BASENAME);
			add_action('admin_notices', array(
				'WC_TrustPayments_Subscription_Admin_Notices',
				'plugin_deactivated'
			));
		}
		
	}
	
}

WC_TrustPayments_Subscription_Admin::instance();
