<?php
class Location_Merchant_Admin_PaymentgridController extends Mage_Adminhtml_Controller_Action {

    public function indexAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock(
                'merchant/admin_paymentgrid', 'paymentgrid_grid_container'
            )
        );
        $this->renderLayout();
    }

}