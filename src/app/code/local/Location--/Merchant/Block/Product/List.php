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
        $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
        $storeTableName = Mage::getSingleton('core/resource')->getTableName('store_info');
        $products->getSelect()->joinInner(
            array('store_table' => $storeTableName), 'store_table.id = e.merchant_store AND store_table.merchant_id = '.
            Mage::getSingleton('customer/session')->getCustomer()->getId(),array()
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
}