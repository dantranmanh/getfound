<?php
//Mage::log('start', null, 'mysqlinstaller.log',true);
$installer = $this;
$installer->startSetup();
$installer->run("DROP TABLE IF EXISTS {$installer->getTable('merchant/payment_history')};");
$table = $installer->getConnection()
    ->newTable($installer->getTable('merchant/payment_history'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Order ID')
    ->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Order Item ID')
    ->addColumn('order_item_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Order Item Quantity')
    ->addColumn('ordered_item_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
    ), 'Ordered Item Price')
    ->addColumn('ordered_item_row_total', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
    ), 'Ordered Item Row Total')
    ->addColumn('payment_status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Payment Status')
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Comment')
    ->addColumn('creation_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Created At')
    ->setComment('Payment History Table');

$installer->getConnection()->createTable($table);






