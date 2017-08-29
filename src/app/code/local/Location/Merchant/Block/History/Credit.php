<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_History_Credit extends Mage_Core_Block_Template{
    CONST ENABLE = 1;
    CONST DISABLE = 2;
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/history/credit.phtml');
        $creditHistory = Mage::getModel('merchant/history')->getCollection();
        $creditHistory->addFieldToFilter('merchant_id',  Mage::getSingleton('customer/session')->getCustomer()->getId());
        $this->setCreditHistory($creditHistory);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'merchant.products.history.pager')
            ->setCollection($this->getCreditHistory());
        $this->setChild('pager', $pager);
        $this->getCreditHistory()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getTotalCreditValue() {
        return Mage::getSingleton('customer/session')->getCustomer()->getMerchantCredit();
    }

}