<?php 
class Location_City_Block_Admin_City_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form{



    protected function _prepareForm(){
		
		$form  = new Varien_Data_Form ();
		$this->setForm($form);
		$param = $this->getRequest()->getParam('id');
		$fieldSet = $form->addFieldset('city_general_tab', array('legend' => Mage::helper('city')->__('City Information')));
		
		$fieldSet->addField(
			'city_name', 'text', array(
				'name' => 'city_name',
				'label' => Mage::helper('city')->__('City Name'),
				'title' => Mage::helper('city')->__('City Name'),
				'required' =>true
			)
		);
		$fieldSet->addField(
			'state_id', 'select', array(
				'name' => 'state_id',
				'label' => Mage::helper('city')->__('State Name'),
				'title' => Mage::helper('city')->__('State Name'),
				'values' => Mage::helper('city')->getStateName(),
			)
		);

		$fieldSet->addField(
			'position', 'text', array(
				'name' => 'position',
				'label' => Mage::helper('city')->__('Position'),
				'title' => Mage::helper('city')->__('Position')

			)
		);
		$fieldSet->addField(
			'status', 'select', array(
				'name' => 'status',
				'label' => Mage::helper('city')->__('Status'),
				'title' => Mage::helper('city')->__('Status'),
				'values'    => Mage::getModel('city/city')->toOptionArray()

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
		if(Mage::registry('city_model')){
			$form->setValues(Mage::registry('city_model'));
		}

		return parent::_prepareForm();
		}
}
?>