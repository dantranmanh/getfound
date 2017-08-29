<?php
class Location_City_Block_Admin_City_Grid extends Mage_Adminhtml_Block_Widget_Grid{

     public function __construct() {
	 	parent::__construct();
		$this->setId('cityGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
        $this->setVarNameFilter('city_filter');
	 
	 }
	 
	 
	protected function _prepareCollection() {
		$cityCollection = Mage::getModel('city/city')->getCollection();
		$this->setCollection($cityCollection);
		parent::_prepareCollection();
		return $this;
	}
	
	 protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('city')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'id',
        ));
		
		$this->addColumn('state_id',
            array(
                'header'=> Mage::helper('city')->__('State Name'),
                'type'  => 'text',
                'index' => 'state_id',
                'renderer' => 'Location_City_Block_Admin_Renderer_Sname'
        ));

        $this->addColumn('city_name',
            array(
                'header'=> Mage::helper('city')->__('City Name'),
                'type'  => 'text',
                'index' => 'city_name',
            ));

        $this->addColumn('position',
            array(
                'header'=> Mage::helper('city')->__('Position'),
                'type' => 'text',
                'index' =>'position',
        ));
		

        $this->addColumn('status',
            array(
                'header'=> Mage::helper('city')->__('Status'),
                'type'  => 'text',
                'index' => 'status',
            ));
		
		$this->addColumn('action',
            array(
                'header'    => Mage::helper('city')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('city')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit'
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('city')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('city')->__('Excel XML'));
		return parent::_prepareColumns();
	
	}
	
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('city');

        $this->getMassactionBlock()->addItem('update', array(
             'label'=> Mage::helper('city')->__('Update'),
             'url'  => $this->getUrl('*/*/edit')
        ));
		
		 $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('city')->__('Delete'),
             'url'  => $this->getUrl('*/*/delete'),
             'confirm' => Mage::helper('city')->__('Are you sure to delete?')
        ));

        return $this;
    }

}
?>