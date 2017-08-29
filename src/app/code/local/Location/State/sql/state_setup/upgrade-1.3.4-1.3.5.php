<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 20:57
 */
try {
    $idPath = 'state/list';
    $storeId = 1;
    $stateUrl = Mage::getModel('core/url_rewrite')->getCollection()
        ->addFilter('id_path', $idPath)
        ->addFieldToFilter('store_id', $storeId)
        ->load()->getFirstItem();
    if ($stateUrl->getData()) {
        $stateUrl->setData('request_path', '/');
        $stateUrl->setData('target_path', 'state/index/index');
    } else {
        $urlData =  array(
            'id_path'       => $idPath,
            'store_id'      => $storeId,
            'request_path'  => '/',
            'target_path'   => 'state/index/index',
            'is_system'     => '0',
            'description'   => 'State List link',
        );
        $stateUrl->setData($urlData);
    }
    $stateUrl->save();
} catch (Exception $e) {
    Mage::log($e, null, 'state.log', true);
}




