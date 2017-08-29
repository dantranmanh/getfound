<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/1/2016
 * Time: 7:09 PM
 */

class Location_Merchant_Block_Product_List extends Mage_Core_Block_Template{
    CONST ENABLE = 1;
    CONST DISABLE = 2;
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('merchant/product/list.phtml');
        Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
        $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
        $storeTableName = Mage::getSingleton('core/resource')->getTableName('store_info');
        $productTable = Mage::getResourceModel('catalog/product')->getEntityTable();
        $productMerchantStoreAttribute = Mage::getResourceModel('catalog/product')->getAttribute('merchant_store');
        $products->getSelect()->joinInner(
            array('merchant_store_tbl' => $productTable.'_'.$productMerchantStoreAttribute->getBackendType()),
            'merchant_store_tbl.entity_id = e.entity_id AND merchant_store_tbl.value IS NOT NULL AND merchant_store_tbl.attribute_id = '.
            $productMerchantStoreAttribute->getId(),
            array()
        );
        $products->getSelect()->joinInner(
            array('store_table' => $storeTableName), 'store_table.id = merchant_store_tbl.value AND store_table.merchant_id = '.
            Mage::getSingleton('customer/session')->getCustomer()->getId(),
            array('store_table.*')
        );
        $this->setProducts($products);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'merchant.products.history.pager')
            ->setCollection($this->getProducts());
        $this->setChild('pager', $pager);
        $this->getProducts()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    public function formatStatus($status) {
        if ($status == self::ENABLE) {
            return 'Enable';
        } else if ($status == self::DISABLE) {
            return 'Disable';
        }
    }

    public function getAddProductUrl() {
        return Mage::helper('merchant')->getAddProductUrl();
    }

    public function getEditUrl($storeId = null) {
        return Mage::getUrl('merchant/product/edit', array('id'=>$storeId));
    }
	
	 public function getDeleteUrl($storeId = null) {
        return Mage::getUrl('merchant/product/delete', array('id'=>$storeId));
    }
}