<?php

class Location_Store_Block_Admin_Store_Edit_Tab_Paypal extends Mage_Adminhtml_Block_Widget_Form{

    protected function _prepareForm(){
        
        $form  = new Varien_Data_Form ();
        $this->setForm($form);
        $fieldSet = $form->addFieldset('store_general_tab1', array('legend' => Mage::helper('store')->__('Paypal Information')));
        $fieldSet->addField(
            'paypal_information', 'text', array(
                'name' => 'paypal_information',
                'label' => Mage::helper('store')->__('Paypal Email Address'),
                'title' => Mage::helper('store')->__('Paypal Email Address'),
                'required' =>true
            )
        );

        if(Mage::registry('store_info')){
            $form->setValues(Mage::registry('store_info'));
        }
        
        return parent::_prepareForm();
    }
}