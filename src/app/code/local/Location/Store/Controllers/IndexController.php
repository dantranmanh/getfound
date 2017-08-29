<?php
class Location_Store_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction(){
        //Mage::log('start', null, 'controller.log',true);
        $this->loadLayout();
        $this->renderLayout();
    }

}