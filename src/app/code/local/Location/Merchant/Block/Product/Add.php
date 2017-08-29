<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_Product_Add extends Mage_Core_Block_Template{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/product/add.phtml');
    }

    public function getSaveProductUrl() {
        return Mage::helper('merchant')->getSaveProductUrl();
    }

    public function getStoreList(){
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $MerchantId = Mage::getSingleton('customer/session')->getCustomerId();

        }

      $storeCollection = Mage::getModel('store/store')->getCollection();
      $storeCollection->addFieldToFilter(
          'status', 1
      );
      $storeCollection->addFieldToFilter('merchant_id',$MerchantId);
        return $storeCollection;
    }
}