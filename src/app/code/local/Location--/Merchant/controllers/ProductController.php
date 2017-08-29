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
                $magentoProductModel->setTypeId('simple');
                $magentoProductModel->setTaxClassId(2);
                $magentoProductModel->setDescription($productData['name']);
                $magentoProductModel->setShortDescription($productData['name']);
                $magentoProductModel->setAttributeSetId($defaultAttributeId);
                $magentoProductModel->save();
                //Price Assignment
                $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
                $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
                $allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
                $rates = Mage::getModel('directory/currency')->getCurrencyRates($baseCurrencyCode, array_values($allowedCurrencies));
                $price = $productData['price']/$rates[$currentCurrencyCode];
                $magentoProductModel->setPrice($price);
                $magentoProductModel->setWeight($productData['weight']);
                $stores = Mage::app()->getStore()->getStoreId();
                $magentoProductModel->setStoresIds(array($stores));
                $storeId = Mage::app()->getStore()->getId();
                $magentoProductModel->setWebsiteIds(array(Mage::getModel('core/store')->load($storeId)->getWebsiteId()));
                $magentoProductModel->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                $magentoProductModel->save();
                if(!is_dir(Mage::getBaseDir().'/media/vendor/')){
                    mkdir(Mage::getBaseDir().'/media/vendor/', 0755);
                }
                if(!is_dir(Mage::getBaseDir().'/media/vendor/'.$magentoProductModel->getId().'/')){
                    mkdir(Mage::getBaseDir().'/media/vendor/'.$magentoProductModel->getId().'/', 0755);
                }
                $target = Mage::getBaseDir().'/media/vendor/'.$magentoProductModel->getId().'/';
                if(isset($_FILES) && count($_FILES) > 0){
                    foreach($_FILES as $image ){
                        if($image['tmp_name'] != ''){
                            $splitname = explode('.', $image['name']);
                            $splitname[0] = str_replace('-', '', $splitname[0]);
                            $image_name = preg_replace('/[^A-Za-z0-9\-]/', '', $splitname[0]);
                            $target1 = $target.$image_name.".".$splitname[1];
                            move_uploaded_file($image['tmp_name'],$target1);
                        }
                    }
                }
                if($productData['defaultimage']){
                    $splitname = explode('.', $productData['defaultimage']);
                    if($splitname[1]){
                        $splitname[0] = str_replace('-', '', $splitname[0]);
                        $image_name = preg_replace('/[^A-Za-z0-9\-]/', '', $splitname[0]);
                        $wholedata['defaultimage'] = $image_name.".".$splitname[1];
                    }
                }
                $this->_addImages($magentoProductModel,$productData['defaultimage']);

                $this->_getSession()->addSuccess($this->__('Product with SKU '.$magentoProductModel->getSku().' has been created successfully'));
            }
        }catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/index');
            return;
        }
        $this->_redirect('*/*/index');
    }

    private function _addImages($product,$defaultimage){
        try {
            if ($product instanceof Mage_Catalog_Model_Product) {
                $mediDir = Mage::getBaseDir('media');
                $imagesdir = $mediDir . '/vendor/' . $product->getId() . '/';
                if(!file_exists($imagesdir)){return false;}
                foreach (new DirectoryIterator($imagesdir) as $fileInfo){
                    if($fileInfo->isDot() || $fileInfo->isDir()) continue;
                    if($fileInfo->isFile()){
                        $product->addImageToMediaGallery(
                            $fileInfo->getPathname(), array ('image','small_image','thumbnail'), true, false
                        );
                        $product->save();
                    }
                }
                $productMediaImages = $product->getMediaGalleryImages();
                if (strpos($defaultimage, '.') !== FALSE){
                    $defimage =  explode('.',$defaultimage);
                    $defimage[0] = str_replace('-', '_', $defimage[0]);
                    foreach ($productMediaImages as $value) {
                        $image = explode($defimage[0],$value->getFile());
                        if (strpos($value->getFile(), $defimage[0]) !== FALSE){
                            $newimage = $value->getFile();
                        }
                    }
                } else {
                    foreach ($productMediaImages as $value) {
                        if($value->getValueId()==$defaultimage){
                            $newimage = $value->getFile();
                        }
                    }
                }
                $product->setSmallImage($newimage);
                $product->setImage($newimage);
                $product->setThumbnail($newimage);
                $product->save();
            }

        } catch (Exception $e) {

        }

    }
}
