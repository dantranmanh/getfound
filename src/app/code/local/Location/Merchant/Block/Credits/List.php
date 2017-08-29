<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_Credits_List extends Mage_Catalog_Block_Product_List{
   protected $_creditsCollection = null;
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/credits/list.phtml');
        $stores = Mage::getModel('store/store')->getCollection();
        $stores->addFieldToFilter('merchant_id',  Mage::getSingleton('customer/session')->getCustomer()->getId());
        $this->setStores($stores);
    }

    public function getCreditsCollection(){

        try{
            if(is_null($this->_creditsCollection)){
                $merchantStoreId = $this->getRequest()->getParam('id', 0);

                $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
                $products->addFieldToFilter(
                    'type_id','virtual'
                );

                $products->getSelect();
                Mage::log((string)$products->getSelect(),null,'credits.log',true);
                $this->_creditsCollection = $products;
            }

        }
         catch(Exception $e){
            Mage::log($e, null,'product.log', true);
        }
        return $this->_creditsCollection;
        
    }

   
}