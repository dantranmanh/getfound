<?php
class Location_State_Block_Admin_State_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{

   public function __construct(){
	
		parent::__construct();
		$this->setTitle('State List');
		$this->setId('state_general_detail');
		$this->setDestElementId('edit_form');

	}
	
	protected function _beforeToHtml(){
	
		$this->addTab('state_general_information', array(
						'label' => 'State List',
						'title' => 'State Informarion',
			            'content'   => $this->getLayout()->createBlock('state/admin_state_edit_tab_general')->toHtml(),

		));


		return parent::_beforeToHtml();
	}

}
?>