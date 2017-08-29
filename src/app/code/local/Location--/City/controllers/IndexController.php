<?php

class Location_City_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * index action
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    protected function _initCity() {
        try {
            $cityId = $this->getRequest()->getParam('id');
            if (!Mage::registry('current_city') && $cityId) {
                $stateInfo = Mage::getModel('city/city')->load($cityId);
                Mage::register('current_city', $stateInfo);
            }

        } catch (Exception $e) {

        }
    }
    public function viewAction() {
        $this->_initCity();
        $this->loadLayout();
        $this->renderLayout();
    }

}