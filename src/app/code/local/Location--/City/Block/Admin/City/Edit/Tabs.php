<?php
class Location_City_Block_Admin_City_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{

   public function __construct(){
	
		parent::__construct();
		$this->setTitle('City List');
		$this->setId('city_general_detail');
		$this->setDestElementId('edit_form');

	}
	
	protected function _beforeToHtml(){
	
		$this->addTab('city_general_information', array(
						'label' => 'City List',
						'title' => 'City Informarion',
			            'content'   => $this->getLayout()->createBlock('city/admin_city_edit_tab_general')->toHtml(),

		));


		return parent::_beforeToHtml();
	}

}
?>