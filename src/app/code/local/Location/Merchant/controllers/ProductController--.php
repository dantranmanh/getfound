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
        $storeModel = Mage::getModel('store/store')->load($id);
        Mage::register('merchant_store', $storeModel);
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Edit Merchant Store'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            if($this->getRequest()->isPost()){
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
                $productData = $this->getRequest()->getParams();
                //echo "<pre>"; var_dump($productData); echo "</pre>";exit;
                //Mage::log($productData, null,'text.log',true); exit;
                $defaultAttributeId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
                $magentoProductModel = Mage::getModel('catalog/product');

                $magentoProductModel->setData($productData);
                $magentoProductModel->setAttributeSetId($defaultAttributeId);
                $magentoProductModel->setTypeId('simple');
                $magentoProductModel->setStatus(1);
                $magentoProductModel->setTaxClassId(4);
                $stores = Mage::app()->getStore()->getStoreId();
                $magentoProductModel->setStoresIds(array($stores));
                $storeId = Mage::app()->getStore()->getId();
                $magentoProductModel->setWebsiteIds(array(Mage::getModel('core/store')->load($storeId)->getWebsiteId()));
                $magentoProductModel->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED);
                $magentoProductModel->save();


            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/*', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_getSession()->addError(Mage::helper('store')->__('Unable to save product'));
        $this->_redirect('*/*/*', array('id' => $this->getRequest()->getParam('id')));
    }
}
