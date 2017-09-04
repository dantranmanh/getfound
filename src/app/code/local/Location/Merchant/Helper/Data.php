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
     * Retrieve merchant Store Credit url
     *
     * @return string
     */
    public function getStoreCreditUrl()
    {
        return $this->_getUrl('merchant/credits/index');
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

    public function isMerchantAccount($groupId){
        if(!empty($groupId)){
            if($groupId == $this->getMerchantCustomerGroupId()) return true;
        }
        return false;
    }
    public function getMerchantPayment($groupId = null){
        $result=array();
        if(empty($groupId)){
            $groupId = Mage::getSingleton('customer/session')->getCustomer()->getGroupId();
        }
        if($this->isMerchantAccount($groupId)){


            return $result;
        }
        Mage::throwException(Mage::helper('paypal')->__('There was an error in Paypal processing!'));

    }

    public function findoutMerchantInCart(){
        $merchants=array();
        $storeTableName = Mage::getSingleton('core/resource')->getTableName('store_info');
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItems = $quote->getAllVisibleItems();
        foreach ($cartItems as $item) {
            $productId = $item->getProductId();
            $product = Mage::getModel('catalog/product')->load($productId);
            $storeid= $product->getData('merchant_store');
            if(!empty($storeid)){
                $query="SELECT * FROM `".$storeTableName."` where `id` = ".$storeid.";";
                $results=$this->readingQuery($query);
                //Zend_debug::dump($results[0]);
                if(!empty($results[0])){
                   $id=$results[0]['merchant_id'];
                   if(!in_array($id,$merchants)) $merchants[] = $id;
                }
            }
        }
        if(count($merchants) > 1 ){
            Mage::getSingleton('core/session')->addError(Mage::helper('merchant')->__('Buy products from 2 or more merchants!'));
            return false;
        }

        if(count($merchants) == 0 ){
            //Mage::getSingleton('core/session')->addError(Mage::helper('merchant')->__('Can not find out merchants!'));
            /** there is no product created by merchants in cart*/
            return false;
        }
        $merchant=Mage::getModel('customer/customer')->load($merchants[0]);
        return $merchant;
    }
    /**
     * @param string $query
     * @return array
     */
    public function readingQuery($query=""){
        if(empty($query)) return array();
        /**
         * Get the resource model
         */
        $resource = Mage::getSingleton('core/resource');
        /**
         * Retrieve the read connection
         */
        $readConnection = $resource->getConnection('core_read');
        /**
         * Execute the query and store the results in $results
         */
        $results = $readConnection->fetchAll($query);
        return $results;
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
    
    public function getMerchantIdByStoreId($merchantStoreId = null) {
        try {
            $merchantId = 0;
            if ($merchantStoreId) {
                $merchantStore = Mage::getModel('store/store')->load($merchantStoreId);
                if ($merchantStore instanceof Location_Store_Model_Store) {
                    $merchantId = $merchantStore->getMerchantId();
                }
            }
        } catch (Exception $e) {

        }
        return $merchantId;
    }

    public function getMerchantOrderStatus($orderItem = null) {
        try {
            if ($orderItem instanceof Mage_Sales_Model_Order_Item) {
                if ($orderItem->getQtyOrdered() == $orderItem->getQtyCanceled()) {
                    return 'Cancelled';
                } else if (($orderItem->getQtyOrdered() - $orderItem->getQtyCanceled()) == $orderItem->getQtyShipped()) {
                    return 'Shipped';
                } else if (($orderItem->getQtyOrdered() - $orderItem->getQtyCanceled()) == $orderItem->getQtyInvoiced()) {
                    return 'Invoiced';
                } else if (($orderItem->getQtyOrdered() - $orderItem->getQtyCanceled()) == $orderItem->getQtyOrdered()) {
                    return 'Pending';
                }
            }
        } catch (Exception $e) {

        }
        return false;
    }


    Public function canCreateInvoice($orderId = null) {
        try {
            if (is_null($orderId)) {
                return false;
            }
            return $this->_canShipInvoice($orderId);
        } catch(Exception $e) {
            Mage::logException($e);
        }
        return false;
    }

    public function canCreateShipment($orderId = null) {
        try {
            if (is_null($orderId)) {
                return false;
            }
            return $this->_canShipInvoice($orderId);
        } catch(Exception $e) {
            Mage::logException($e);
        }
        return false;
    }
    public function getMerchantStore() {
        return Mage::registry('merchant_store');
    }

    private function _canShipInvoice($orderId = null) {
        try {
            if (is_null($orderId)) {
                return false;
            }
            $orderInfo = Mage::getModel('sales/order')->load($orderId);
            if (($orderInfo->getStatus() == 'payment_failed')) {
                return false;
            }
            if ($orderInfo instanceof Mage_Sales_Model_Order) {
                $orderItems = $orderInfo->getAllItems();
                $itemCount = 0;
                $cancelItemCount = 0;
                foreach($orderItems as $item) {
                    if ($item->getSellerId() == $this->getMerchantStore()) {
                        $itemCount++;
                        if ($this->isAlreadyCanceled($item) ||
                            ($item->getStatusId() == Mage_Sales_Model_Order_Item::STATUS_CANCELED)) {
                            $cancelItemCount++;
                        }

                    }
                }
                if ($cancelItemCount) {
                    return false;
                } else {
                    return true;
                }
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }
        return true;
    }

    public function isAlreadyCanceled($orderItem = null) {
        try {
            if (!is_null($orderItem)) {
                if ($orderItem instanceof Mage_Sales_Model_Order_Item) {
                    if (($orderItem->getStatusId() != Mage_Sales_Model_Order_Item::STATUS_CANCELED) &&
                        ($orderItem->getStatusId() != Mage_Sales_Model_Order_Item::STATUS_SHIPPED) &&
                        ($orderItem->getStatusId() != Mage_Sales_Model_Order_Item::STATUS_INVOICED)) {
                        return false;
                    }
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return false;
    }
	
	Public function getCreditBalance() {
        try {
			$storeCredit = Mage::getSingleton('customer/session')->getCustomer()->getMerchantCredit();
            if ($storeCredit) {
                return $storeCredit;
            } else {
				 return false;
			}
        } catch(Exception $e) {
            Mage::logException($e);
        }
        return false;
    }
	
}
