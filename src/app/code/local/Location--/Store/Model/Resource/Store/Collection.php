<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:29 PM
 */
class Location_Store_Model_Resource_Store_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct() {
        return $this->_init('store/store');
    }
}