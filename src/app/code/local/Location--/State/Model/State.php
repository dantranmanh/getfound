<?php
class Location_State_Model_State extends Mage_Core_Model_Abstract{

    protected function _construct(){
        //echo "working"; exit;
        return $this->_init('state/state');
    }

    public function toOptionArray(){
        $optionArray = Array(
            0 => array(
                'label'=>'Enable',
                'value'=>'1'
            ),
            1 => array(
                'label'=>'Disable',
                'value'=>'2'
            )
        );
        return $optionArray;
    }

    protected function _afterSave() {
        try {
            if ($this->getStatus()) {
                $targetPath = Mage::helper('state')->getStateUrl($this->getId());
                $idPath = 'state/'.$this->getId();
                $allStores = Mage::app()->getStores();
                foreach ($allStores as $storeId => $store) {
                    $stateUrl = Mage::getModel('core/url_rewrite')->getCollection()
                        ->addFilter('id_path', $idPath)
                        ->addFieldToFilter('store_id', $storeId)
                        ->load()->getFirstItem();
                    if ($stateUrl->getData()) {
                        $stateUrl->setData('request_path', $this->getStateUrl());
                        $stateUrl->setData('target_path', $targetPath);
                    } else {
                        $urlData =  array(
                            'id_path'       => $idPath,
                            'store_id'      => $storeId,
                            'request_path'  => $this->getStateUrl(),
                            'target_path'   => $targetPath,
                            'is_system'     => '0',
                            'description'   => 'State link',
                        );
                        $stateUrl->setData($urlData);
                    }
                    $stateUrl->save();
                }
            }


        } catch (Exception $e) {

        }
        parent::_afterSave();
    }

    protected function _afterDelete() {
        try {
            $idPath = 'state/'.$this->getId();
            $allStores = Mage::app()->getStores();
            foreach ($allStores as $storeId => $store) {
                $stateUrl = Mage::getModel('core/url_rewrite')->getCollection()
                    ->addFilter('id_path', $idPath)
                    ->addFieldToFilter('store_id', $storeId)
                    ->load()->getFirstItem();
                if ($stateUrl->getData()) {
                    $stateUrl->delete();
                }
            }
        } catch (Exception $e) {

        }
        parent::_afterDelete();
    }
}