<?php

class Location_Store_Block_Admin_Store_Edit_Tab_StoreShedule extends Mage_Adminhtml_Block_Widget_Form{

    protected function _prepareForm(){
        
        $form  = new Varien_Data_Form ();
        $this->setForm($form);
        $fieldSet = $form->addFieldset('store_general_tab2', array('legend' => Mage::helper('store')->__('Store Schedule Information')));
        $fieldSet->addField(
            'store_hour_monday', 'select', array(
                'name' => 'store_hour_monday',
                'label' => Mage::helper('store')->__('Store Hour Monday'),
                'title' => Mage::helper('store')->__('Store Hour Monday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_monday1', 'select', array(
                'name' => 'store_hour_monday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()

            )
        );

        $fieldSet->addField(
            'store_hour_tuesday', 'select', array(
                'name' => 'store_hour_tuesday',
                'label' => Mage::helper('store')->__('Store Hour Tuesday'),
                'title' => Mage::helper('store')->__('Store Hour Tuesday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_tuesday1', 'select', array(
                'name' => 'store_hour_tuesday1' ,
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        $fieldSet->addField(
            'store_hour_wednesday', 'select', array(
                'name' => 'store_hour_wednesday',
                'label' => Mage::helper('store')->__('Store Hour Wednesday'),
                'title' => Mage::helper('store')->__('Store Hour Wednesday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_wednesday1', 'select', array(
                'name' => 'store_hour_wednesday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        $fieldSet->addField(
            'store_hour_thursday', 'select', array(
                'name' => 'store_hour_thursday',
                'label' => Mage::helper('store')->__('Store Hour Thursday'),
                'title' => Mage::helper('store')->__('Store Hour Thursday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_thursday1', 'select', array(
                'name' => 'store_hour_thursday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        $fieldSet->addField(
            'store_hour_friday', 'select', array(
                'name' => 'store_hour_friday',
                'label' => Mage::helper('store')->__('Store Hour Friday'),
                'title' => Mage::helper('store')->__('Store Hour Friday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_friday1', 'select', array(
                'name' => 'store_hour_friday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        $fieldSet->addField(
            'store_hour_sutarday', 'select', array(
                'name' => 'store_hour_sutarday',
                'label' => Mage::helper('store')->__('Store Hour Saturday'),
                'title' => Mage::helper('store')->__('Store Hour Saturday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_sutarday1', 'select', array(
                'name' => 'store_hour_sutarday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        $fieldSet->addField(
            'store_hour_sunday', 'select', array(
                'name' => 'store_hour_sunday',
                'label' => Mage::helper('store')->__('Store Hour Sunday'),
                'title' => Mage::helper('store')->__('Store Hour Sunday'),
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );
        $fieldSet->addField(
            'store_hour_sunday1', 'select', array(
                'name' => 'store_hour_sunday1',
                'required' =>true,
                'values' => Mage::helper('store')->toOptionSchedule()
            )
        );

        if(Mage::registry('store_info')){
            $form->setValues(Mage::registry('store_info'));
        }
        return parent::_prepareForm();
    }
}