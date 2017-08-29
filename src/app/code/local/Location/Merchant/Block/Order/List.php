<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/28/2016
 * Time: 7:36 PM
 */
class Location_Merchant_Block_Order_List extends Mage_Core_Block_Template{
    CONST ENABLE = 1;
    CONST DISABLE = 2;
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/order/list.phtml');
        $salesOrderTable = Mage::getSingleton('core/resource')->getTableName('sales/order');
        $storeTableName = Mage::getSingleton('core/resource')->getTableName('store_info');
        $orders = Mage::getModel('sales/order_item')->getCollection();
        $orders->getSelect()->joinInner(
            array('order_table' => $salesOrderTable), 'order_table.entity_id = main_table.order_id',
            array(
                'order_table.increment_id',
                'order_table.customer_firstname',
                'order_table.customer_lastname',
                'SUM(main_table.row_total) as order_total'
            )
        );
        $orders->getSelect()->joinInner(
            array('store_table' => $storeTableName), 'store_table.id = main_table.merchant_store AND store_table.merchant_id = '.
            Mage::getSingleton('customer/session')->getCustomer()->getId(),
            array('store_table.store_name')
        );
        $orders->getSelect()->group("CONCAT(main_table.merchant_store,'_', main_table.order_id)");
        $orders->getSelect()->Order('main_table.order_id DESC');
        $this->setMerchantOrders($orders);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'merchant.products.history.pager')
            ->setCollection($this->getMerchantOrders());
        $this->setChild('pager', $pager);
        $this->getMerchantOrders()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    public function formatStatus($status) {
        if ($status == self::ENABLE) {
            return 'Enable';
        } else if ($status == self::DISABLE) {
            return 'Disable';
        }
    }

    public function isFullyShipped($orderId = null, $merchantStore = null) {
        try {
            if (empty($orderId) || empty($merchantStore)) {
                return false;
            }
            $order = Mage::getModel('sales/order')->load($orderId);
            $orderItems = $order->getItemsCollection();
            $allOrderItemIds = array();
            $shipments = $order->getShipmentsCollection();
            $shippedItemIds = array();

            foreach($orderItems As $item) {
                if($merchantStore == $item->getMerchantStore()) {
                    $allOrderItemIds[$item->getItemId()] = $item->getQtyOrdered();
                }
            }

            foreach ($shipments as $shipment) {
                $shippedItems = $shipment->getItemsCollection();
                foreach ($shippedItems as $item) {
                    if($merchantStore == $item->getMerchantStore()) {
                        if(!isset($shippedItemIds[$item->getOrderItemId()])) {
                            $shippedItemIds[$item->getOrderItemId()] = 0;
                        }
                        $shippedItemIds[$item->getOrderItemId()] = $shippedItemIds[$item->getOrderItemId()] + $item->getQty();
                    }
                }
            }
            return (count($shippedItemIds) == count($allOrderItemIds) && array_sum($allOrderItemIds) == array_sum($shippedItemIds));
        } catch (Exception $e) {
            Mage::log($e, null, 'merchant_order.log');
        }
        return false;

    }

}