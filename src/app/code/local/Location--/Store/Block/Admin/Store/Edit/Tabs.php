<?php
class Location_Store_Block_Admin_Store_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{

    public function __construct(){

        parent::__construct();
        $this->setTitle('Store List');
        $this->setId('store_general_detail');
        $this->setDestElementId('edit_form');

    }
    protected function _beforeToHtml(){

        $this->addTab('store_general_information', array(
                        'label' => 'General Information',
                        'title' => 'General Information',
                        'content'   => $this->getLayout()->createBlock('store/admin_store_edit_tab_general')->toHtml(),
        ));

        $this->addTab('paypal_information', array(
            'label' => 'PayPal Information',
            'title' => 'PayPal Information',
            'content' => $this->getLayout()->createBlock('store/admin_store_edit_tab_paypal')->toHtml(),


        ));

        $this->addTab('store_schedule_information', array(
            'label' => 'Store Schedule Information',
            'title' => 'Store Schedule Information',
            'content' => $this->getLayout()->createBlock('store/admin_store_edit_tab_storeshedule')->toHtml(),
        ));
        $this->addTab('categories',array(
            'label' => Mage::helper('store')->__('Categories'),
            'url'   => $this->getUrl('*/*/categories', array('_current' => true)),
            'class' => 'ajax',
        ));

        return parent::_beforeToHtml();
    }

}