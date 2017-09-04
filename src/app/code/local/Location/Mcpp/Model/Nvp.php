<?php
class Location_Mcpp_Model_Nvp extends Mage_Paypal_Model_Api_Nvp{

    protected $_merchant=false;
    public function getMerchantByCart(){
        if(empty($this->_merchant)){
            $this->_merchant=Mage::helper('merchant')->findoutMerchantInCart();
        }
        return $this->_merchant;
    }
    /**
     * Return Paypal Api user name based on config data
     *
     * @return string
     */
    public function getApiUsername()
    {
        //return 'kinhdoanh_freegift-2@gmail.com';
        if($this->getMerchantByCart())
        return $this->getMerchantByCart()->getApin();
        return $this->_config->apiUsername;
    }

    /**
     * Return Paypal Api password based on config data
     *
     * @return string
     */
    public function getApiPassword()
    {
        if($this->getMerchantByCart())
            return $this->getMerchantByCart()->getApip();
        return $this->_config->apiPassword;
        //return 'BQHUQQC2VLUCSXDY';
    }

    /**
     * Return Paypal Api signature based on config data
     *
     * @return string
     */
    public function getApiSignature()
    {
        if($this->getMerchantByCart())
            return $this->getMerchantByCart()->getApis();
         return $this->_config->apiSignature;
        //return 'AFcWxV21C7fd0v3bYYYRCpSSRl31A7xO5Mwfk1o81pOdykEHAYWm.tj4';
    }
    /**
     * PayPal merchant email getter
     */
    public function getBusinessAccount()
    {
        if($this->getMerchantByCart())
            return $this->getMerchantByCart()->getPaypalemail();
        //return 'kinhdoanh_freegift-2@gmail.com';
        return $this->_getDataOrConfig('business_account');
    }
}