<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:26 PM
 */
class Location_Merchant_Model_History extends Mage_Core_Model_Abstract
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;
    
    protected function _construct(){
        return $this->_init('merchant/history');
    }

}