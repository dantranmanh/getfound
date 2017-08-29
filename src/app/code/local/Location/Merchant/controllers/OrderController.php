<?php
require_once(Mage::getModuleDir('controllers','Location_Merchant').DS.'AccountController.php');
class Location_Merchant_OrderController extends Location_Merchant_AccountController
{
    /**
     * Default merchant account page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Manage Orders'));
        $this->renderLayout();
    }

    public function viewAction() {
        $id = $this->getRequest()->getParam('id');
        $merchantStore = $this->getRequest()->getParam('merchant_store');
        Mage::register('order_id', $id);
        Mage::register('merchant_store', $merchantStore);
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/no-conflict.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/bootstrap.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.time.min.js');
        $this->renderLayout();
    }

    public function shipmentcreateAction() {
        $id = $this->getRequest()->getParam('id');
        $merchantStore = $this->getRequest()->getParam('merchant_store');
        Mage::register('order_id', $id);
        Mage::register('merchant_store', $merchantStore);
        $merchantHelper = Mage::helper('merchant');
        if (!$merchantHelper->canCreateShipment($id, Mage::getSingleton('customer/session')->getCustomerId())) {
            Mage::getModel('core/session')->addSuccess(
                'Order is cancelled and can not be shipped'
            );
            $this->_redirect('*/order/view/', array('id' =>$id, 'merchant_store'=>$merchantStore));
            return;
        }
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/no-conflict.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/bootstrap.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.time.min.js');
        $this->renderLayout();
    }

    public function saveshippingAction() {
        $post = $this->_request->getPost();

        try {
            $transaction = Mage::getModel('core/resource_transaction');
            $order = Mage::getModel('sales/order')->load($post['order_id']);
            $merchantStore = $post['merchant_store'];
            foreach($post['product'] AS $product_id => $qty) {

                if($qty <= 0) {
                    unset($post['product'][$product_id]);
                }
                $itemModel = Mage::getModel('sales/order_item')->load($product_id);
                if (($itemModel->getQtyCanceled()*1) == $itemModel->getQtyOrdered()) {
                    throw new Exception('Ordered Item has been canceled.');
                }
                if(!$itemModel->getProductId() || !($merchantStore == $itemModel->getMerchantStore())) {
                    throw new Exception('You cannot ship non-owning products');
                }

                if($itemModel->getQtyOrdered() < ($itemModel->getQtyShipped() + intval($qty))) {
                    throw new Exception('You cannot ship more products than it was ordered');
                }

            }

            if($order->getState() == 'canceled') {
                throw new Exception('You cannot create shipment for canceled order');
            }
            $shipment = $order->prepareShipment($post['product']);

            $shipment->sendEmail((isset($post['notify_customer']) && $post['notify_customer'] == '1'))
                ->setEmailSent(false)
                ->register()
                ->save();

            foreach($shipment->getAllItems() AS $item) {
                $orderItem = Mage::getModel('sales/order_item')->load($item->getOrderItemId());
                $orderItem->setQtyShipped($item->getQty() + $orderItem->getQtyShipped());
                $orderItem->save();
            }

            $sh = Mage::getModel('sales/order_shipment_track')
                ->setShipment($shipment)
                ->setData('title', $post['title'])
                ->setData('number', $post['number'])
                ->setData('carrier_code', $post['carrier_code'])
                ->setData('order_id', $shipment->getData('order_id'));

            $transaction->addObject($sh);

            $loggedUser = Mage::getSingleton( 'customer/session', array('name' => 'frontend') );
            $customer = $loggedUser->getCustomer();

            $comment = $customer->getFirstname() .' '.$customer->getLastname() . ' (#'.$customer->getId().') created shipment for ' . count($post['product']) . ' item(s)';

            $order->addStatusHistoryComment($comment);
            $fullyInvoiced = false;
            if ($order->getData('base_subtotal') == $order->getData('base_subtotal_invoiced')) {
                $fullyInvoiced = true;
            }
            if($this->_orderFullyShipped($order->getId())) {
                if ($fullyInvoiced) {
                    $state = Mage_Sales_Model_Order::STATE_COMPLETE;
                    $status = $order->getConfig()->getStateDefaultStatus(Mage_Sales_Model_Order::STATE_COMPLETE);
                } else {
                    $state = Mage_Sales_Model_Order::STATE_PROCESSING;
                    $status = 'Shipped';
                }
            }
            if($state) {
                $order->setData('state', $state);
                $order->setStatus($status);
                $order->addStatusHistoryComment($comment, false);
                $order->save();
            }
            $transaction->addObject($order);

            $transaction->save();
            Mage::getSingleton('core/session')->addSuccess('Shipment for order #'.$order->getIncrementId().' was created');
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/order/view/', array('id' => $post['order_id'], 'tab' => 'shipment','merchant_store' => $merchantStore)));
        } catch (Exception $e) {
            if (null !== $order->getIncrementId()) {
                $order->addStatusHistoryComment('Failed to create shipment - '. $e->getMessage())
                    ->save();
            }
            Mage::getSingleton('core/session')->addError($e->getMessage());
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/shipment/create/', array(
                'id' => $post['order_id'], 'tab' => 'shipment', 'merchant_store' => $merchantStore
            )));
        }
    }

    private function _orderFullyShipped($orderId = null)
    {
        if (is_null($orderId)) {
            return false;
        }
        $order = Mage::getModel('sales/order')->load($orderId);
        $totalOrderNumber = $order->getData('total_qty_ordered');
        $totalItemShipped = 0;
        foreach ($order->getAllVisibleItems() as $item){
            $totalItemShipped += $item->getQtyShipped();
        }
        if((int)$totalOrderNumber == (int)$totalItemShipped){
            return true;
        }
        return false;
    }

    public function shipmentviewAction() {
        $id = $this->getRequest()->getParam('id');
        Mage::register('shipment_id', $id);
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/no-conflict.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/bootstrap.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.time.min.js');
        $this->renderLayout();
    }

    public function createinvoiceAction(){
        $id = $this->getRequest()->getParam('order_id');
        $merchantStore = $this->getRequest()->getParam('merchant_store');
        Mage::register('order_id', $id);
        Mage::register('merchant_store', $merchantStore);
       /* $merchantHelper = Mage::helper('merchant');
        if (!$merchantHelper->canCreateShipment($id, Mage::getSingleton('customer/session')->getCustomerId())) {
            Mage::getModel('core/session')->addSuccess(
                'Order is cancelled and can not be invoiced'
            );
            $this->_redirect('merchant/order/view/', array('id' =>$id, 'merchant_store'=>$merchantStore));
            return;
        }*/
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/no-conflict.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/bootstrap.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.min.js');
        $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/merchant/plot/jquery.flot.time.min.js');
        $this->renderLayout();
    }

    public function saveinvoiceAction() {
        $post = $this->_request->getPost();

        try {
            $transaction = Mage::getModel('core/resource_transaction');
            $order = Mage::getModel('sales/order')->load($post['order_id']);
            $merchantStore = $post['merchant_store'];
            $itemsArray = array();
            foreach($post['product'] AS $product_id => $qty) {

                if($qty <= 0) {
                    unset($post['product'][$product_id]);
                }
                $itemModel = Mage::getModel('sales/order_item')->load($product_id);

                if(!$itemModel->getProductId() || ! ($merchantStore == $itemModel->getMerchantStore())) {
                    throw new Exception('You cannot ship non-owning products');
                }

                if($itemModel->getQtyOrdered() < ($itemModel->getQtyInvoiced() + intval($qty))) {
                    throw new Exception('You cannot ship more products than it was ordered');
                }
                if ($merchantStore == $itemModel->getMerchantStore()) {
                    $itemsArray[$itemModel->getId()] = $itemModel->getQtyOrdered();
                }

            }

            if($order->getState() == 'canceled') {
                throw new Exception('You cannot create invoice for canceled order');
            }
            if($order->canInvoice()) {
               Mage::getModel('sales/order_invoice_api')
                    ->create($order->getIncrementId(), $itemsArray ,'Invoice Created' ,1,1);
            }



            $loggedUser = Mage::getSingleton('customer/session', array('name' => 'frontend') );
            $customer = $loggedUser->getCustomer();

            $comment = $customer->getFirstname() .' '.$customer->getLastname() . ' (#'.$customer->getId().') created invoice for ' . count($post['product']) . ' item(s)';

            $order->addStatusHistoryComment($comment);


            Mage::getSingleton('core/session')->addSuccess('Invoice for order #'.$order->getIncrementId().' was created');
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/order/view/', array('id' => $post['order_id'], 'tab' => 'invoice')));
        } catch (Exception $e) {
            if (null !== $order->getIncrementId()) {
                $order->addStatusHistoryComment('Failed to create invoice - '. $e->getMessage())
                    ->save();
            }
            Mage::getSingleton('core/session')->addError($e->getMessage());
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/order/createinvoice/', array(
                'id' => $post['order_id'], 'tab' => 'invoice','merchant_store' => $merchantStore
            )));
        }
    }

    public function invoiceprintAction()
    {
        if ($invoiceId = $this->getRequest()->getParam('id')) {
            if ($invoice = Mage::getModel('sales/order_invoice')->load($invoiceId)) {
                $pdf = Mage::getModel('sales/order_pdf_invoice')->setIsSupplier(true)->getPdf(array($invoice));
                $this->_prepareDownloadResponse('invoice'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').
                    '.pdf', $pdf->render(), 'application/pdf');
            }
        }
        else {
            $this->_forward('noRoute');
        }
    }

}
