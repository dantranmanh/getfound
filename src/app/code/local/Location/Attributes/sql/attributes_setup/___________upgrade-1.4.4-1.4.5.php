<?php

//Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$product = Mage::getModel('catalog/product');
//    if(!$product->getIdBySku('testsku61')):


    Mage::log($product, null, 'product.log',true);

//    ->setStoreId(1) //you can set data in store scope
    $product->setWebsiteIds(array(1)); //website ID the product is assigned to, as an array
$product->setAttributeSetId(9); //ID of a attribute set named 'default'
$product->setTypeId('virtual'); //product type
$product->setCreatedAt(strtotime('now')); //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time

$product->setSku('credit_10'); //SKU
$product->setName('Credit 10'); //product name
$product->setWeight(4.0000);
$product->setStatus(1); //product status (1 - enabled, 2 - disabled)
$product->setTaxClassId(4); //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
$product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH); //catalog and search visibility
$product->setManufacturer(28); //manufacturer id



    $product->setPrice(4.90); //price in form 11.22
$product->setCost(4.90); //price in form 11.22

$product->setMetaTitle('test meta title 2');
$product->setMetaKeyword('test meta keyword 2');
$product->setMetaDescription('test meta description 2');

$product->setDescription('This is a long description');
$product->setShortDescription('This is a short description');

//$product->setMediaGallery (array('images'=>array (), 'values'=>array ())); //media gallery initialization
//$product->addImageToMediaGallery('media/store_image/IPF-9314_1_.jpg', array('image','thumbnail','small_image'), false, false); //assigning image, thumb and small image to media gallery

$product->setStockData(array(
'use_config_manage_stock' => 0, //'Use config settings' checkbox
'manage_stock'=>1, //manage stock
'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
'is_in_stock' => 1, //Stock Availability
'qty' => 999 //qty
)
);
$product->setCategoryIds(array(4, 5)); //assign product to categories
$product->save();
//endif;
