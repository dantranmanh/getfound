<?php

$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
$installer->startSetup();
$installer->addAttribute(
    'quote_item', 'merchant_id',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);
$installer->addAttribute(
    'order_item', 'merchant_id',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);

$installer->endSetup();




