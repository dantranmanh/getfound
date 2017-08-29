<?php
class Location_State_Admin_StateController extends Mage_Adminhtml_Controller_Action{


	public function indexAction(){
	
		$this->loadLayout();
		$this->getLayout()->getBlock('content')
		->append($this->getLayout()->createBlock('state/admin_state')->setTemplate('location/state.phtml'));
		
		$this->_addContent($this->getLayout()->createBlock('state/admin_state'));
		$this->renderLayout();
	}
	
	public function newAction(){

		$this->loadLayout();

		$this->getLayout()->getBlock('head')->setTitle('Add State');
			$this->_addContent($this->getLayout()->createBlock('state/admin_state_edit'));
			$this->_addLeft($this->getLayout()->createBlock('state/admin_state_edit_tabs'));


		$this->renderLayout();

	}


	public function editAction(){
		$this->loadLayout();

		$this->getLayout()->getBlock('head')->setTitle('Edit State');
		$param = $this->getRequest()->getParam('id');
		try{

			if(isset($param)){

				$editState = Mage::getModel('state/state')->load($param);
				Mage::register('state_model', $editState);

			$this->_addContent($this->getLayout()->createBlock('state/admin_state_edit'));
			$this->_addLeft($this->getLayout()->createBlock('state/admin_state_edit_tabs'));

			}
		}catch(Exception $e){

		}

		$this->renderLayout();
	}

	public function saveAction(){

		$param = $this->getRequest()->getParam('id');
		$data   = $this->getRequest()->getPost();

		$editBanner = Mage::getModel('state/state')->load($param);
		if(isset($param)){
			$data['id'] = $param;
			$data['state_image_name'] = $editBanner->getImage();

		}else{
		$data['state_image_name'] = $_FILES['state_image_name']['name'];
		}
		if(isset($_FILES['state_image_name']['name'])) {

			try {

				$uploader = new Varien_File_Uploader('state_image_name');

				$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything

			 	$uploader->setAllowRenameFiles(false);

			 	$uploader->setFilesDispersion(false);

			  	$path = Mage::getBaseDir('media') . DS . 'state' . DS . 'state_image' . DS;
				
			 	$uploader->save($path, $_FILES['state_image_name']['name']);

				$data['state_image_name'] = Mage::getBaseUrl('media').'state/state_image/'. $_FILES['state_image_name']['name'];

			  }catch(Exception $e) {

			}

		}

		//echo "<pre>"; print_r($data);  echo "</pre>"; exit;
		$data['creation_at'] = date('Y-m-d h:s:i');
		$data['updated_at'] = date('Y-m-d h:s:i');

		$model = Mage::getModel('state/state')->setData($data);
		
	   if($model->save()) {

	    if($param){

		Mage::getModel('adminhtml/session')->addSuccess(Mage::helper('core')->__('State has been updated successfully.'));
	  	 return $this->_redirect("*/*/edit/id/{$param}");
		}else{

		Mage::getModel('adminhtml/session')->addSuccess(Mage::helper('core')->__('State has been Added successfully.'));
	  	 return $this->_redirect("*/*/index");
		}
		}

	}

	public function deleteAction(){
	try {

	      $param = $this->getRequest()->getParam('id');
		if($param){
	      $deleteEmp = Mage::getModel('state/state')->load($param)->delete();

		if($deleteEmp){
          Mage::getModel('core/session')->addSuccess(Mage::helper('core')->__('State has been deleted successfully.'));
		}
		   }
	      return $this->_redirect("*/*/index");

	} catch (Exception $e){

	    }
	}

	public function exportCsvAction(){
		$fileName   = 'statelist.csv';
		$grid       = $this->getLayout()->createBlock('state/admin_state_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
	}

	public function exportExcelAction(){
		$fileName   = 'statelist.xls';
		$grid       = $this->getLayout()->createBlock('bs/admin_state_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
	}
}