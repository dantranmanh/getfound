<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
$installer->run("ALTER TABLE ".$installer->getTable('sales/order')." ADD `merchant_store` int(11) DEFAULT 0 ");
$installer->run("ALTER TABLE ".$installer->getTable('sales/quote')." ADD `merchant_store` int(11) DEFAULT 0 ");
$installer->endSetup();
