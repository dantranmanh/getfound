<?php
class Softwebwork_Headerimage_Block_Adminhtml_Headerimage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {  
        $this->_blockGroup = 'softwebwork_headerimage';
        $this->_controller = 'adminhtml_headerimage';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_removeButton('delete');
		$this->_removeButton('reset');
		
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('softwebwork_headerimage')->getId()) {
            return $this->__('Edit');
        }  
        else {
            return $this->__('New');
        }  
    }   
}
?>