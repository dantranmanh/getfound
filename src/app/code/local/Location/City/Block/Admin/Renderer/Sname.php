<?php
class Location_City_Block_Admin_Renderer_Sname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $stateId =  $row->getData('state_id');
        $stateData = Mage::getModel('state/state')->load($stateId);
       
        $stateName = $stateData['state_name'];
        return $stateName;

    }



}