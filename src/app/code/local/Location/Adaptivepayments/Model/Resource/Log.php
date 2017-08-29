<?php

class Location_Adaptivepayments_Model_Resource_Log extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the log_id refers to the key field in your database table.
        $this->_init('adaptivepayments/log', 'log_id');
    }
}