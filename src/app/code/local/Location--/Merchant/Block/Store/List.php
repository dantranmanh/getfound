<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_Store_List extends Mage_Core_Block_Template{
    CONST ENABLE = 1;
    CONST DISABLE = 2;
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/store/list.phtml');
        $stores = Mage::getModel('store/store')->getCollection();
        $stores->addFieldToFilter('merchant_id',  Mage::getSingleton('customer/session')->getCustomer()->getId());
        $this->setStores($stores);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'merchant.stores.history.pager')
            ->setCollection($this->getStores());
        $this->setChild('pager', $pager);
        $this->getStores()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getStateName($stateId = null) {
        try {
            $state = Mage::getModel('state/state')->load($stateId);
            return $state->getStateName();
        } catch (Exception $e) {

        }
        return;
    }

    public function getCityName($cityId = null) {
        try {
            $city = Mage::getModel('city/city')->load($cityId);
            return $city->getCityName();
        } catch (Exception $e) {

        }
        return;
    }

    public function formatStatus($status) {
        if ($status == self::ENABLE) {
            return 'Enable';
        } else if ($status == self::DISABLE) {
            return 'Disable';
        }
    }

    public function getAddStoreUrl() {
        return Mage::helper('merchant')->getAddStoreUrl();
    }

    public function getEditUrl($storeId = null) {
        return Mage::getUrl('merchant/store/edit', array('id'=>$storeId));
    }
}