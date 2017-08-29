<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adminhtml_Adaptivepayments_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('adaptivepayments_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('adaptivepayments')->__('Adaptive Payments Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('adaptivepayments')->__('Adaptive Payments Information'),
          'title'     => Mage::helper('adaptivepayments')->__('Adaptive Payments Information'),
          'content'   => $this->getLayout()->createBlock('adaptivepayments/adminhtml_adaptivepayments_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}