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
        $apiname=$this->getRequest()->getPost('paypal_user');
        $apipass=$this->getRequest()->getPost('paypal_pass');
        $apis=$this->getRequest()->getPost('paypal_sign');
        if (!empty($paypalE) && !empty($customerId)) {
            $customer= Mage::getModel('customer/customer')->load($customerId);
            $customer->setData('paypalemail',$paypalE);
            if( !empty($apiname)) $customer->setData('apin',$apiname);
            if( !empty($apipass)) $customer->setData('apip',$apipass);
            if( !empty($apis)) $customer->setData('apis',$apis);
            $customer->save();
            Mage::getSingleton('customer/session')->addSuccess('Your Paypal Email has been updated!');
        }
        $this->_redirect('*/*/edit');
    }
}
