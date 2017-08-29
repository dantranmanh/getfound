<?php


class Location_Merchant_Block_Admin_Payment extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    
    public function __construct()
    {
        $this->_controller = 'admin_payment';
        $this->_blockGroup = 'merchant';
        $this->_headerText = Mage::helper('merchant')->__('Merchant Payment');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('merchant')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
        
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/show', array('_current' => true));
    }

}