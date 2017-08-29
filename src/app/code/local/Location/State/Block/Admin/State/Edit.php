<?php
class Location_State_Block_Admin_State_Edit  extends Mage_Adminhtml_Block_Widget_Form_Container{

	public function __construct(){

		$this->_objectId = 'id';
		parent::__construct();
		$this->_blockGroup = "state";
		$this->_controller = "admin_state";
		$this->_mode = 'edit';
			
		
		$this->_headerText = $this->getHeaderText();
		
		$this->_updateButton('save', 'label', Mage::helper('state')->__('Save State'));
		
		$this->addButton('save_and_continue', array(
			'label' => Mage::helper('state')->__('Save and Continue'),
			'onclick' => 'saveandBack();',
			'class' => 'save'
		), 1);
		
		$this->_formScripts[] = '
		 function saveandBack(){
			editForm.submit($("edit_form").action + "back/edit")
		 }
		 ';
	}
	
	
	public function getHeaderText()
    {
        if (Mage::registry('state_model')) {
            return __('Edit State - ').$this->escapeHtml(Mage::registry('state_model')->getTitle());
        }
        else {
            return Mage::helper('state')->__('Add State');
        }
    }
	
	
	

}
?>