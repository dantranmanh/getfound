<?php
class Location_State_Block_Admin_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $stateId =  $row->getData('id');
        $stateImg = Mage::getModel('state/state')->load($stateId);
       // print_r($stateImg);exit;

       $pimage = $stateImg['state_image_name'];
       //$pimage1 = $this->resize_image($pimage,'80','80');
       // $pimage = Mage::helper('catalog/image')->init($pimage, 'thumbnail')->resize(80);
       //$url = Mage::getBaseUrl('media') . 'state_image/' . $pimage;
        $value = '<img src="">';
        if($pimage!= 'noselection')
        {
            $value='<img src="' . $pimage . '" width="80" height="80"/>';
        }
        return $value;

    }



}