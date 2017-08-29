<?php

class Location_Store_Block_Admin_Store_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form{

    protected function _prepareForm(){
        
        $form  = new Varien_Data_Form ();
        $this->setForm($form);
        $param = $this->getRequest()->getParam('id');
        $fieldSet = $form->addFieldset('store_general_tab', array('legend' => Mage::helper('store')->__('Store Information')));
        $fieldSet->addField(
            'store_name', 'text', array(
                'name' => 'store_name',
                'label' => Mage::helper('store')->__('Store Name'),
                'title' => Mage::helper('store')->__('Store Name'),
                'required' =>true
            )
        );
        $fieldSet->addField(
            'merchant_id', 'select', array(
                'name'  => 'merchant_id',
                'label'     => 'Merchant',
                'values'    => Mage::helper('merchant')->getMerchantList(),
                'required' =>true
            )
        );
        $fieldSet->addField(
            'hidden_city_id', 'hidden', array(
                'name'  => 'hidden_city_id',
                'label'     => 'City Id',
            )
        );
        $state = $fieldSet->addField(
            'state_id', 'select', array(
                'name'  => 'state_id',
                'label'     => 'State',
                'values'    => Mage::helper('state')->getStateOption(),
                'onchange' => 'getCity(this)',
                'id'=>'state'
            )
        );
        $fieldSet->addField(
            'city_id', 'select', array(
                'name'  => 'city_id',
                'label'     => 'City',
                
                'id'=>'city'
            )
        );

        $fieldSet->addField(
            'image_of_store', 'image', array(
                'name' => 'image_of_store',
                'label' => Mage::helper('store')->__('Image Of Store'),
                'title' => Mage::helper('store')->__('Image Of Store')

            )
        );

        $fieldSet->addField(
            'postal_code', 'text', array(
                'name' => 'postal_code',
                'label' => Mage::helper('store')->__('Postal Code'),
                'title' => Mage::helper('store')->__('Postal Code')

            )
        );

        $fieldSet->addField(
            'phone', 'text', array(
                'name' => 'phone',
                'label' => Mage::helper('store')->__('Phone'),
                'title' => Mage::helper('store')->__('Phone')

            )
        );

        $fieldSet->addField(
            'email_address', 'text', array(
                'name' => 'email_address',
                'label' => Mage::helper('store')->__('Email Address'),
                'title' => Mage::helper('store')->__('Email Address')

            )
        );
        $fieldSet->addField(
            'position', 'text', array(
                'name' => 'position',
                'label' => Mage::helper('store')->__('Position'),
                'title' => Mage::helper('store')->__('Position')

            )
        );

        $fieldSet->addField(
            'address', 'textarea', array(
                'name' => 'address',
                'label' => Mage::helper('store')->__('Address'),
                'title' => Mage::helper('store')->__('Address')

            )
        );

        $fieldSet->addField(
            'keyword', 'text', array(
                'name' => 'keyword',
                'label' => Mage::helper('store')->__('Keyword'),
                'title' => Mage::helper('store')->__('Keyword')

            )
        );

        $fieldSet->addField(
            'description', 'text', array(
                'name' => 'description',
                'label' => Mage::helper('store')->__('Description'),
                'title' => Mage::helper('store')->__('Description')

            )
        );
        $fieldSet->addField(
            'status', 'select', array(
                'name' => 'status',
                'label' => Mage::helper('store')->__('Status'),
                'title' => Mage::helper('store')->__('Status'),
                'values'    => Mage::helper('store')->toOptionArray()

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
        $state->setAfterElementHtml(
            "<script type=\"text/javascript\">

            function getCity(selectElement){
                var reloadurl = '".
            $this->getUrl('*/*/state') . "state/' + selectElement.value;
                new Ajax.Request(reloadurl, {
                    method: 'get',
                    onLoading: function (stateform) {
                    },
                    onComplete: function(stateform) {
                        if (stateform.responseText) {
                           $('city_id').update(stateform.responseText);
                           if ($('hidden_city_id').getValue()) {
                              $('city_id').value = $('hidden_city_id').getValue();
                           }
                        }
                        $('loading-mask').hide();
                    }
                });
            }
            document.observe('dom:loaded', function() {
              if ($('hidden_city_id').getValue()) {
                    getCity($('state_id'));
                  }
               });
            </script>"
        );
        if(Mage::registry('store_info')){
            $form->setValues(Mage::registry('store_info'));
        }
        return parent::_prepareForm();
    }
}