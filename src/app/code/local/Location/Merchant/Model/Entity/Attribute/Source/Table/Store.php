<?php

class Location_Merchant_Model_Entity_Attribute_Source_Table_Store
extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    public function getAllOptions(){

        try {
            if (is_null($this->_options)) {
                $this->_options[] = array(
                    'label' => '-- Select --',
                    'value' => -1
                );
                $storeCollection = Mage::getModel('store/store')->getCollection();
                foreach ($storeCollection as $store) {
                    $this->_options[] = array(
                        'label' => $store->getStoreName(),
                        'value' => $store->getId()
                    );
                }
            }
            return $this->_options;
        } catch (Exception $e) {

        }
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }

        return false;
    }

}