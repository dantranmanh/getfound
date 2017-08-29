<?php 
class Location_State_Block_Admin_State_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form{



    protected function _prepareForm(){
		
		$form  = new Varien_Data_Form ();
		$this->setForm($form);
		$param = $this->getRequest()->getParam('id');
		$fieldSet = $form->addFieldset('state_general_tab', array('legend' => Mage::helper('state')->__('State Information')));
		
		$fieldSet->addField(
			'state_name', 'text', array(
				'name' => 'state_name',
				'label' => Mage::helper('state')->__('State Name'),
				'title' => Mage::helper('state')->__('State Name'),
				'required' =>true
			)
		);
		$fieldSet->addField(
			'state_image_name', 'image', array(
				'name' => 'state_image_name',
				'label' => Mage::helper('state')->__('Image'),
				'title' => Mage::helper('state')->__('Image'),
				'required' =>true
			)
		);

		$fieldSet->addField(
			'position', 'text', array(
				'name' => 'position',
				'label' => Mage::helper('state')->__('Position'),
				'title' => Mage::helper('state')->__('Position')

			)
		);
		$fieldSet->addField(
			'status', 'select', array(
				'name' => 'status',
				'label' => Mage::helper('state')->__('Status'),
				'title' => Mage::helper('state')->__('Status'),
				'values'    => Mage::getModel('state/state')->toOptionArray()

			)
		);
		$fieldSet->addField(
			'state_url', 'text', array(
				'name' => 'state_url',
				'label' => Mage::helper('state')->__('State Url'),
				'title' => Mage::helper('state')->__('State Url')

			)
		);
		
		if(isset($param)){
		$fieldSet->addField(
			'id', 'hidden', array(
				'name' => 'id',
				'required' =>true
			)
		);
		}
		if(Mage::registry('state_model')){
			$form->setValues(Mage::registry('state_model'));
		}

		return parent::_prepareForm();
		}
}
?>