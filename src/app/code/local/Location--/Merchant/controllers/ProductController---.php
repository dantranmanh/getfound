<?php
require_once(Mage::getModuleDir('controllers','Location_Merchant').DS.'AccountController.php');
class Location_Merchant_ProductController extends Location_Merchant_AccountController
{
    /**
     * Default merchant account page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Products'));
        $this->renderLayout();
    }

    public function addAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Add Product'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $storeModel = Mage::getModel('catalog/product')->load($id);
        //echo "<pre>"; var_dump($storeModel); echo "</pre>";
        Mage::register('merchant_product', $storeModel);
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Edit Product'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            if($this->getRequest()->isPost()){
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
                $productData = $this->getRequest()->getParams();
                $defaultAttributeId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
                $magentoProductModel = Mage::getModel('catalog/product');
                $magentoProductModel->setData($productData);
                $magentoProductModel->setAttributeSetId($defaultAttributeId);
                $magentoProductModel->save();
                $magentoProductModel->setTypeId('simple');
                $magentoProductModel->setStatus(1);
                $magentoProductModel->setTaxClassId(2);
                $stores = Mage::app()->getStore()->getStoreId();
                $magentoProductModel->setStoresIds(array($stores));
                $storeId = Mage::app()->getStore()->getId();
                $magentoProductModel->setWebsiteIds(array(Mage::getModel('core/store')->load($storeId)->getWebsiteId()));
                $magentoProductModel->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED);
                $magentoProductModel->save();
                $this->_getSession()->addSuccess($this->__('Product with SKU '.$magentoProductModel->getSku().' has been created successfully'));
            }
        }catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/index');
            return;
        }
        $this->_redirect('*/*/index');
    }
}
