<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_Resource_Adaptivepayments_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('adaptivepayments/adaptivepayments');
    }
}