<?php


class Location_Merchant_Block_Account_Dashboard_Hello extends Mage_Core_Block_Template
{

    public function getCustomerName()
    {
        return Mage::getSingleton('customer/session')->getCustomer()->getFullname();
    }

}
