<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();


$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `phone` int(11) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `email_address` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `keyword` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `description` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `address` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `image_of_store` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `paypal_information` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_monday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_tuesday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_wednesday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_thursday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_friday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sutarday` VARCHAR(255) NOT NULL default '0' ;
");
$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sunday` VARCHAR(255) NOT NULL default '0' ;
");




$installer->endSetup();