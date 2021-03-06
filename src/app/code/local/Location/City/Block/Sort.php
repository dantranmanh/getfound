<?php
/**
 * Created by PhpStorm.
 * User: Pradip
 * Date: 29-07-2016
 * Time: 21:23
 */

class Location_City_Block_Sort extends Mage_Core_Block_Template{
    protected $_cssPath = array();
    protected $_cityCollection = null;
	protected $_alphaCityCollection = null;
	protected $_storeByIdCollection = null;
	protected $_storeByMerchantIdCollection = null;

    protected function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub
        $this->_cssPath[] = array('skin_css' => 'css/state/style.css');
        $this->setTemplate('location/city/sort.phtml');
    }

    public function getState(){
            $stateId = $this->getRequest()->getParam('id');
            if (!Mage::registry('current_state') && $stateId) {
                $stateInfo = Mage::getModel('state/state')->load($stateId);
                Mage::register('current_state', $stateInfo);
            }
            return Mage::registry('current_state');
    }
	
	public function getAlphabatCityCollection(){	
	    try{
		    if(is_null($this->_alphaCityCollection)){
			  $stateId = $this->getRequest()->getParam('id');
			  $alphabat = $this->getRequest()->getParam('filter');
			  $cityCollection = Mage::getModel('city/city')->getCollection();
			  $cityCollection->addFieldToFilter(
			     'state_id', $stateId
			  );
			  $cityCollection->addFieldToFilter(
			     'status', Location_City_Model_City::STATUS_ENABLE
			  );
			  $cityCollection->addFieldToFilter(
			    array('city_name'),
				array(
				  array('like' => $alphabat.'%')
				)
			  );
			  $cityCollection->getSelect()->order('position ASC');
			  $this->_alphaCityCollection = $cityCollection;
			
			}
		
		}catch(Exception $e){
		   Mage::log($e, null, "cityA_excetion.log");
		}
		
		return  $this->_alphaCityCollection;
	
	}
	
	public function getSelectedStoreByMerchant($cityId, $merchantId, $stateId){
	      try {
			    $storeByMerchantIdCollection = Mage::getModel('store/store')->getCollection();
			    $storeByMerchantIdCollection->addFieldToSelect('*');
			    $storeByMerchantIdCollection->addFieldToFilter('city_id', array('eq' => $cityId));
				 $storeByMerchantIdCollection->addFieldToFilter('state_id', array('eq' => $stateId));	
				$storeByMerchantIdCollection->addFieldToFilter('merchant_id', array('eq' => $merchantId));						
				$this->_storeByMerchantIdCollection = $storeByMerchantIdCollection->getData();
		 
		 } catch(Exception $e) {
     		  Mage::log($e, null, "store_exception1.log");
		 
		 }
		
	   return $this->_storeByMerchantIdCollection;
	}
	
	public function getSelectedStoreWithoutMerchant($cityId, $stateId){
	     try {
			    $storeByIdCollection = Mage::getModel('store/store')->getCollection();
			    $storeByIdCollection->addFieldToSelect('*');
			    $storeByIdCollection->addFieldToFilter('city_id', array('eq' => $cityId));
				 $storeByIdCollection->addFieldToFilter('state_id', array('eq' => $stateId));				
				//echo $storeByIdCollection->getSelect();	
				$this->_storeByIdCollection = $storeByIdCollection->getData();
		 
		 } catch(Exception $e) {
     		  Mage::log($e, null, "store_exception.log");
		 
		 }
		
	   return $this->_storeByIdCollection;
	}

    

    public function getCssJsHtml(){
        try{
            $cssJsHtml = '';
            if($this->_cssPath){
                foreach($this->_cssPath as $items){
                    foreach($items as $type => $path){
                        switch($type){
                            case 'skin_css':
                                $cssJsHtml = '<link rel="stylesheet" type="text/css" href="'.$this->getSkinUrl($path).'">';
                                break;
                        }
                    }
                }
            }
            return $cssJsHtml;
        } catch(Exception $e){
        }
    }

    public function getCityUrl($cityId = null) {
        return $this->getUrl('city/index/view', array('id'=>$cityId));
    }
	
	public function getnotactiveLink($cityurl) {
		 return $this->getUrl('city/index/notactive/', array('id'=>$cityurl));
	}
}