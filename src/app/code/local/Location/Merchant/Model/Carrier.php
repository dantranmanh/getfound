<?php

class Location_Merchant_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface{

    /**
     * Enter description here...
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $result = Mage::getModel('shipping/rate_result');



        try {
            $allItems = $request->getAllItems();
            $shippingCharges = 0;
            if ($allItems) {
                foreach ($allItems as $item) {
                    if ($item->getParentItemId()) {
                        continue;
                    }
                    /*Update Cost Of Shipping*/
                    $shippingCharges = $shippingCharges + $item->getCostOfDelivery();
                }
            }
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier('customshipping');
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod('customshipping');
            $method->setPrice($shippingCharges);
            $method->setMethodTitle($this->getConfigData('name'));
            $result->append($method);
        } catch (Exception $e) {

        }
        return $result;
    }


    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('customshipping'=>$this->getConfigData('name'));
    }
}