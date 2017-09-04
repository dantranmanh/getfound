<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');;
$installer->startSetup();


$installer->addAttribute("customer", "apin",  array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Merchant Paypal User Name',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'default' => '',
    'visible_on_front' => 1
    ));
$installer->addAttribute("customer", "apip",  array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Merchant Paypal Password',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'default' => '',
    'visible_on_front' => 1
));

$installer->addAttribute("customer", "apis",  array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Merchant Paypal Signiture',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'default' => '',
    'visible_on_front' => 1
));
$attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "apin");
$used_in_forms=array();
$used_in_forms[]="adminhtml_customer";

/**
 *
 * $used_in_forms[]="checkout_register";
$used_in_forms[]="customer_account_create";
$used_in_forms[]="customer_account_edit";
$used_in_forms[]="adminhtml_checkout";
 */
        $attribute->setData("used_in_forms", $used_in_forms)
        ->setData("is_used_for_customer_segment", true)
        ->setData("is_system", 0)
        ->setData("is_user_defined", 1)
        ->setData("is_visible", 1)
        ->setData("sort_order", 100)
        ;
$attribute->save();


$attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "apip");
$used_in_forms=array();
$used_in_forms[]="adminhtml_customer";

/**
 *
 * $used_in_forms[]="checkout_register";
$used_in_forms[]="customer_account_create";
$used_in_forms[]="customer_account_edit";
$used_in_forms[]="adminhtml_checkout";
 */
$attribute->setData("used_in_forms", $used_in_forms)
    ->setData("is_used_for_customer_segment", true)
    ->setData("is_system", 0)
    ->setData("is_user_defined", 1)
    ->setData("is_visible", 1)
    ->setData("sort_order", 100)
;
$attribute->save();


$attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "apis");
$used_in_forms=array();
$used_in_forms[]="adminhtml_customer";

/**
 *
 * $used_in_forms[]="checkout_register";
$used_in_forms[]="customer_account_create";
$used_in_forms[]="customer_account_edit";
$used_in_forms[]="adminhtml_checkout";
 */
$attribute->setData("used_in_forms", $used_in_forms)
    ->setData("is_used_for_customer_segment", true)
    ->setData("is_system", 0)
    ->setData("is_user_defined", 1)
    ->setData("is_visible", 1)
    ->setData("sort_order", 100)
;
$attribute->save();



$installer->endSetup();





