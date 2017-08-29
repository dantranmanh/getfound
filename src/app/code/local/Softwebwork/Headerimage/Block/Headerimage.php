<?php 
class Softwebwork_Headerimage_Block_Headerimage extends Mage_Core_Block_Template
{
	public function getImagePath() {
		$isEnable = Mage::getStoreConfig('softwebwork_headerimage/general/enable');
		$currentMonth = Mage::getModel('core/date')->date('m');
		if($isEnable) {
			$model = Mage::getModel('softwebwork_headerimage/headerimage')->load($currentMonth, 'month_id');
			return $model->getPath();
		}
	}
	
	public function getWidth() {
		$width = Mage::getStoreConfig('softwebwork_headerimage/general/width');
		
		if($width) {
			return $width.'px';
		}
		return;
	}
	
	public function getHeight() {
		$height = Mage::getStoreConfig('softwebwork_headerimage/general/height');
		
		if($height) {
			return $height.'px';
		}
		return;
	}
}
?>