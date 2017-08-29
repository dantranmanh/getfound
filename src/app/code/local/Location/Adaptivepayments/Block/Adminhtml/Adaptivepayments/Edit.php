<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adminhtml_Adaptivepayments_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'adaptivepayments';
        $this->_controller = 'adminhtml_adaptivepayments';

        $this->_updateButton('save', 'label', Mage::helper('adaptivepayments')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('adaptivepayments')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('adaptivepayments_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'adaptivepayments_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'adaptivepayments_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('adaptivepayments_data') && Mage::registry('adaptivepayments_data')->getId() ) {
            return Mage::helper('adaptivepayments')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('adaptivepayments_data')->getTitle()));
        } else {
            return Mage::helper('adaptivepayments')->__('Add Item');
        }
    }
}