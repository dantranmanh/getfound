<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_monday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_tuesday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_wednesday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_thursday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_friday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sutarday1` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sunday1` VARCHAR(255) NOT NULL default '0' ;
");

$installer->endSetup();