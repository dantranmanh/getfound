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

	protected function _afterSave() {
		try {
			if ($this->getStatus()) {
				$targetPath = Mage::helper('city')->getCityUrl($this->getId());
				$idPath = 'city/'.$this->getId();
				$allStores = Mage::app()->getStores();
				foreach ($allStores as $storeId => $store) {
					$cityUrl = Mage::getModel('core/url_rewrite')->getCollection()
						->addFilter('id_path', $idPath)
						->addFieldToFilter('store_id', $storeId)
						->load()->getFirstItem();
					if ($cityUrl->getData()) {
						$cityUrl->setData('request_path', $this->getStateUrl());
						$cityUrl->setData('target_path', $targetPath);
					} else {
						$urlData =  array(
							'id_path'       => $idPath,
							'store_id'      => $storeId,
							'request_path'  => $this->getCityUrl(),
							'target_path'   => $targetPath,
							'is_system'     => '0',
							'description'   => 'City link',
						);
						$cityUrl->setData($urlData);
					}
					$cityUrl->save();
				}
			}


		} catch (Exception $e) {

		}
		parent::_afterSave();
	}

	protected function _afterDelete() {
		try {
			$idPath = 'city/'.$this->getId();
			$allStores = Mage::app()->getStores();
			foreach ($allStores as $storeId => $store) {
				$cityUrl = Mage::getModel('core/url_rewrite')->getCollection()
					->addFilter('id_path', $idPath)
					->addFieldToFilter('store_id', $storeId)
					->load()->getFirstItem();
				if ($cityUrl->getData()) {
					$cityUrl->delete();
				}
			}
		} catch (Exception $e) {

		}
		parent::_afterDelete();
	}
	
}