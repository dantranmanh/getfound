<?php
class Location_State_Helper_Data extends Mage_Core_Helper_Abstract{

    public function getStateOption() {
        $options = array();
        try {
            $stateCollection = Mage::getModel('state/state')->getCollection();

            $stateCollection->addFieldToFilter(
                'status', '1'
            );
            $stateCollection->getSelect()->order('position ASC');
            $options[] = array(
                'value' => '',
                'label' => 'Please Select State'
            );
            foreach ($stateCollection as $state) {
                $options[] = array(
                    'value' => $state->getId(),
                    'label' => $state->getStateName()
                );
            }

        } catch (Exception $e) {

        }
        return $options;
    }

    public function getStateOptionList() {
        $options = array();
        try {
            $stateCollection = Mage::getModel('state/state')->getCollection();
            $stateCollection->addFieldToFilter(
                'status', 1
            );
            $stateCollection->getSelect()->order('position ASC');
            foreach ($stateCollection as $state) {
                $options[$state->getId()] = $state->getStateName();
            }

        } catch (Exception $e) {

        }
        return $options;
    }

    public function getStateUrl($stateId = false)
    {
        if ($stateId) {
            return 'state/index/view/id/'.$stateId;
        }
    }
}
