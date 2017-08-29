<?php

//Mage::log('start', null, 'mysqlinstaller.log',true);
$installer =  new Mage_Catalog_Model_Resource_Setup();
$installer->removeAttribute(Mage_Catalog_Model_Product::ENTITY, 'merchant_store');
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'merchant_store', array(
    'group' => 'General',
    'type' => 'text',
    'attribute_set' =>  'Default', // Your custom Attribute set
    'backend' => '',
    'frontend' => '',
    'label' => 'Merchant Store',
    'input' => 'select',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'source' => 'merchant/entity_attribute_source_table_store',
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '1',
    'searchable' => false,
    'filterable' => true,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => true,
    'used_in_product_listing' => true,
    'unique' => false,
    'apply_to' => 'simple',  // Apply to simple product type
) );




$installer = new Mage_Customer_Model_Resource_Setup();
$installer->startSetup();
$installer->removeAttribute("customer", "merchant_credit");
$installer->addAttribute("customer", "merchant_credit",  array(
    "type"     => "varchar",
    "backend"  => "",
    "label"    => "Merchant Credit",
    "input"    => "text",
    "visible"  => true,
    "required" => false,
    "default" => "",
    "frontend" => "",
    "unique"     => false,
    "note"       => ""

));

$attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "merchant_credit");
$usedInForms = array("adminhtml_customer") ;
$attribute->setData("used_in_forms", $usedInForms)
    ->setData("is_used_for_customer_segment", true)
    ->setData("is_system", 0)
    ->setData("is_user_defined", 1)
    ->setData("is_visible", 1)
    ->setData("sort_order", 553);
$attribute->save();

$installer->endSetup();





