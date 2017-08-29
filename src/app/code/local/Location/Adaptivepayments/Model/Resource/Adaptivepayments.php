<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_Resource_Adaptivepayments extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the adaptivepayments_id refers to the key field in your database table.
        $this->_init('adaptivepayments/adaptivepayments', 'adaptivepayments_id');
    }
}