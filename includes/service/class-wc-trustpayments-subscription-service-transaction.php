<?php
/**
 * WC_TrustPayments_Subscription_Service_Transaction Class
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
	exit(); // Exit if accessed directly.
}

/**
 * This service provides functions to deal with Trust Payments transactions.
 */
class WC_TrustPayments_Subscription_Service_Transaction extends WC_TrustPayments_Service_Transaction {


	/**
	 * Creates a transaction for the given order.
	 *
	 * @param WC_Order $order       Order.
	 * @param mixed    $order_total Order total.
	 * @param int      $token_id    Token id.
	 *
	 * @return \TrustPayments\Sdk\Model\Transaction
	 */
	public function create_transaction_by_renewal_order( WC_Order $order, $order_total, $token_id ) {
		$space_id = get_option( WooCommerce_TrustPayments::CK_SPACE_ID );
		$create_transaction = new \TrustPayments\Sdk\Model\TransactionCreate();
		$create_transaction->setCustomersPresence( \TrustPayments\Sdk\Model\CustomersPresence::VIRTUAL_PRESENT );
		$space_view_id = get_option( WooCommerce_TrustPayments::CK_SPACE_VIEW_ID );
		if ( is_numeric( $space_view_id ) ) {
			$create_transaction->setSpaceViewId( $space_view_id );
		}
		$create_transaction->setToken( $token_id );
		$this->assemble_order_transaction_data( $order, $create_transaction );
		$this->set_modified_order_line_items( $order, $order_total, $create_transaction );

		$create_transaction = apply_filters( 'wc_trustpayments_subscription_create_transaction', $create_transaction, $order );
		$transaction = $this->get_transaction_service()->create( $space_id, $create_transaction );
		$this->update_transaction_info( $transaction, $order );
		return $transaction;
	}

	/**
	 * Creates a transaction for the given order.
	 *
	 * @param WC_Order                                     $order       Order.
	 * @param mixed                                        $order_total Order total.
	 * @param int                                          $token_id    Token id.
	 * @param \TrustPayments\Sdk\Model\Transaction $transaction Transaction.
	 *
	 * @return \TrustPayments\Sdk\Model\Transaction
	 *
	 * @throws Exception Exception.
	 */
	public function update_transaction_by_renewal_order( WC_Order $order, $order_total, $token_id, \TrustPayments\Sdk\Model\Transaction $transaction ) {
		$last = new \TrustPayments\Sdk\VersioningException();
		for ( $i = 0; $i < 5; $i++ ) {
			try {
				$pending_transaction = new \TrustPayments\Sdk\Model\TransactionPending();
				$pending_transaction->setId( $transaction->getId() );
				$pending_transaction->setVersion( $transaction->getVersion() );
				$pending_transaction->setToken( $token_id );
				$this->assemble_order_transaction_data( $order, $pending_transaction );
				$this->set_modified_order_line_items( $order, $order_total, $pending_transaction );
				$pending_transaction = apply_filters( 'wc_trustpayments_subscription_update_transaction', $pending_transaction, $order );
				return $this->get_transaction_service()->update( $transaction->getLinkedSpaceId(), $pending_transaction );
			} catch ( \TrustPayments\Sdk\VersioningException $e ) {
				$last = $e;
			}
		}
		throw $last;
	}

	/**
	 * Set modified order line items.
	 *
	 * @param WC_Order                                                    $order       Order.
	 * @param mixed                                                       $order_total Order total.
	 * @param \TrustPayments\Sdk\Model\AbstractTransactionPending $transaction Transaction.
	 *
	 * @return void
	 */
	protected function set_modified_order_line_items( WC_Order $order, $order_total, \TrustPayments\Sdk\Model\AbstractTransactionPending $transaction ) {
		$raw_items = WC_TrustPayments_Service_Line_Item::instance()->get_raw_items_from_order( $order );
		$cleaned = WC_TrustPayments_Helper::instance()->cleanup_line_items( $raw_items, $order_total, $order->get_currency() );
		$transaction->setLineItems( $cleaned );

	}


	/**
	 * Process transaction without user interaction.
	 *
	 * @param mixed $space_id       Space id.
	 * @param mixed $transaction_id Transaction id.
	 *
	 * @return mixed
	 */
	public function process_transaction_without_user_interaction( $space_id, $transaction_id ) {
		return $this->get_transaction_service()->processWithoutUserInteraction( $space_id, $transaction_id );
	}


	/**
	 * Set order line items.
	 *
	 * @param  WC_Order                                                    $order       Order.
	 * @param  \TrustPayments\Sdk\Model\AbstractTransactionPending $transaction Transaction.
	 * @return void
	 */
	protected function set_order_line_items( WC_Order $order, \TrustPayments\Sdk\Model\AbstractTransactionPending $transaction ) {
	}


}
