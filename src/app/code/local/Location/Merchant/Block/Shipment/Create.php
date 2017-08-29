<?php
class Location_Merchant_Block_Shipment_Create extends Mage_Core_Block_Template {
    public function getOrder() {
        $id = Mage::registry('order_id');
        return Mage::getModel('sales/order')->load($id);
    }

    public function getMerchantStore() {
        return Mage::registry('merchant_store');
    }

    public function getItems() {
        $id = Mage::registry('order_id');
        $_order = Mage::getModel('sales/order')->load($id);
        $_items = array();
        $merchantStore = $this->getMerchantStore();
        foreach($_order->getAllItems() AS $item) {
            if($merchantStore == $item->getMerchantStore()) {
                    $_items[] = $item;
            }
        }

        return $_items;
    }
}