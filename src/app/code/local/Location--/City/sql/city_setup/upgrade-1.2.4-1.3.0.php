<?php
//Mage::log('start', null, 'mysqlinstaller.log',true);

$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('city/location'),'alphabat_wise_city', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'after'     => city_name, // column name to insert new column after
        'comment'   => 'Title'
    ));
$installer->endSetup();






