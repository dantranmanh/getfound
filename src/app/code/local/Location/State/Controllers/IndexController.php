<?php

class Location_State_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * index action
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction(){
        $this->loadLayout();
        $this->renderLayout();
}


}