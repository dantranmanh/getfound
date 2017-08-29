<?php
class Softwebwork_Headerimage_Block_Adminhtml_Headerimage_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('softwebwork_headerimage_headerimage_form');
        $this->setTitle($this->__('Header Image Information'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('softwebwork_headerimage');
     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
			'enctype'   => 'multipart/form-data'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('softwebwork_headerimage')->__('Header Image Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }  
		$fieldset->addField('path', 'image', array(
          'label'     => Mage::helper('softwebwork_headerimage')->__('Image for month'),
          'required'  => false,
		  'renderer' => 'softwebwork_headerimage/adminhtml_headerimage_renderer_image',
          'name'      => 'Image',
		)); 
     		
		$fieldset->addField('month_id', 'select', array(
          'label'     => Mage::helper('softwebwork_headerimage')->__('Month'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'month_id',
          'values' => array(
                              array(
                                  'value'     => -1,
                                  'label'     => 'Select Month..',
                              ),
							  
							  array(
                                  'value'     => 1,
                                  'label'     => 'January',
                              ),

                              array(
                                  'value'     => 2,
                                  'label'     => 'February',
                              ),
							  array(
                                  'value'     => 3,
                                  'label'     => 'March',
                              ),
							  array(
                                  'value'     => 4,
                                  'label'     => 'April',
                              ),
							  array(
                                  'value'     => 5,
                                  'label'     => 'May',
                              ),
							  array(
                                  'value'     => 6,
                                  'label'     => 'June',
                              ),
							  array(
                                  'value'     => 7,
                                  'label'     => 'July',
                              ),
							  array(
                                  'value'     => 8,
                                  'label'     => 'August',
                              ),
							  array(
                                  'value'     => 9,
                                  'label'     => 'September',
                              ),
							  array(
                                  'value'     => 10,
                                  'label'     => 'October',
                              ),
							  array(
                                  'value'     => 11,
                                  'label'     => 'November',
                              ),
							  array(
                                  'value'     => 12,
                                  'label'     => 'December',
                              ),
                            ), 
          'disabled' => false,
          'readonly' => false,
          'value'=> array(-1),
          'tabindex' => 1
        ));
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}
?>