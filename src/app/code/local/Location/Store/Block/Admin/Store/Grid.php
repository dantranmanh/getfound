<?php

/**
 * Created by PhpStorm.
 * User: sushil.zore
 * Date: 7/21/2016
 * Time: 7:38 PM
 */
class Location_Store_Block_Admin_Store_Grid extends Mage_Adminhtml_Block_Widget_Grid{

    public function __construct() {
        parent::__construct();
        $this->setId('storeGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setVarNameFilter('store_filter');

    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('store/store')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('store')->__('Id'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'id',
            ));

        $this->addColumn('store_name',
            array(
                'header'=> Mage::helper('store')->__('Store Name'),
                'type'  => 'text',
                'index' => 'store_name',
            ));
        $this->addColumn('merchant_id',
            array(
                'header'=> Mage::helper('store')->__('Merchant'),
                'index' => 'merchant_id',
                'type'      => 'options',
                'options'=> Mage::helper('merchant')->getMerchantOption(),
            ));
        $this->addColumn('state',
            array(
                'header'=> Mage::helper('store')->__('State'),
                'index' => 'state_id',
                'type'      => 'options',
                'options'=> Mage::helper('state')->getStateOptionList(),
            ));

        $this->addColumn('city',
            array(
                'header'=> Mage::helper('store')->__('City'),
                'index' => 'city_id',
                'type'      => 'options',
                'options'=> Mage::helper('city')->getCityOptionList(),
            ));
        $this->addColumn('position',
            array(
                'header'=> Mage::helper('store')->__('Position'),
                'type' => 'text',
                'index' =>'position',
            ));

        $this->addColumn('status',
            array(
                'header'=> Mage::helper('store')->__('Status'),
                'type'  => 'text',
                'index' => 'status',
                'type'      => 'options',
                'options'=>Mage::helper('store')->toOption()
            ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('store')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('store')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit'
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
            ));


        $this->addExportType('*/*/exportCsv', Mage::helper('store')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('store')->__('Excel XML'));
        return parent::_prepareColumns();

    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('store');

        $this->getMassactionBlock()->addItem('change_status', array(
            'label'=> Mage::helper('store')->__('Change Status'),
            'url'  => $this->getUrl('*/*/edit')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('store')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('state')->__('Are you sure to delete?')
        ));

        return $this;
    }

}