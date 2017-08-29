<?php

$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
$installer->startSetup();
$installer->addAttribute(
    'quote_item', 'total_num_of_credits',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);
$installer->addAttribute(
    'order_item', 'total_num_of_credits',
    array(
        'type' => 'int',
        'nullable' => false,
        'grid' => false,
    )
);

$installer->endSetup();




