<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 20:57
 */
//Mage::log('start', null, 'mysqlinstaller.log',true);

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE 
 {$installer->getTable('city/location')} CHANGE `position` `position` INT(11) NOT NULL COMMENT 'Position'; ");

$installer->run("ALTER TABLE 
 {$installer->getTable('city/location')} CHANGE `status` `status` INT(11) NOT NULL COMMENT 'Status'; ");
$installer->endSetup();


