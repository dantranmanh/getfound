<?php
class Location_Attributes_Block_Catalog_Product_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes
{


    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = new Varien_Data_Form();
        Mage::log('block is working', null, 'block.log',true);exit;
        $merchant_store = $form->getElement('merchant_store');
        if ($merchant_store) {
            $merchant_store->setRenderer(
                $this->getLayout()->createBlock('Location_Attributes_Block_Admin_Catalog_Form_Renderer_Attribute_Merchant')
            );
        }
    }
}