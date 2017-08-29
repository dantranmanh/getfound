<?php
class Location_City_Block_Admin_City_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{

	 protected function _prepareForm()
    {
        //for creating form we have to create object of varian and pass the parameter for form
		$form  = new Varien_Data_Form (
			array(
				'id' => 'edit_form', // id would be anything
				'action' =>  $this->getData('action'),
				'method'=>'post',
				'enctype' =>'multipart/form-data'
				
			));
			
			$form->setUseContainer(true);
			$this->setForm($form);
			return parent::_prepareForm();		
		
		
    }
}
?>