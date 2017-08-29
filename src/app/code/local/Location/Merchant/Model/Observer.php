<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/2/2016
 * Time: 1:08 PM
 */
class Location_Merchant_Model_Observer extends Mage_Customer_Model_Observer
{

    public function salesQuoteItemSetTotalCredits($observer) {
        try {
            $item = $observer->getEvent()->getItem();
            if ($item instanceof Mage_Sales_Model_Quote_Item) {
                $product = $item->getProduct();
                if ($item->getProduct()->getTypeId() ==  Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL) {
                    if ($product->getNumberOfCredits()) {
                        $item->setTotalNumOfCredits($product->getNumberOfCredits());
                    }
                    $customer = Mage::getSingleton('customer/session')->getCustomer();
                    if ($customer->getGroupId() == Mage::helper('merchant')->getMerchantCustomerGroupId()) {
                        $item->setMerchantId($customer->getId());
                    }
                }

                if ((int)$product->getMerchantStore()) {
                    $item->setMerchantStore((int)$product->getMerchantStore());
                }
                if(!$item->getCostOfDelivery()) {
                    if($product->getCostOfDelivery()){
                        $item->setCostOfDelivery($product->getCostOfDelivery());
                    }
                }
            }
        } catch (Exception $e) {}
        return $this;
    }

    public function salesOrderSetMerchantCredits($observer){
        $order = $observer->getEvent()->getOrder();
        try{
            $totCredits = 0;
            $creditDeduct = array();
            $orderAllItems = $order->getAllVisibleItems();
            foreach($orderAllItems as $item){
                if ($item->getProduct()->getTypeId() ==  Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL) {
                    $totCredits = $totCredits + (int)$item->getTotalNumOfCredits();
                } else {
                    $creditDeduct[$item->getMerchantStore()] = $creditDeduct[$item->getMerchantStore()] + (int)$item->getQtyOrdered();
                }
            }
            if ($totCredits) {
                $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
                if ($customer instanceof Mage_Customer_Model_Customer) {
                    if ($customer->getGroupId() == Mage::helper('merchant')->getMerchantCustomerGroupId()) {
                        $customer->setMerchantCredit(
                            $customer->getMerchantCredit() + $totCredits
                        );
                        $customer->save();
                        $this->_updateCreditHistory(
                            $customer->getId(),
                            $order->getId(),
                            $order->getIncrementId(),
                            '+'.$totCredits,
                            'Credit has been added due to credit purchase'
                        );
                    }

                }
            }
            if (!empty($creditDeduct)) {
                foreach ($creditDeduct as $merchantStoreId => $creditValue) {
                    if ($creditValue) {
                        if ($merchantId = Mage::helper('merchant')->getMerchantIdByStoreId($merchantStoreId)) {
                            $customer = Mage::getModel('customer/customer')->load(
                                $merchantId
                            );
                            if ($customer->getGroupId() == Mage::helper('merchant')->getMerchantCustomerGroupId()) {
                                $customer->setMerchantCredit(
                                    $customer->getMerchantCredit() - $creditValue
                                );
                                $customer->save();
                                $this->_updateCreditHistory(
                                    $customer->getId(),
                                    $order->getId(),
                                    $order->getIncrementId(),
                                    '-'.$creditValue,
                                    'Credit has been deducted due to order placement'
                                );
                            }
                        }
                    }
                }

            }
        } catch(Exception $e){
            Mage::log($e,null,'error.log',true);
        }
        return $this;
    }

    public function cancelOrderItem($observer) {
        try{
            $item = $observer->getEvent()->getItem();
            $qty = $item->getQtyOrdered() - max($item->getQtyShipped(), $item->getQtyInvoiced()) - $item->getQtyCanceled();
            if ($item->getProduct()->getTypeId() !=  Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL) {
                if ($item->getMerchantStore()) {
                    $merchantId = Mage::helper('merchant')->getMerchantIdByStoreId($item->getMerchantStore());
                    $customer = Mage::getModel('customer/customer')->load(
                        $merchantId
                    );
                    if ($customer instanceof Mage_Customer_Model_Customer) {
                        if ($customer->getGroupId() == Mage::helper('merchant')->getMerchantCustomerGroupId()) {
                            $customer->setMerchantCredit(
                                $customer->getMerchantCredit() + $qty
                            );
                            $customer->save();
                            $order = Mage::getModel('sales/order')->load($item->getOrderId());
                            if ($order instanceof Mage_Sales_Model_Order) {
                                $this->_updateCreditHistory(
                                    $customer->getId(),
                                    $order->getId(),
                                    $order->getIncrementId(),
                                    '+' . $qty,
                                    'Credit has been reverted due to order cancellation'
                                );
                            }
                        }
                    }
                }
            }
        } catch(Exception $e){
            Mage::log($e,null,'error.log',true);
        }
        return $this;
    }

    protected function _updateCreditHistory(
        $merchantId = null, $orderId = null, $orderIncrementId = null, $credit = null, $msg = null
    ) {
        try {
            if ($merchantId) {
                $creditHistoryModel = Mage::getModel('merchant/history');
                $creditHistoryModel->setMerchantId($merchantId);
                $creditHistoryModel->setOrderId($orderId);
                $creditHistoryModel->setOrderIncrementId($orderIncrementId);
                $creditHistoryModel->setCredit($credit);
                $creditHistoryModel->setMessage($msg);
                $creditHistoryModel->save();
            }
        } catch (Exception $e) {

        }
        return;
    }

    public function saveProductMerchantStoreInInvoice(Varien_Event_Observer $observer) {
        try {
            $invoice = $observer->getEvent()->getInvoice();
            foreach($invoice->getAllItems() as $item) {
                $orderItemMerchantStore = Mage::getModel('sales/order_item')->load($item->getOrderItemId())->getMerchantStore();
                $item->setMerchantStore($orderItemMerchantStore);
            }
        } catch (Exception $e) {

        }
        return $this;
    }

    public function saveProductMerchantStoreInShipment(Varien_Event_Observer $observer)
    {
        try {
            $shipment = $observer->getEvent()->getShipment();
            foreach($shipment->getAllItems() as $item) {
                $orderItemMerchantStore = Mage::getModel('sales/order_item')->load($item->getOrderItemId())->getMerchantStore();
                $item->merchant_store = $orderItemMerchantStore;
            }
        } catch (Exception $e) {

        }
        return $this;
    }

    /**
     * Before load layout event handler
     *
     * @param Varien_Event_Observer $observer
     */
    public function beforeLoadLayout($observer)
    {
        $loggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if ($loggedIn) {

            if (Mage::getSingleton('customer/session')->getCustomer()->getGroupId() ==
                Mage::helper('merchant')->getMerchantCustomerGroupId()) {
                $observer->getEvent()->getLayout()->getUpdate()
                    ->addHandle('merchant_logged_in');
            } else {
                Mage::log(__LINE__, null, 'trace.log', true);
                Mage::log(Mage::getSingleton('customer/session')->getCustomer()->getGroupId(), null, 'trace.log', true);
                $observer->getEvent()->getLayout()->getUpdate()
                    ->addHandle('customer_logged_in');
            }
        } else {
            $observer->getEvent()->getLayout()->getUpdate()
                ->addHandle('customer_logged_out');
            $observer->getEvent()->getLayout()->getUpdate()
                ->addHandle('merchant_logged_out');

        }

    }
}