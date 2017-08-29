<?php
class Location_City_Model_City extends Mage_Core_Model_Abstract{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;
	
	protected function _construct(){
		//echo "working"; exit;
		return $this->_init('city/city');
	}

	public function toOptionArray(){

		$optionArray = Array();

		$optionArray['0']= array(
			'label'=>'Enable',
			'value'=>'1'

		);
		$optionArray['1'] = array(
			'label'=>'Disable',
			'value'=>'0'
		);

		return $optionArray;

	}
	
}