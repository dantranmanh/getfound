<?php // exit;


class Location_City_CityController extends Mage_Core_Controller_Front_Action {

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