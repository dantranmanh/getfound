<?php
/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 9/4/2016
 * Time: 7:06 PM
 */

class Location_Merchant_Block_Admin_Customer_Edit_Tab_Credit_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('merchant_credit_history');
        $this->setUseAjax(true);
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('merchant/admin_credit/grid', array('_current' => true));
    }

    /**
     * Prepare collection for grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $customerId = $this->getRequest()->getParam('id', 0);
        $collection = Mage::getModel('merchant/history')->getCollection();
        $collection->addFieldToFilter('merchant_id', $customerId);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('order_id', array(
            'header'            => Mage::helper('sales')->__('Order Id'),
            'index'             => 'order_id',
            'type'              => 'text'
        ));

        $this->addColumn('order_increment_id', array(
            'header'            => Mage::helper('sales')->__('Order Number'),
            'index'             => 'order_increment_id',
            'type'              => 'text'
        ));

        $this->addColumn('credit', array(
            'header'            => Mage::helper('sales')->__('Credit'),
            'index'             => 'credit',
            'type'              => 'text',
            'escape'            => true
        ));

        $this->addColumn('message', array(
            'header'            => Mage::helper('sales')->__('Message'),
            'index'             => 'message',
            'type'              => 'text',
            'escape'            => true
        ));
        return parent::_prepareColumns();
    }
}