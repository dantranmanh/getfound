<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();


$installer->run("
	ALTER TABLE `{$installer->getTable('store/location_store')}` ADD `postal_code` int(11) NOT NULL default '0' ;
");



$installer->endSetup();