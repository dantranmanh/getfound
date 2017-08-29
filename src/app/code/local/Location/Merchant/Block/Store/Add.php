<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_Store_Add extends Mage_Core_Block_Template{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/store/add.phtml');
    }

    public function getSaveStoreUrl() {
        return Mage::helper('merchant')->getSaveStoreUrl();
    }

    public function getCityUrl() {
        return Mage::getUrl('merchant/store/city');
    }
    public function getStateList() {
        $stateCollection = Mage::getModel('state/state')->getCollection();
        $stateCollection->addFieldToFilter('status', 1);
        return $stateCollection;
    }
}