<?php
class Location_Store_Admin_StoreController extends Mage_Adminhtml_Controller_Action {

    public function indexAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock(
                'store/admin_store', 'store_grid_container'
            )
        );
        $this->renderLayout();
    }
    public function newAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Add Store');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('store/admin_store_edit'));
        $this->_addLeft($this->getLayout()->createBlock('store/admin_store_edit_tabs'));
        $this->renderLayout();
    }


    public function editAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Edit Store');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $param = $this->getRequest()->getParam('id');
        try{
            if(isset($param)){
                $editStore = Mage::getModel('store/store')->load($param);
                $editStore->setHiddenCityId($editStore->getCityId());
                Mage::register('store_info', $editStore);
                $this->_addContent($this->getLayout()->createBlock('store/admin_store_edit'));
                $this->_addLeft($this->getLayout()->createBlock('store/admin_store_edit_tabs'));
            }
        }catch(Exception $e){

        }
        $this->renderLayout();
    }

    public function saveAction(){
        try {
            $id = $this->getRequest()->getParam('id');
            $data = $this->getRequest()->getPost();
            $model = Mage::getModel('store/store')->load($id);
            $categories = '';
            if (isset($data['category_ids'])){
                $categories = implode(',',array_unique(explode(',',$data['category_ids'])));
            }


            if(isset($id)){
                $data['id'] = $id;
                $data['image_of_store'] = $model->getImageOfStore();

            }else{
                $data['image_of_store'] = Mage::getBaseUrl('media').'store_image/'. $_FILES['image_of_store']['name'];
            }

            if(isset($_FILES['image_of_store']['name'])) {

                try {
                    //echo "@@@@@".$_FILES['image_of_store']['name'];
                    $uploader = new Varien_File_Uploader('image');

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
            if($model->save()) {
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('store')->__('Store was successfully saved')
                );
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('store')->__('Unable to save Store'));
        $this->_redirect('*/*/');
    }

    public function deleteAction(){
        try {
            $param = $this->getRequest()->getParam('id');
            if($param){
                $deleteEmp = Mage::getModel('store/store')->load($param)->delete();
                if($deleteEmp){
                    Mage::getModel('core/session')->addSuccess(Mage::helper('core')->__('Store has been deleted successfully.'));
                }
            }
            return $this->_redirect("*/*/index");

        } catch (Exception $e){

        }
    }

    public function massDeleteAction() {
        try {
            $ids = $this->getRequest()->getParam('store');
            $successCnt = 0;
            if (!empty($ids)) {
                foreach($ids as $id) {
                    if (Mage::getModel('store/store')->load($id)->delete()) {
                        $successCnt++;
                    }
                }
                if ($successCnt) {
                    $this->_getSession()->addSuccess(
                        'Store has been deleted successfully.'
                    );
                }
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        return $this->_redirectReferer();
    }

    public function exportCsvAction(){
        $fileName   = 'store-store.csv';
        $content    = $this->getLayout()->createBlock('store/admin_store_grid')
            ->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportExcelAction(){
        $fileName   = 'store-store.xls';
        $content    = $this->getLayout()->createBlock('store/admin_store_grid')
            ->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    protected function _initItem(){
        if (!Mage::registry('store_categories')){
            if ($this->getRequest()->getParam('id')){
                Mage::register('store_categories',
                    Mage::getModel('store/store')
                        ->load($this->getRequest()->getParam('id'))->getCategories());
            }
        }
    }
    public function categoriesAction(){
        $this->_initItem();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('store/admin_store_edit_tab_categories')->toHtml()
        );
    }
    public function categoriesJsonAction()
    {
        $this->_initItem();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('store/admin_store_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    public function stateAction()
    {
        $cityDropDown = "<option value=''>Please Select</option>";
        $stateId = $this->getRequest()->getParam('state');
        if ($stateId != '') {
            $cityCollection = Mage::getModel('city/city')->getCollection();
            $cityCollection->addFieldToFilter(
                'state_id', $stateId
            );
            $cityCollection->addFieldToFilter(
                'status', 1
            );
            $cityCollection->getSelect()->order('position ASC');
            if ($cityCollection->count()) {
                foreach ($cityCollection as $city) {
                    $cityDropDown .= "<option value='" . $city->getId() . "'>" . $city->getCityName() . "</option>";
                }
            }
        }
        echo $cityDropDown;
    }
}