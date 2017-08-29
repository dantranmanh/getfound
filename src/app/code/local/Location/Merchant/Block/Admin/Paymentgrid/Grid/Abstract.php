<?php


class Location_Merchant_Block_Admin_Payment_Grid_Abstract extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_resourceCollectionName  = '';
    protected $_currentCurrencyCode     = null;
    protected $_storeIds                = array();
    protected $_aggregatedColumns       = null;

    public function __construct()
    {
        parent::__construct();
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
        $this->setUseAjax(false);
        $this->setEmptyCellLabel(Mage::helper('reports')->__('No records found for this period.'));
    }

    public function getResourceCollectionName()
    {
        return $this->_resourceCollectionName;
    }

    public function getCollection()
    {
        if (is_null($this->_collection)) {
            $this->setCollection(Mage::getResourceModel($this->getResourceCollectionName()));
        }
        return $this->_collection;
    }

    protected function _prepareCollection()
    {
        $filterData = $this->getFilterData();
        $resourceCollection =  parent::_prepareCollection();

        if (count($filterData->getData())>0) {
        }

        return  $this->setCollection($resourceCollection);
    }
}