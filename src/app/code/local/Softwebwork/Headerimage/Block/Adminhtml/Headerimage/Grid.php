<?php
class Softwebwork_Headerimage_Block_Adminhtml_Headerimage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	 public function __construct()
    {
        parent::__construct();
      	$this->setDefaultSort('month_id');
		$this->setDefaultDir('ASC'); 
        $this->setId('softwebwork_headerimage_headerimage_grid');
		$this->setSaveParametersInSession(true);
		
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'softwebwork_headerimage/headerimage_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid
        $this->addColumn('id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id',
				'align' => 'center',
				'column_css_class'=>'no-display',
				'header_css_class'=>'no-display'
            )
        );
		$this->addColumn('month_id',
            array(
                'header'=> $this->__('Month Number'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'month_id',
				'align' => 'center',
				'column_css_class'=>'no-display',
				'header_css_class'=>'no-display'
            )
        );
		$this->addColumn('month_label',
            array(
                'header'=> $this->__('Month'),
                'align' =>'right',
                'width' => '50px',
				'align' => 'center',
                'index' => 'month_label'
            )
        );
		
        $this->addColumn('path', array(
          'header'    => Mage::helper('softwebwork_headerimage')->__('Header Image'),
          'align'     =>'left',
          'index'     => 'path',
		  'align' => 'center',
		  'frame_callback' => array($this, 'renderImage')
          //'renderer'  => 'Softwebwork_Headerimage/adminhtml_headerimage_renderer_image'
		));
		
		$this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
				'align' => 'center',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
        ));
         
        return parent::_prepareColumns();
    }
    protected function _prepareMassaction()
	{
			$this->setMassactionIdField('headerimage_id');
			$this->getMassactionBlock()->setFormFieldName('id');
	 
			$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('catalog')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        
			'confirm' => Mage::helper('tax')->__('Are you sure?')
			));
	 
	return $this;
	}
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
	
	public function renderImage($path)
    {
		$width = 70;
		$height = 70;
		return "<img src='".$path."' width=".$width." height=".$height."/>";
    }
}