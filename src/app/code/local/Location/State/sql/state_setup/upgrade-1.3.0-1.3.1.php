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
if(!$connection->tableColumnExists($installer->getTable('state/location'),'state_url')) {
    $installer->run("ALTER TABLE
    {$installer->getTable('state/location')} ADD COLUMN `state_url` TEXT NOT NULL COMMENT 'state url'; ");
}




