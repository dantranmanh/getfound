<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adminhtml_Adaptivepayments_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('adaptivepaymentsGrid');
      $this->setDefaultSort('adaptivepayments_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('adaptivepayments/adaptivepayments')->getCollection();
      $collection->getSelect()->join( array('al' => Mage::getSingleton('core/resource')->getTableName('location_adaptivepayments_log')),
      	'al.adaptivepayments_id = main_table.adaptivepayments_id', array('al.request', 'al.response'));

      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	  $storeId = (int) $this->getRequest()->getParam('store', 0);
  	  $store = Mage::app()->getStore($storeId);
      $this->addColumn('vendor_id', array(
          'header'    => Mage::helper('adaptivepayments')->__('Vendor Id'),
          'align'     =>'left',
          'index'     => 'vendor_id',
           'type'      => 'options',
           'options'=> Mage::helper('merchant')->getMerchantList(),
      ));

      $this->addColumn('transaction_id', array(
          'header'    => Mage::helper('adaptivepayments')->__('Transaction Id'),
          'align'     =>'right',
          'index'     => 'transaction_id',
      ));

      $this->addColumn('amount', array(
          'header'    => Mage::helper('adaptivepayments')->__('Amount'),
          'type'  => 'price',
          'currency_code' => $store->getBaseCurrency()->getCode(),
          'index'     => 'amount',
      ));

      $this->addColumn('request', array(
          'header'    => Mage::helper('adaptivepayments')->__('Request'),
          'align'     =>'left',
          'filter'    => false,
          'sortable'  => false,
          'index'     => 'request',
      ));

      $this->addColumn('response', array(
          'header'    => Mage::helper('adaptivepayments')->__('Response'),
          'align'     =>'left',
          'filter'    => false,
          'sortable'  => false,
          'index'     => 'response',
      ));

      $this->addColumn('trasaction_status', array(
          'header'    => Mage::helper('adaptivepayments')->__('Status'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'trasaction_status',
      	  'type'      => 'options',
          'options'   => array(
      		  'Failure' => Mage::helper('adaptivepayments')->__('ERROR'),
              'Pending' => Mage::helper('adaptivepayments')->__('PENDING'),
              'Completed' => Mage::helper('adaptivepayments')->__('COMPLETED'),
          ),
      ));

      $this->addColumn('created_time', array(
            'header'    => Mage::helper('customer')->__('Transaction Time'),
            'type'      => 'datetime',
            'align'     => 'center',
            'index'     => 'created_time',
            'gmtoffset' => true,
            'filter' =>false,
            'sortable'=>false
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('adaptivepayments')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('adaptivepayments')->__('XML'));

      return parent::_prepareColumns();
  }
}