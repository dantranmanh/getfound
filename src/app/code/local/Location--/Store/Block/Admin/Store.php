<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:36 PM
 */
class Location_Store_Block_Admin_Store extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup = 'store';
        $this->_controller = 'admin_store';
        $this->_headerText = Mage::helper('store')->__('Manage Store');
        $this->_addButtonLabel = Mage::helper('store')->__('Add New Store');
        parent::__construct();
    }

}