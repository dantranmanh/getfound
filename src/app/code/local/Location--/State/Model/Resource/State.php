<?php
class Location_State_Model_Resource_State extends Mage_Core_Model_Resource_Db_Abstract{

	protected function _construct(){
		return $this->_init('state/location', 'id');
		
	}
	
}
