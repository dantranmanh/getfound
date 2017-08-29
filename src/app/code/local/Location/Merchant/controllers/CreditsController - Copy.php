<?php

class Location_Merchant_CreditsController extends Mage_Core_Controller_Front_Action
{

    public function indexAction(){
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Manage Credits'));
        $this->renderLayout();
    }

    public function historyAction(){
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Credits History'));
        $this->renderLayout();
    }
}
