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
		$magentoProductModel = Mage::getModel('catalog/product');
        try {
				if($this->getRequest()->isPost()){
					Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
					$productData = $this->getRequest()->getParams();
					if(!($productData['id'])) {
						$defaultAttributeId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
						$magentoProductModel->setData($productData);
						$magentoProductModel->setTypeId('simple');
						$magentoProductModel->setCreatedAt(strtotime('now'));
						$magentoProductModel->setTaxClassId(2);
						$magentoProductModel->setSku($productData['sku']);
						$magentoProductModel->setWeight($productData['weight']);
						$magentoProductModel->setStatus($productData['status']);
						$magentoProductModel->setDescription($productData['name']);
						$magentoProductModel->setShortDescription($productData['name']);
						$magentoProductModel->setAttributeSetId($defaultAttributeId);
						$magentoProductModel->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
						
						//Price Assignment
						$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
						$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
						$allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
						$rates = Mage::getModel('directory/currency')->getCurrencyRates($baseCurrencyCode, array_values($allowedCurrencies));
						$price = $productData['price']/$rates[$currentCurrencyCode];
						$magentoProductModel->setPrice($price);
						
						//$magentoProductModel->setWeight($productData['weight']);
						$stores = Mage::app()->getStore()->getStoreId();
						$magentoProductModel->setStoreId(1);//(array($stores));
						$storeId = Mage::app()->getStore()->getId();
						//$magentoProductModel->setWebsiteIds(array(Mage::getModel('core/store')->load($storeId)->getWebsiteId()));
						
						$magentoProductModel->setWebsiteIds(array(1));
						$magentoProductModel->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
						$magentoProductModel->setCategoryIds(array(2,19));
						$magentoProductModel->setStockData(array(
							   'use_config_manage_stock' => 0, //'Use config settings' checkbox
							   'manage_stock'=>1, //manage stock
							   'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
							   'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
							   'is_in_stock' => 1, //Stock Availability
							   'qty' => 999 //qty
						   )
						);
						
						
						
						$magentoProductModel->save();
						
						//$this->_addImages($magentoProductModel,$productData['defaultimage']);

						$this->_getSession()->addSuccess($this->__('Product with SKU '.$magentoProductModel->getSku().' has been created successfully'));
					} else {
						Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
						$magentoProductModel->load($productData['id']);
						$magentoProductModel->setSku($productData['sku']);
						$magentoProductModel->setWeight($productData['weight']);
						$magentoProductModel->setStatus($productData['status']);
						$magentoProductModel->setName($productData['name']);
						$magentoProductModel->setStockData(array(
							  'use_config_manage_stock' => 0, //'Use config settings' checkbox
							  'manage_stock'=>1, //manage stock
							  'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
							  'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
							  'is_in_stock' => $productData['stock_status'] //Stock Availability
							  
							 )
						  );
						  
					    $magentoProductModel->setRadius($productData['radius']);
					    $magentoProductModel->setCostOfDelivery($productData['cost_of_delivery']);
					    $magentoProductModel->setMetaKeyword($productData['meta_keyword']);
						
						$magentoProductModel->setDescription($productData['name']);
						$magentoProductModel->setShortDescription($productData['name']);
						$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
						$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
						$allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
						$rates = Mage::getModel('directory/currency')->getCurrencyRates($baseCurrencyCode, array_values($allowedCurrencies));
						$price = $productData['price']/$rates[$currentCurrencyCode];
						$magentoProductModel->setPrice($price);
						$magentoProductModel->setCategoryIds(array(2,19));
						
						$imageArray = $_FILES['images']['name']; 
						//print_r($imageArray); exit();
						
						$productID = $productData['id'];
						
						/*if(!is_dir(Mage::getBaseDir().'/media/vendor/'.$productID.'/')){
                            mkdir((Mage::getBaseDir().'/media/vendor/'.$productID).'/' , 0755);
                        }*/
						
						//$filepath = Mage::getBaseDir().'/media/vendor/'.$productID.'/';
						//$magentoProductModel->addImageToMediaGallery($filepath.'/'.$_FILES['images']['name'], array('image', 'thumbnail', 'small_image'), false, false);
						
						
						
						if(isset($imageArray)) {
						   foreach($imageArray as $key => $fileName){
								try {
								    
									

									
										/* Starting upload */
										$uploader = new Varien_File_Uploader(  array(
												'name' => $_FILES['images']['name'][$key],
												'type' => $_FILES['images']['type'][$key],
												'tmp_name' => $_FILES['images']['tmp_name'][$key],
												'error' => $_FILES['images']['error'][$key],
												'size' => $_FILES['images']['size'][$key]
													) );
								
										// Any extention would work
										$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
										$uploader->setAllowRenameFiles(false);
																				
										// Set the file upload mode
										// false -> get the file directly in the specified folder
										// true -> get the file in the product like folders
										// (file.jpg will go in something like /media/f/i/file.jpg)
										$uploader->setFilesDispersion(false);
										
										// We set media as the upload dir
										
										$filepath = Mage::getBaseDir('media') . DS . 'vendor' . DS . $productID . DS;
										
										$uploader->save($filepath, $_FILES['images']['name'][$key]);
										
									$filepathWithImage = Mage::getBaseDir('media') . DS . 'vendor' . DS . $productID . DS . $_FILES['images']['name'][$key];
									
								   
									if(file_exists($filepathWithImage)){									
											
											$magentoProductModel->setMediaGallery (array('images'=>array (), 'values'=>array ()))
												->addImageToMediaGallery(
													$filepathWithImage,
													array('image','small_image','thumbnail'),
													false,
													false
												);
									}
									
								
								} catch(Exception $e) {
								
								   }
								 }  
						}
						$magentoProductModel->save();
						$this->_getSession()->addSuccess($this->__('Product with SKU '.$magentoProductModel->getSku().' has been updated successfully'));
					}
				}
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				$this->_redirect('*/*/index');
				return;
			}
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
	
	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$model = Mage::getModel('catalog/product')->load($id);
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		  if($model->delete()) {
                $this->_getSession()->addSuccess(
                    Mage::helper('merchant')->__('Product was successfully deleted')
                );
               $this->_redirect('*/*/index');
                return;
            }
	}
}
