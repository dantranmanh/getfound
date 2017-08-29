<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 8/29/2016
 * Time: 12:31 PM
 */
class Location_Merchant_Model_Entity_Attribute_Backend_Merchant_Store extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Prepare data for save
     *
     * @param Varien_Object $object
     * @return Mage_Eav_Model_Entity_Attribute_Backend_Abstract
     */
    public function beforeSave($object)
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $data = $object->getData($attributeCode);
        if ($data) {
            $object->setData($attributeCode, $data);
        }
        return parent::beforeSave($object);
    }
}