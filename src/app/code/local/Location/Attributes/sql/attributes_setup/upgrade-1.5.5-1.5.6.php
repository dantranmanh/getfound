<?php
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');

$installer->startSetup();

$installer->addAttribute(
    'shipment_item', 'merchant_store',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);
$installer->addAttribute(
    'invoice_item', 'merchant_store',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);

$installer->endSetup();





