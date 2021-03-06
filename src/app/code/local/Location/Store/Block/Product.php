<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 21:23
 */

class Location_Store_Block_Product extends Mage_Catalog_Block_Product_List {
    protected $_cssPath = array();
    protected $_productCollection = null;
	protected $_cityStoreCollection = null;

    protected function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub
        $this->_cssPath[] = array('skin_css' => 'css/state/style.css');
        $this->setTemplate('location/store/product.phtml');
    }


    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $merchantStoreId = $this->getRequest()->getParam('id', 0); 
            $layer = $this->getLayer();
            $layer->getCurrentCategory()->setIsAnchor(1);
            $productCollection = $layer->getProductCollection();
            $productTable = Mage::getResourceModel('catalog/product')->getEntityTable();
            $productMerchantStoreAttribute = Mage::getResourceModel('catalog/product')->getAttribute('merchant_store');
            $productCollection->getSelect()->joinInner(
                array('merchant_store_tbl' => $productTable.'_'.$productMerchantStoreAttribute->getBackendType()),
                'merchant_store_tbl.entity_id = e.entity_id AND merchant_store_tbl.value IS NOT NULL AND merchant_store_tbl.attribute_id = '.
                $productMerchantStoreAttribute->getId(),
                array()
            );
            $productCollection->getSelect()->Where('merchant_store_tbl.value = '.$merchantStoreId);
            $this->_productCollection = $productCollection;
        }
        return $this->_productCollection;
    }
	
	
	public function getCityStoreCollection(){
        try {
            if (is_null($this->_cityStoreCollection)) {
                $merchantStoreId = $this->getRequest()->getParam('id', 0);
                $cityStoreCollection = Mage::getModel('store/store')->getCollection();
				
				$cityStoreCollection->addFieldToFilter(
                    'id',$merchantStoreId
                );

               
                $this->_cityStoreCollection = $cityStoreCollection;
            }

        } catch (Exception $e) {
            Mage::log($e, null, "storecity_execption.log");
        }
        return $this->_cityStoreCollection;
    }


    public function getCssJsHtml(){
        try{
            $cssJsHtml = '';
            if($this->_cssPath){
                foreach($this->_cssPath as $items){
                    foreach($items as $type => $path){
                        switch($type){
                            case 'skin_css':
                                $cssJsHtml = '<link rel="stylesheet" type="text/css" href="'.$this->getSkinUrl($path).'">';
                                break;
                        }
                    }
                }
            }
            return $cssJsHtml;
        } catch(Exception $e){
        }
    }

    public function getCityUrl($cityId = null) {
        return $this->getUrl('city/index/view', array('id'=>$cityId));
    }
}