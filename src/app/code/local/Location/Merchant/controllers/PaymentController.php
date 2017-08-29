<?php

require_once(Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AccountController.php');

class Location_Merchant_PaymentController extends Mage_Customer_AccountController
{
    public function editAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
        //echo "paymentEdit here"; exit;

    }
    public function saveMerchantPaypalAction(){
        /**
         * Validate formkey
         */
        if (!$this->_validateFormKey()) {
            Mage::getSingleton('customer/session')->addError('Invalid Formkey!');
            $this->_redirect('*/*/edit');
            return;
        }
        $paypalE=$this->getRequest()->getPost('paypal_email');
        $customerId=$this->getRequest()->getPost('customerid');
        if ($paypalE && $customerId) {
            $customer= Mage::getModel('customer/customer')->load($customerId);

            $customer->setData('paypalemail',$paypalE)->save();
            Mage::getSingleton('customer/session')->addSuccess('Your Paypal Email has been updated!');
        }
        $this->_redirect('*/*/edit');
    }
}
