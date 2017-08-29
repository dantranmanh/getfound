<?php
class Location_State_Block_Admin_State_Grid extends Mage_Adminhtml_Block_Widget_Grid{

     public function __construct() {
	 	parent::__construct();
		$this->setId('stateGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
        $this->setVarNameFilter('state_filter');
	 
	 }
	 
	 
	protected function _prepareCollection() {
		$stateCollection = Mage::getModel('state/state')->getCollection();
		$this->setCollection($stateCollection);
		parent::_prepareCollection();
		return $this;
	}
	
	 protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('state')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'id',
        ));
		
		$this->addColumn('state_name',
            array(
                'header'=> Mage::helper('state')->__('State Name'),
                'type'  => 'text',
                'index' => 'state_name',
        ));
		
		$this->addColumn('state_image_name',
            array(
                'header'=> Mage::helper('state')->__('Image'),
                'type'  => 'text',
                'index' => 'state_image_name',
                'renderer' => 'Location_State_Block_Admin_Renderer_Image',
        ));

        $this->addColumn('position',
            array(
                'header'=> Mage::helper('state')->__('Position'),
                'type' => 'text',
                'index' =>'position',
        ));
		

        $this->addColumn('status',
            array(
                'header'=> Mage::helper('state')->__('Status'),
                'type'  => 'text',
                'index' => 'status',
            ));
		
		$this->addColumn('action',
            array(
                'header'    => Mage::helper('state')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('state')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit'
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('state')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('state')->__('Excel XML'));
		return parent::_prepareColumns();
	
	}
	
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('state');

        $this->getMassactionBlock()->addItem('update', array(
             'label'=> Mage::helper('state')->__('Update'),
             'url'  => $this->getUrl('*/*/edit')
        ));
		
		 $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('state')->__('Delete'),
             'url'  => $this->getUrl('*/*/delete'),
             'confirm' => Mage::helper('state')->__('Are you sure to delete?')
        ));

        return $this;
    }

}
?>