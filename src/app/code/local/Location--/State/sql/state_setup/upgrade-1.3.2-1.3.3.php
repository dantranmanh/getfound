<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 20:57
 */
Mage::log('start', null, 'mysqlinstaller.log',true);

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE 
 {$installer->getTable('state/location')} ADD COLUMN `state_url` TEXT NOT NULL COMMENT 'state url'; ");



