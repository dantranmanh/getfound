<?php
class Location_Merchant_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction(){
        //Mage::log('starting', null, 'controller.log', true);
        $this->loadLayout();

        $this->renderLayout();
    }
    public function viewAction(){
        //Mage::log('start', null, 'controller.log',true);
        $this->loadLayout();
        $this->renderLayout();
    }
    public function productAction(){
        Mage::log('product is coming', null, 'pcontroller.log',true);
        $this->loadLayout();
        $this->renderLayout();
    }

}