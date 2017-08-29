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
		//echo "here"; exit;
		//Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$product = Mage::getModel('catalog/product');
 

	   $product->setStoreId(1) //you can set data in store scope
    ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
    ->setAttributeSetId(4) //ID of a attribute set named 'default'
    ->setTypeId('simple') //product type
    ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
 
    ->setSku('testsku61') //SKU
    ->setName('test product21') //product name
    ->setWeight(4.0000)
    ->setStatus(1) //product status (1 - enabled, 2 - disabled)
    ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
    
 
    ->setPrice(11.22) //price in form 11.22
    ->setCost(22.33) //price in form 11.22
    ->setSpecialPrice(00.44) //special price in form 11.22
   
    ->setMsrpEnabled(1) //enable MAP
    ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
    ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
 
    ->setMetaTitle('test meta title 2')
    ->setMetaKeyword('test meta keyword 2')
    ->setMetaDescription('test meta description 2')
 
    ->setDescription('This is a long description')
    ->setShortDescription('This is a short description')
 
    //->setMediaGallery (array('images'=>array (), 'values'=>array ())) //media gallery initialization
    //->addImageToMediaGallery('media/catalog/product/1/0/10243-1.png', array('image','thumbnail','small_image'), false, false) //assigning image, thumb and small image to media gallery
 
    ->setStockData(array(
                       'use_config_manage_stock' => 0, //'Use config settings' checkbox
                       'manage_stock'=>1, //manage stock
                       'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
                       'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
                       'is_in_stock' => 1, //Stock Availability
                       'qty' => 999 //qty
                   )
    )
 
    ->setCategoryIds(array(2, 4)); //assign product to categories
	$product->save();
	echo $product->getId(); exit;
//endif;
	
        
        $this->_redirect('*/*/index');
}

    public function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
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
