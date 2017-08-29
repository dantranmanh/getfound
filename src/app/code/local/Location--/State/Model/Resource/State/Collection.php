<?php

class Location_State_Model_Resource_State_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        /*
         * 'Module_name/ Table_name
         */
        $this->_init('state/state');
    }

}

