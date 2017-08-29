<?php
class Location_Store_Block_Admin_Store_Edit  extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct(){
        $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup = "store";
        $this->_controller = "admin_store";
        $this->_mode = 'edit';
        $this->_headerText = $this->getHeaderText();
        $this->_updateButton('save', 'label', Mage::helper('state')->__('Save Store'));
        $this->addButton('save_and_continue', array(
            'label' => Mage::helper('state')->__('Save and Continue'),
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
        if (Mage::registry('store_info')) {
            return ('Edit State - ').$this->escapeHtml(Mage::registry('store_info')->getTitle());
        }
        else {
            return Mage::helper('store')->__('Add Store');
        }
    }
}