<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:26 PM
 */
class Location_Store_Model_Store extends Mage_Core_Model_Abstract
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;
    
    protected function _construct(){
        return $this->_init('store/store');
    }

    protected function _afterSave() {
        try {
            if ($this->getStatus()) {
                $targetPath = Mage::helper('store')->getStoreUrl($this->getId());
                $idPath = 'storeList/'.$this->getId();
                $allStores = Mage::app()->getStores();
                foreach ($allStores as $storeId => $store) {
                    $stateUrl = Mage::getModel('core/url_rewrite')->getCollection()
                        ->addFilter('id_path', $idPath)
                        ->addFieldToFilter('store_id', $storeId)
                        ->load()->getFirstItem();
                    if ($stateUrl->getData()) {
                        $stateUrl->setData('request_path', $this->getStoreUrl());
                        $stateUrl->setData('target_path', $targetPath);
                    } else {
                        $urlData =  array(
                            'id_path'       => $idPath,
                            'store_id'      => $storeId,
                            'request_path'  => $this->getStoreUrl(),
                            'target_path'   => $targetPath,
                            'is_system'     => '0',
                            'description'   => 'storeList link',
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
            $idPath = 'storeList/'.$this->getId();
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