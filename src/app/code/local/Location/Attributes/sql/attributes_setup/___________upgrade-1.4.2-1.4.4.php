<?php

$product = Mage::getModel('catalog/product');
Mage::log($product, null,'products.log',true);
$data = array(
    'attribute_set_id'  => 9,
    'type_id'      =>  'virtual',
    'store_id'   => 0,
    'category_ids' => array(4,5),
    'website_ids'  => array(0),
    'sku'    => 'sample-product',
    'name'    => 'Sample Product',
    'description'  => 'Sample Product',
    'short_description' => 'Sample Product',
    'status'   => 1,
    'visibility'  => 4,
    'weight'   => 1,
    'price'    => 100.00,
    'setcustomdefault' => 1,
    'tax_class_id'  => 0,

    'stock_data'  => array('is_in_stock' => 1,'qty' => 20),
    'created_at' =>    strtotime('now')
);
$product->addData($data)
    ->setInitialSetupFlag(true)
    ->save();
