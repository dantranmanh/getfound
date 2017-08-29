<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/2/2016
 * Time: 1:08 PM
 */
class Location_Merchant_Model_Observer{

    public function salesQuoteItemSetTotalCredits($observer) {
        try {
            //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
            $order = $observer->getEvent()->getOrder();
            $item = $observer->getEvent()->getItem();
            $itemsOrder = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
            foreach($itemsOrder as $itemOr) {
                $ordersQty = $itemOr->getQty() ;
            }

            foreach($order->getAllVisibleItems() as $orderItem){
                $totCredits = $orderItem->getTotalNumOfCredits();
            }
           // Mage::log($ordersQty, null, 'track.log', true);
            if ($item instanceof Mage_Sales_Model_Quote_Item) {

                $product = $item->getProduct();


                if ($product->getNumberOfCredits()) {
                    //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
                    $numberOfCredits = $product->getNumberOfCredits();
                } else {
                    //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
                    $numberOfCredits = 0;
                }
                //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
                $allCredits = ($numberOfCredits * $ordersQty) + $totCredits ;
                $item->setTotalNumOfCredits($allCredits);
            }
        } catch (Exception $e) {
            //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
        }
        //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
        return $this;
    }


    public function salesOrderSetMerchantCredits($observer){
        $order = $observer->getEvent()->getOrder();
        try{
            $totCredits = 0;
            foreach($order->getAllVisibleItems() as $item){
                if ($item->getProduct()->getTypeId() ==  Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL) {
                    $totCredits = $totCredits + $item->getTotalNumOfCredits();
                }
            }
            if ($totCredits) {
                $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
                if ($customer instanceof Mage_Customer_Model_Customer) {
                    $customer->setMerchantCredit(
                        $customer->getMerchantCredit() + $totCredits
                    );
                    $customer->save();
                }
            }
            //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
        } catch(Exception $e){
            //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
            Mage::log($e,null,'error.log',true);
        }
        //Mage::log(__METHOD__.' - '.__LINE__, null, 'track.log', true);
    }

}