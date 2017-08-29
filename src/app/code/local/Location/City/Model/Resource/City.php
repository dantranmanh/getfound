<?php
class Location_City_Model_Resource_City extends Mage_Core_Model_Resource_Db_Abstract{

	protected function _construct(){
		return $this->_init('city/location', 'id');
		
	}
	
}
