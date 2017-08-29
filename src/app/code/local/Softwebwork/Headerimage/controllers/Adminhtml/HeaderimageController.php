<?php 
class Softwebwork_Headerimage_Adminhtml_HeaderimageController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {  
            $this->_initAction()
            ->renderLayout();
    }   
	
	public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    } 
	public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('softwebwork_headerimage/headerimage');
     
        if ($id) {
            // Load record
            $model->load($id);
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This image  no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New'));
        Mage::register('softwebwork_headerimage', $model);
        $this->_initAction()
			->_addBreadcrumb($id ? $this->__('Edit') : $this->__('New'), $id ? $this->__('Edit') : $this->__('New Header Image'))
            ->_addContent($this->getLayout()->createBlock('softwebwork_headerimage/adminhtml_headerimage_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
			if(isset($_FILES['Image']['name']) and (file_exists($_FILES['Image']['tmp_name']))) {
				try {
					$uploader = new Varien_File_Uploader('Image');
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$uploader->setAllowCreateFolders(false);
					$path = Mage::getBaseDir('media') . DS . 'images'. DS . 'headerimage' . DS;
					$uploader->save($path, $_FILES['Image']['name']);
				  }catch(Exception $e) {
				  
				  }
		} else {      
	  
			if(isset($postData['Image']['delete']) && $postData['Image']['delete'] == 1)
				$postData['Image'] = '';
			else
				unset($postData['Image']);
		} 	
            $model = Mage::getSingleton('softwebwork_headerimage/headerimage');
			$path = Mage::getBaseUrl('media') . "images/headerimage/" . $_FILES['Image']['name'] ;
			$postData['path']  = $path;
			$monthLabel = $this->getMonthLabel($postData['month_id']);
			$headerImageData = $model->load($postData['month_id'], 'month_id');
			try {
				if(!empty($headerImageData->getData()) && ($headerImageData->getData() != '')) {
					$headerImageData->setPath($postData['path']);
					$headerImageData->setMonthLabel($monthLabel);
					$headerImageData->save();
				} else {
					$model->setPath($postData['path']);
					$model->setMonthLabel($monthLabel);
					$model->setMonthId($postData['month_id']);
					$model->save();
				}
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The Image has been saved.'));
                $this->_redirect('*/*/');
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this Image.'));
            }
             $this->_redirectReferer();
        }
    }
    public function massDeleteAction()
	{
		$Ids = $this->getRequest()->getParam('id');      
		if(!is_array($Ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tax')->__('Please select images.'));
		} else {
			try {
				$rateModel = Mage::getModel('softwebwork_headerimage/headerimage');
				foreach ($Ids as $Id) {
					$rateModel->load($Id)->delete();
				}
			Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('tax')->__(
				'Total of %d record(s) were deleted.', count($Ids)
				)
			);
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		
		} 
		$this->_redirect('*/*/index');
	}
	public function validateMonthEntry($postData, $model)
	{
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$writeConnection = $resource->getConnection('core_write');
		$table = $resource->getTableName('softwebwork_headerimage/headerimage');
		//echo $table ; exit;
		$query = 'SELECT id, month_id FROM ' . $table . ' WHERE month_id = '
             . $postData['month_id'] . ' LIMIT 1';
			 $data = $readConnection->fetchOne($query);
			// echo $data; exit;
		if(!empty($data) && $data != ''){
			
			$query = 'UPDATE ' . $table . ' SET path =  "'. $postData['path']  .'"  WHERE month_id = ' . $postData['month_id'];
          
		} else {
			$query = 'INSERT INTO '. $table .' (month_id, month_label , path) VALUES  ('. $postData['month_id']  . ' , "label" ,"' . $postData['path'] .'" )';
		}
		$writeConnection->query($query);
	}
    
	public function getMonthLabel($monthId) 
	{
		$monthLabel = array(1 => 'January', 
			2 => 'February' , 3 => 'March', 4 => 'April', 5 => 'May',
			6 => 'June',7 => 'July',8 => 'August',9 => 'September',
			10 => 'October',11 => 'November',12 => 'December' );
			return $monthLabel[$monthId];
	}
	
	public function messageAction()
    {
        $data = Mage::getModel('softwebwork_headerimage/headerimage')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
		
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('headerimage/softwebwork_headerimage_headerimage')
            ->_title($this->__('Headerimage'))->_title($this->__('Grid'))
            ->_addBreadcrumb($this->__('Headerimage'), $this->__('Grid'))
            ->_addBreadcrumb($this->__('Headerimage'), $this->__('Setting'));
        return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('headerimage/softwebwork_headerimage_headerimage');
    }
}
?>