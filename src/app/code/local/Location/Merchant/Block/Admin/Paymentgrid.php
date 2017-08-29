<?php


class Location_Merchant_Block_Admin_Paymentgrid extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    
    public function __construct()
    {
        $this->_controller = 'admin_paymentgrid';
        $this->_blockGroup = 'merchant';
        $this->_headerText = Mage::helper('merchant')->__('Merchant Payment');
        parent::__construct();
        $this->_removeButton('add');
    }

}