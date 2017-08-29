<?php
require_once(Mage::getModuleDir('controllers','Location_Merchant').DS.'AccountController.php');
class Location_Merchant_StoreController extends Location_Merchant_AccountController
{
    /**
     * Default merchant account page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
        $this->renderLayout();
    }

    public function addAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $storeModel = Mage::getModel('store/store')->load($id);
        Mage::register('merchant_store', $storeModel);
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Edit Merchant Store'));
        $this->renderLayout();
    }
    public function cityAction()
    {
        $cityInfo = "<option value=''>Please Select</option>";
        $stateId = $this->getRequest()->getParam('state');
        $selectedCityId = $this->getRequest()->getParam('selected_city_id', 0);
        if ($stateId != '') {
            $cityCollection = Mage::getModel('city/city')->getCollection();
            $cityCollection->addFieldToFilter(
                'state_id', $stateId
            );
            $cityCollection->addFieldToFilter(
                'status', 1
            );
            $cityCollection->getSelect()->order('position ASC');
            if ($cityCollection->getData()) {
                foreach ($cityCollection as $city) {
                    $selectedText = '';
                    if ($selectedCityId == $city->getId()) {
                        $selectedText = 'selected="selected"';
                    }
                    $cityInfo .= "<option ".$selectedText." value='" . $city->getId() . "'>" . $city->getCityName() . "</option>";
                }
            }
        }
        echo $cityInfo;
    }

    public function saveAction()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $data = $this->getRequest()->getPost();
            $model = Mage::getModel('store/store')->load($id);
           // echo "****".$model->getImageOfStore();exit;
            $categories = '';
            if (isset($data['categories'])){
                $categories = implode(',',array_unique($data['categories']));
            }

            if(isset($id)){
                $data['id'] = $id;
                $data['image_of_store'] = $model->getImageOfStore();

            }else{
                $data['image_of_store'] = Mage::getBaseUrl('media').'store_image/'. $_FILES['image_of_store']['name'];
            }

            if(isset($_FILES['image_of_store']['name'])) {

                try {
                    //echo "@@@@@".$_FILES['image_of_store']['name'];exit;
                    $uploader = new Varien_File_Uploader('image_of_store');

                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything

                    $uploader->setAllowRenameFiles(false);

                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media').'/store_image/';

                    $uploader->save($path, $_FILES['image_of_store']['name']);

                    $data['image_of_store'] = Mage::getBaseUrl('media').'store_image/'. $_FILES['image_of_store']['name'];

                }catch(Exception $e) {

                }

            }

            $data['creation_at'] = date('Y-m-d h:s:i');
            $data['updated_at'] = date('Y-m-d h:s:i');
            $model->setData($data);
            $model->setCategories($categories);
            $model->setMerchantId(Mage::getSingleton('customer/session')->getCustomer()->getId());
            if($model->save()) {
                $this->_getSession()->addSuccess(
                    Mage::helper('merchant')->__('Store was successfully saved')
                );
                $this->_redirect('merchant/store/');
                return;
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/*', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_getSession()->addError(Mage::helper('store')->__('Unable to save Store'));
        $this->_redirect('*/*/*', array('id' => $this->getRequest()->getParam('id')));
    }
	
	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		 $model = Mage::getModel('store/store')->load($id);
		  if($model->delete()) {
                $this->_getSession()->addSuccess(
                    Mage::helper('merchant')->__('Store was successfully deleted')
                );
                $this->_redirect('merchant/store/');
                return;
            }
	}
}
