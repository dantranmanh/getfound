<?php
class Location_Merchant_Admin_CreditController extends Mage_Adminhtml_Controller_Action {

    public function gridAction(){
        $this->loadLayout(false);
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('merchant/admin_customer_edit_tab_credit_history_grid')->toHtml()
        );
    }

}