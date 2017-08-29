<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 9/4/2016
 * Time: 7:03 PM
 */
class Location_Merchant_Block_Admin_Customer_Edit_Tab_Credit_History
    extends Location_Merchant_Block_Admin_Customer_Edit_Tab_Credit_History_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Columns, that should be removed from grid
     *
     * @var array
     */
    protected $_columnsToRemove = array();

    /**
     * Disable filters and paging
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('merchant_credit_history');
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Merchant Credit History');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Merchant Credit History');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        $customer = Mage::registry('current_customer');
        if ((bool)$customer->getId()) {
            if (Mage::Helper('merchant')->getMerchantCustomerGroupId() == $customer->getGroupId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('merchant/admin_credit/grid', array('_current'=>true));
    }

    /**
     * Defines after which tab, this tab should be rendered
     *
     * @return string
     */
    public function getAfter()
    {
        return 'orders';
    }

    /**
     * Prepare collection for grid
     *
     * @return Mage_Sales_Block_Adminhtml_Customer_Edit_Tab_Agreement
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('merchant/history')->getCollection();
        $collection->addFieldToFilter('merchant_id', Mage::registry('current_customer')->getId());
        $collection->setOrder('creation_at');
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    /**
     * Remove some columns and make other not sortable
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $result = parent::_prepareColumns();

        foreach ($this->_columns as $key => $value) {
            if (in_array($key, $this->_columnsToRemove)) {
                unset($this->_columns[$key]);
            }
        }
        return $result;
    }
}
