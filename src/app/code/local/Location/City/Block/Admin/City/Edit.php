<?php
class Location_City_Block_Admin_City_Edit  extends Mage_Adminhtml_Block_Widget_Form_Container{

	public function __construct(){

		$this->_objectId = 'id';
		parent::__construct();
		$this->_blockGroup = "city";
		$this->_controller = "admin_city";
		$this->_mode = 'edit';
			
		
		$this->_headerText = $this->getHeaderText();
		
		$this->_updateButton('save', 'label', Mage::helper('city')->__('Save City'));
		
		$this->addButton('save_and_continue', array(
			'label' => Mage::helper('city')->__('Save and Continue'),
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
        if (Mage::registry('city_model')) {
            return __('Edit City - ').$this->escapeHtml(Mage::registry('city_model')->getTitle());
        }
        else {
            return Mage::helper('city')->__('Add City');
        }
    }
	
	
	

}
?>