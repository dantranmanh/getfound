<?php

class Location_Merchant_Block_Admin_Payment_Grid extends Location_Merchant_Block_Admin_Payment_Grid_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('gridViewedMerchantItem');
    }

    public function getResourceCollectionName()
    {
         return 'merchant/payment_collection';
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'month',
            array(
                'header'    =>Mage::helper('merchant')->__('Period'),
                'index'     =>'month',
                'sortable' => false
            )
        );

        $this->addColumn(
            'merchant_code',
            array(
                'header'    =>Mage::helper('merchant')->__('Merchant Code'),
                'index'     =>'merchant_code',
                'renderer'  => 'merchant/adminhtml_grid_renderer_hidden',
                'sortable' => false
            )
        );

        $this->addColumn(
            'name',
            array(
                'header'    =>Mage::helper('merchant')->__('Merchant Name'),
                'index'     =>'name',
                'sortable' => false
            )
        );

        $this->addColumn(
            'paypal_email',
            array(
                'header'    =>Mage::helper('merchant')->__('Paypal Email'),
                'index'     =>'paypal_email',
                'sortable' => false
            )
        );

        $this->addColumn(
            'email',
            array(
                'header'    =>Mage::helper('merchant')->__('Merchant Email'),
                'index'     =>'email',
                'sortable' => false
            )
        );

        $filterData = $this->getFilterData()->getData();
        if (isset($filterData['payment_status']) && ($filterData['payment_status']== 'Complete')) {

             $this->addColumn(
                 'payment_at',
                 array(
                    'header'    =>Mage::helper('merchant')->__('Payment Date'),
                    'index'     =>'payment_at',
                    'sortable'  => false,
                    'type'      => 'DATE'
                )
             );
             $amountTitle = Mage::helper('merchant')->__('Amount Paid');

        } else {
            $amountTitle = Mage::helper('merchant')->__('Amount');
        }

        $this->addColumn(
            'totalsales',
            array(
                'header' => Mage::helper('merchant')->__('Total Sales'),
                'type'  => 'price',
                'currency_code' => (string)Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
                'sortable' => false,
                'index'  => 'totalsales'
            )
        );
        
        $this->addColumn(
            'amount',
            array(
                'header'    => $amountTitle,
                'index'     =>'amount',
                'type'  => 'price',
                'currency_code' => (string)Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
                'sortable' => false
               )
        );

        if (isset($filterData['payment_status']) && ($filterData['payment_status']== 'Pending')) {
            $this->addColumn(
                'comment',
                array(
                    'header'    =>Mage::helper('reports')->__('Comment'),
                    'sortable'  =>false,
                    'type'   => 'text',
                    'filter'    => false,
                    'index'     =>'comment',
                    'renderer'  => 'merchant/adminhtml_grid_renderer_comment'
                )
            );
        } else {
            $this->addColumn(
                'comment',
                array(
                    'header' => Mage::helper('merchant')->__('Comment'),
                    'type'   => 'text',
                    'sortable' => false,
                    'index'  => 'comment',
                )
            );
        }

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $filterData = $this->getFilterData()->getData();
        if (isset($filterData['payment_status']) && ($filterData['payment_status']== 'Pending')) {
            $this->setMassactionIdField('merchant_id');
            $this->getMassactionBlock()->setFormFieldName('merchant-item');
            $this->getMassactionBlock()->addItem(
                'massPayment',
                array(
                    'label'    => Mage::helper('merchant')->__('Make Payment'),
                    'url'      => $this->getUrl('*/*/massPayment'),
                    'confirm'  => Mage::helper('merchant')->__(
                        'Are you sure to make payment to selected merchants?'
                    )
                )
            );
            $this->getMassactionBlock()->addItem(
                'manualPayment',
                array(
                    'label'    => Mage::helper('merchant')->__('Make Manual Payment'),
                    'url'      => $this->getUrl('*/*/manualPayment'),
                    'confirm'  => Mage::helper('merchant')->__(
                        'Are you sure to make payment to selected merchants manually?'
                    )
                )
            );
            Mage::getSingleton('adminhtml/session')->setPaymentFilter($filterData);
        }

        return $this;
    }
}
