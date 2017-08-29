<?php
//Mage::log('start', null, 'mysqlinstaller.log',true);
$installer =  new Mage_Catalog_Model_Resource_Setup();
$installer->removeAttribute(Mage_Catalog_Model_Product::ENTITY, 'number_of_credits');
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'number_of_credits', array(
    'group' => 'General',
    'type' => 'text',
    'attribute_set' =>  'Subscription', // Your custom Attribute set
    'backend' => '',
    'frontend' => '',
    'label' => 'Number Of Credits',
    'input' => 'text',
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
    'apply_to' => 'virtual',  // Apply to virtual product type
) );



$installer->endSetup();





