<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$connection = $installer->getConnection();
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'phone')) {
	$installer->run("
		ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `phone` int(11) NOT NULL default '0' ;
	");
}

if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'email_address')) {
	$installer->run("
		ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `email_address` VARCHAR(255) NOT NULL default '0' ;
	");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'keyword')) {
	$installer->run("
		ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `keyword` VARCHAR(255) NOT NULL default '0' ;
	");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'description')) {
	$installer->run("
		ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `description` VARCHAR(255) NOT NULL default '0' ;
	");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'address')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `address` VARCHAR(255) NOT NULL default '0' ;
");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'image_of_store')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `image_of_store` VARCHAR(255) NOT NULL default '0' ;
");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'paypal_information')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `paypal_information` VARCHAR(255) NOT NULL default '0' ;
");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_monday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_monday` VARCHAR(255) NOT NULL default '0' ;
");
}
if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_tuesday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_tuesday` VARCHAR(255) NOT NULL default '0' ;
");
}

if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_wednesday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_wednesday` VARCHAR(255) NOT NULL default '0' ;
");
}


if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_thursday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_thursday` VARCHAR(255) NOT NULL default '0' ;
");
}

if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_friday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_friday` VARCHAR(255) NOT NULL default '0' ;
");
}

if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_sutarday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sutarday` VARCHAR(255) NOT NULL default '0' ;
");
}

if(!$connection->tableColumnExists($installer->getTable('store/location_store'),'store_hour_sunday')) {
	$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `store_hour_sunday` VARCHAR(255) NOT NULL default '0' ;
");

}

$installer->endSetup();