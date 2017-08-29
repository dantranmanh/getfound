<?php
class Location_State_Block_Admin_State extends Mage_Adminhtml_Block_Widget_Grid_Container{

	  public function __construct()
    {

    	$this->_blockGroup = 'state'; // module name
		$this->_controller = 'admin_state'; //controller Name
        $this->_headerText = Mage::helper('state')->__('Manage State');
        $this->_addButtonLabel = Mage::helper('state')->__('Add New State');
        parent::__construct();
    }
	

}

?>