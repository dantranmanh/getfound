<?php
//Mage::log('start', null, 'mysqlinstaller.log',true);
$installer =  new Mage_Catalog_Model_Resource_Setup();
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'merchant_id', array(
    'group' => 'General',
    'type' => 'text',
    'attribute_set' =>  'Default', // Your custom Attribute set
    'backend' => '',
    'frontend' => '',
    'label' => 'Merchant Id',
    'input' => 'select',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
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

$installer = $this;
$installer->startSetup();

$customer_group = Mage::getModel('customer/group');
$customer_group->setCode("Merchant");
$customer_group->setTaxClassId(3);
$customer_group->save();

$installer->endSetup();





