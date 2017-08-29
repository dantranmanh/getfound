<?php
class Location_City_Block_Admin_City extends Mage_Adminhtml_Block_Widget_Grid_Container{

	  public function __construct()
    {

    	$this->_blockGroup = 'city'; // module name
		$this->_controller = 'admin_city'; //controller Name
        $this->_headerText = Mage::helper('city')->__('Manage City');
        $this->_addButtonLabel = Mage::helper('city')->__('Add New City');
        parent::__construct();
    }
	

}

?>