<?php
class Location_Merchant_Helper_Data extends Mage_Customer_Helper_Data{

    /**
     * Route for merchant account login page
     */
    const ROUTE_ACCOUNT_LOGIN = 'merchant/account/login';
    const MERCHANT_CUSTOMER_GROUP_ID = 'merchant_setting/customer/group_id';

    public function getMerchantCustomerGroupId() {
        return Mage::getStoreConfig(self::MERCHANT_CUSTOMER_GROUP_ID);
    }

    /**
     * Retrieve merchant login POST URL
     *
     * @return string
     */
    public function getLoginPostUrl()
    {
        $params = array();
        if ($this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)) {
            $params = array(
                self::REFERER_QUERY_PARAM_NAME => $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)
            );
        }
        return $this->_getUrl('merchant/account/loginPost', $params);
    }

    /**
     * Retrieve merchant register form url
     *
     * @return string
     */
    public function getRegisterUrl()
    {
        return $this->_getUrl('merchant/account/create');
    }

    /**
     * Retrieve url of forgot password page
     *
     * @return string
     */
    public function getForgotPasswordUrl()
    {
        return $this->_getUrl('merchant/account/forgotpassword');
    }

    /**
     * Retrieve merchant register form post url
     *
     * @return string
     */
    public function getRegisterPostUrl()
    {
        return $this->_getUrl('merchant/account/createpost');
    }

    /**
     * Retrieve merchant login url
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->_getUrl(self::ROUTE_ACCOUNT_LOGIN, $this->getLoginUrlParams());
    }

    /**
     * Retrieve merchant account page url
     *
     * @return string
     */
    public function getAccountUrl()
    {
        return $this->_getUrl('merchant/account');
    }

    /**
     * Retrieve merchant dashboard url
     *
     * @return string
     */
    public function getDashboardUrl()
    {
        return $this->_getUrl('merchant/account');
    }

    /**
     * Retrieve merchant logout url
     *
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->_getUrl('merchant/account/logout');
    }

    /**
     * Retrieve merchant add store url
     *
     * @return string
     */
    public function getAddStoreUrl()
    {
        return $this->_getUrl('merchant/store/add');
    }

    /**
     * Retrieve merchant add product url
     *
     * @return string
     */
    public function getAddProductUrl()
    {
        return $this->_getUrl('merchant/product/add');
    }

    /**
     * Retrieve merchant add store url
     *
     * @return string
     */
    public function getSaveStoreUrl()
    {
        return $this->_getUrl('merchant/store/save');
    }

    /**
     * Retrieve merchant add store url
     *
     * @return string
     */
    public function getSaveProductUrl()
    {
        return $this->_getUrl('merchant/product/save');
    }


    public function getMerchantList() {
        $optionArray = array();
        $i= 0;
        $optionArray[$i] = array(
            'label'=> '-- Select --',
            'value'=> '0',
        );
        try{
            $merchantCollection = Mage::getModel('customer/customer')->getCollection();
            $merchantCollection->addFieldToFilter(
                'group_id', $this->getMerchantCustomerGroupId()
            );
            if ($merchantCollection->count()) {
                foreach ($merchantCollection as $merchant) {
                    $i++;
                    $optionArray[$i] = array(
                        'label'=> $merchant->getEmail(),
                        'value'=> $merchant->getId(),
                    );
                }
            }
        } catch (Exception $e) {

        }
        return $optionArray;
    }

    public function getMerchantOption() {
        $optionArray = array();
        try{
            $merchantCollection = Mage::getModel('customer/customer')->getCollection();
            $merchantCollection->addFieldToFilter(
                'group_id', $this->getMerchantCustomerGroupId()
            );
            if ($merchantCollection->count()) {
                foreach ($merchantCollection as $merchant) {
                    $optionArray[$merchant->getId()] = $merchant->getEmail();
                }
            }
        } catch (Exception $e) {

        }
        return $optionArray;
    }
}
