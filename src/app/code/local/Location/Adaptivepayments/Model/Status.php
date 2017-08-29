<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('adaptivepayments')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('adaptivepayments')->__('Disabled')
        );
    }
}