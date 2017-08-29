<?php 
class Softwebwork_Headerimage_Model_Mysql4_Headerimage extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        //parent::_construct();
        $this->_init('softwebwork_headerimage/headerimage','id');
    }
}
?>