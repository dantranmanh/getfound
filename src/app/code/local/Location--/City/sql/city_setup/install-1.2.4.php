<?php
//Mage::log('start', null, 'mysqlinstaller.log',true);
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('city/location'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('state_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
       'nullable'  => false,
    ), 'State ID')
    ->addColumn('city_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'City Name')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Position')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Status')
    ->addColumn('creation_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Updated At')
    ->setComment('City Table');

$installer->getConnection()->createTable($table);






