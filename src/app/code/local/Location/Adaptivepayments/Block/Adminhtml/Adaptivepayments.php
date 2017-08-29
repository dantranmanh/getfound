<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adminhtml_Adaptivepayments extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    parent::__construct();
    $this->_controller = 'adminhtml_adaptivepayments';
    $this->_blockGroup = 'adaptivepayments';
    $this->_headerText = Mage::helper('adaptivepayments')->__('Payments Request Log');
    $this->removeButton('add');
  }
}