<?php
class Location_City_Helper_Data extends Mage_Core_Helper_Abstract{


    public function getStateName(){

       $stateCollection = Mage::getModel('state/state')->getCollection();
        $optionArray = array();
        $i= 0;
        $optionArray[-1] = array(
            'label'=> '-- Select --',
            'value'=> '0',
        );
        foreach($stateCollection as $state){
            $stateName = $state['state_name'];
            $stateID = $state['id'];
            $optionArray[$i] = array(
                'label'=> $stateName,
                'value'=> $stateID,
            );
            $i++;
        }
       // echo "<pre>"; var_dump($stateCollection); echo "</pre>";
       return $optionArray;
    }

    public function getCityOptionList() {
        $options = array();
        try {
            $cityCollection = Mage::getModel('city/city')->getCollection();
            $cityCollection->addFieldToFilter(
                'status', 1
            );
            $cityCollection->getSelect()->order('position ASC');
            foreach ($cityCollection as $city) {
                $options[$city->getId()] = $city->getCityName();
            }

        } catch (Exception $e) {

        }
        return $options;
    }
}
