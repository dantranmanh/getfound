<?php
Mage::log('start', null, 'mysqlinstaller.log',true);
$installer = $this;
$installer->run("DROP TABLE IF EXISTS {$installer->getTable('merchant/credit_history')};");
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('merchant/credit_history'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('merchant_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'merchant ID')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Order ID')
    ->addColumn('order_increment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Order Increment Id')
    ->addColumn('credit', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Credit')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Message')
    ->addColumn('creation_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Created At')

    ->setComment('Merchant Credit History Table');

$installer->getConnection()->createTable($table);






