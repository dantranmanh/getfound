<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_url` VARCHAR(255) NOT NULL COMMENT 'store url' ;
");


$installer->endSetup();