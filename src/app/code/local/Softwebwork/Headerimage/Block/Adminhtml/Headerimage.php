<?php
class Softwebwork_Headerimage_Block_Adminhtml_Headerimage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
    {
        
        $this->_blockGroup = 'softwebwork_headerimage';
        $this->_controller = 'adminhtml_headerimage';
        $this->_headerText = $this->__('Header Image');
         
        parent::__construct();
		//$this->_removeButton('add');
    }
}
?>