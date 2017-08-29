<?php
class Location_City_Admin_CityController extends Mage_Adminhtml_Controller_Action{


	public function indexAction(){
	
		$this->loadLayout();
		$this->getLayout()->getBlock('content')
		->append($this->getLayout()->createBlock('city/admin_city')->setTemplate('location/city.phtml'));
		
		$this->_addContent($this->getLayout()->createBlock('city/admin_city'));
		$this->renderLayout();
	}
	
	public function newAction(){

		$this->loadLayout();

		$this->getLayout()->getBlock('head')->setTitle('Add City');
			$this->_addContent($this->getLayout()->createBlock('city/admin_city_edit'));
			$this->_addLeft($this->getLayout()->createBlock('city/admin_city_edit_tabs'));


		$this->renderLayout();

	}


	public function editAction(){
		$this->loadLayout();

		$this->getLayout()->getBlock('head')->setTitle('Edit City');
		$param = $this->getRequest()->getParam('id');
		try{

			if(isset($param)){

				$editState = Mage::getModel('city/city')->load($param);
				Mage::register('city_model', $editState);

			$this->_addContent($this->getLayout()->createBlock('city/admin_city_edit'));
			$this->_addLeft($this->getLayout()->createBlock('city/admin_city_edit_tabs'));

			}
		}catch(Exception $e){

		}

		$this->renderLayout();
	}

	public function saveAction(){

		$param = $this->getRequest()->getParam('id');
		$data   = $this->getRequest()->getPost();

		$editBanner = Mage::getModel('city/city')->load($param);
		if(isset($param)){
			$data['id'] = $param;


		}

		//echo "<pre>"; print_r($data);  echo "</pre>"; exit;
		$data['creation_at'] = date('Y-m-d h:s:i');
		$data['updated_at'] = date('Y-m-d h:s:i');

		$model = Mage::getModel('city/city')->setData($data);

	   if($model->save()) {

	    if($param){

		Mage::getModel('adminhtml/session')->addSuccess(Mage::helper('core')->__('City has been updated successfully.'));
	  	 return $this->_redirect("*/*/edit/id/{$param}");
		}else{

		Mage::getModel('adminhtml/session')->addSuccess(Mage::helper('core')->__('City has been Added successfully.'));
	  	 return $this->_redirect("*/*/index");
		}
		}

	}

	public function deleteAction(){

		try {

	      $param = $this->getRequest()->getParam('id');
		if($param){
	      $deleteEmp = Mage::getModel('city/city')->load($param)->delete();

		if($deleteEmp){
          Mage::getModel('core/session')->addSuccess(Mage::helper('core')->__('City has been deleted successfully.'));
		}
		   }
	      return $this->_redirect("*/*/index");

	} catch (Exception $e){

	    }
	}

	public function exportCsvAction(){
		$fileName   = 'citylist.csv';
		$grid       = $this->getLayout()->createBlock('city/admin_city_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
	}

	public function exportExcelAction(){
		$fileName   = 'citylist.xls';
		$grid       = $this->getLayout()->createBlock('city/admin_city_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
	}
}