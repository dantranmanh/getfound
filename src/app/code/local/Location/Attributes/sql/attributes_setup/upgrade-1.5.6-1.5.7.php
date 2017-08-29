<?php
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');

$installer->startSetup();
$installer->addAttribute(
    'quote_item', 'cost_of_delivery',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);
$installer->addAttribute(
    'order_item', 'cost_of_delivery',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);

$installer->addAttribute(
    'quote_item', 'radius',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);
$installer->addAttribute(
    'order_item', 'radius',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);

$installer->endSetup();





