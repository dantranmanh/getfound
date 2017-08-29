<?php

class Location_Merchant_Block_Admin_Payment_Filter_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/viewed');
        $form = new Varien_Data_Form(
            array('id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get')
        );
        $htmlIdPrefix = 'merchant_report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('merchant')->__('Filter')));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('store_ids', 'hidden', array(
            'name'  => 'store_ids'
        ));

        $fieldset->addField('period_type', 'select', array(
            'name' => 'period_type',
            'options' => array(
                'month' => Mage::helper('merchant')->__('Month'),
                'year'  => Mage::helper('merchant')->__('Year')
            ),
            'label' => Mage::helper('merchant')->__('Period'),
            'title' => Mage::helper('merchant')->__('Period')
        ));

        $fieldset->addField('from', 'date', array(
            'name'      => 'from',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('merchant')->__('From'),
            'title'     => Mage::helper('merchant')->__('From'),
            'required'  => true
        ));

        $fieldset->addField('to', 'date', array(
            'name'      => 'to',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('merchant')->__('To'),
            'title'     => Mage::helper('merchant')->__('To'),
            'required'  => true
        ));
        $fieldset->addField('merchant_id', 'select', array(
            'name'      => 'merchant_id',
            'options'   => $this->_getVendorOption(),
            'label'     => Mage::helper('merchant')->__('Vendor Id'),
            'title'     => Mage::helper('merchant')->__('Vendor Id'),

        ));
        $payment_status = $fieldset->addField('payment_status', 'select', array(
            'name'      => 'payment_status',
            'options'   => array(
                'Complete' => Mage::helper('merchant')->__('Complete'),
                'Pending' => Mage::helper('merchant')->__('Pending')
            ),
            'label'     => Mage::helper('merchant')->__('Payment Status'),
            'title'     => Mage::helper('merchant')->__('Payment Status'),
            'onchange'  =>'checkPaymentProcess(this)',
        ));

        $payment_status->setAfterElementHtml(
          "<script type=\"text/javascript\">

            function checkPaymentProcess(selectElement){
                var form = $('gridViewedMerchantItem_massaction-form');

 var buttons = form.getInputs('button');

buttons.invoke('disable');
                if(selectElement.value == 'Pending') {
                   $('make_payment').enable();
                   $('make_payment').removeClassName('disabled');
                } else {
                    $('make_payment').disable();
                    $('make_payment').addClassName('disabled');
                }
            }
            function makePayment()
            {
               alert('asdasdasd');
            }
            </script>"
       );
        $form->setUseContainer(true);
        $this->setForm($form);

        if ($this->getFilterData()->getData()) {
          $form->setValues($this->getFilterData()->getData());
        }

        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFormData());
        }

        return parent::_prepareForm();
    }
    protected function _getMerchantOption()
    {
        $options=array();
        return $options;
    }
}
