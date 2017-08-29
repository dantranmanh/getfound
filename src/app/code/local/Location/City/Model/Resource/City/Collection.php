<?php

class Location_City_Model_Resource_City_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        /*
         * 'Module_name/ resourcefile_name
         */
        $this->_init('city/city');
    }

}

