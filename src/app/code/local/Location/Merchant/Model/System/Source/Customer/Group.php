<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/24/2016
 * Time: 9:03 PM
 */

class Location_Merchant_Model_System_Source_Customer_Group{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array(
            array(
                'value' => 0,
                'label' => 'Please Select Customer Group'
            )
        );
        $customerGroupCollection = $this->_getCustomerGroupCollection();
        if ($customerGroupCollection) {
            foreach ($customerGroupCollection as $customerGroup) {
                $options[] = array(
                    'value' => $customerGroup->getCustomerGroupId(),
                    'label' => $customerGroup->getCustomerGroupCode()
                );
            }
        }
        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options = array(
            '0' => 'Please Select Customer Group'
        );
        $customerGroupCollection = $this->_getCustomerGroupCollection();
        if ($customerGroupCollection) {
            foreach ($customerGroupCollection as $customerGroup) {
                $options[$customerGroup->getCustomerGroupId()] = $customerGroup->getCustomerGroupCode();
            }
        }
        return $options;
    }

    protected function _getCustomerGroupCollection(){
        try {
            $customerGroupCollection = Mage::getModel('customer/group')->getCollection();
            $customerGroupCollection->addFieldToFilter('customer_group_id', array('gt' => 0));
            return $customerGroupCollection;
        } catch (Exception $e) {

        }
        return false;
    }

}