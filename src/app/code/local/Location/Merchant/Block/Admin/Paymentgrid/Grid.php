<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:38 PM
 */
class Location_Merchant_Block_Admin_Paymentgrid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('storeGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setVarNameFilter('store_filter');

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sales/order_payment')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('method', "paypal_express");
        foreach ($collection as $item) {
            $addition = $item->getData('additional_information');
            $orderId = $item->getEntityId();echo $orderId;
            $merchantEmail = '';
            $merchant = Mage::getModel('merchant/history')->getCollection()->addFieldToFilter('order_id', array('eq' => $orderId))->getFirstItem();
            if (!empty($merchant)) {
                $merchantEmail = Mage::getModel('customer/customer')->load($merchant->getMerchantId())->getData('email');
            }
            $item->setData('merchantemail', $merchantEmail);

            $item->setData('total', $item->getData('base_amount_paid'));
            $item->setData('payerid', $addition['paypal_payer_id']);
            $item->setData('payeremail', $addition['paypal_payer_email']);
            $item->setData('payerstatus', $addition['paypal_payer_status']);
            $item->setData('addressstatus', $addition['paypal_address_status']);
            $item->setData('paymentstatus', $addition['paypal_payment_status']);
        }
        //Zend_Debug::dump(Mage::getModel('merchant/history')->getCollection()->getData());
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('store')->__('Order Id'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            ));
        $this->addColumn('merchantemail',
            array(
                'header' => Mage::helper('store')->__('Merchant Email'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'merchantemail',
            ));

        $this->addColumn('total',
            array(
                'header' => Mage::helper('store')->__('Total Paid'),
                'type' => 'text',
                'index' => 'total',
            ));
        $this->addColumn('payerid',
            array(
                'header' => Mage::helper('store')->__('Payer Id'),
                'type' => 'text',
                'index' => 'payerid',
            ));
        $this->addColumn('payeremail',
            array(
                'header' => Mage::helper('store')->__('Payer email'),
                'type' => 'text',
                'index' => 'payeremail',
            ));
        $this->addColumn('payerstatus',
            array(
                'header' => Mage::helper('store')->__('Payer Status'),
                'type' => 'text',
                'index' => 'payerstatus',
            ));
        $this->addColumn('addressstatus',
            array(
                'header' => Mage::helper('store')->__('Address Status'),
                'type' => 'text',
                'index' => 'addressstatus',
            ));
        $this->addColumn('paymentstatus',
            array(
                'header' => Mage::helper('store')->__('Payment Status'),
                'type' => 'text',
                'index' => 'paymentstatus',
            ));

        //$this->addExportType('*/*/exportCsv', Mage::helper('store')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('store')->__('Excel XML'));
        return parent::_prepareColumns();

    }
}