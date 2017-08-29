<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 20:57
 */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
if($connection->tableColumnExists($installer->getTable('state/location'),'position')) {
   $installer->run("ALTER TABLE
   {$installer->getTable('state/location')} CHANGE `position` `position` INT(11) NOT NULL COMMENT 'Position'; ");
}
if($connection->tableColumnExists($installer->getTable('state/location'),'status')) {
   $installer->run("ALTER TABLE
   {$installer->getTable('state/location')} CHANGE `status` `status` INT(11) NOT NULL COMMENT 'Status'; ");
}

$installer->endSetup();


