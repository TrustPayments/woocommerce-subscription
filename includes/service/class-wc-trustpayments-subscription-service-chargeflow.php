<?php
if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
}
/**
 * This service provides functions to deal with chargeflows
 */
class WC_TrustPayments_Subscription_Service_ChargeFlow extends WC_TrustPayments_Service_Abstract {
    
    /**
     * The transaction API service.
     *
     * @var \TrustPayments\Sdk\Service\ChargeFlowService
     */
    private $chargeflow_service;
    
    
    /**
     * Returns the transaction API service.
     *
     * @return \TrustPayments\Sdk\Service\ChargeFlowService
     */
    protected function get_chargeflow_service(){
        if ($this->chargeflow_service === null) {
            $this->chargeflow_service = new \TrustPayments\Sdk\Service\ChargeFlowService(WC_TrustPayments_Helper::instance()->get_api_client());
        }
        return $this->chargeflow_service;
    }
    
    public function apply_chargeflow_on_transaction($space_id, $transaction_id){
        return $this->get_chargeflow_service()->applyFlow($space_id, $transaction_id);
    }
}