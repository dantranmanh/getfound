<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:28 PM
 */
class Location_Merchant_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct(){
        return $this->_init('merchant/credit_history','id');
    }
}