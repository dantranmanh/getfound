<?php
/**
 * Adaptive Payments Controller
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */

class Location_Adaptivepayments_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
        	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
                $this->setFlag('', 'no-dispatch', true);
            }
        }
		$this->loadLayout();
		$this->renderLayout();
    }

	public function selectAction()
    {
    	if ($data = $this->getRequest()->getPost()) {
    		$adaptivepayments = Mage::getModel('adaptivepayments/adaptivepayments');
    		if($adaptivepayments->validate($data)) {
	    		$this->loadLayout();
				$this->renderLayout();
    		} else {
    			Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('Invalid request, Please retry.'));
    			$this->_redirect('*/*/');
    		}
    	} else {
    		Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('Please select adaptivepayments amount and method first.'));
    		$this->_redirect('*/*/');
    	}
    }

	public function submitAction()
    {
    	if ($data = $this->getRequest()->getPost()) {
    		$adaptivepayments = Mage::getModel('adaptivepayments/adaptivepayments');
    		if($adaptivepayments->validate($data) and $adaptivepayments->adaptivepayments($data)) {
    			Mage::getSingleton('core/session')->addSuccess(Mage::helper('assets')->__('AdaptivePayments request received.'));
	    		$this->_redirect('*/*/thanks');
    		} else {
    			Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('AdaptivePayments Failed. Try Again'));
    			$this->_redirect('*/*/');
    		}
    	} else {
    		Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('Please select adaptivepayments amount and method first.'));
    		$this->_redirect('*/*/');
    	}
    }

	public function thanksAction()
    {
    	$this->loadLayout();
		$this->renderLayout();
    }

    public function returnpreapprovalAction()
    {
    	if ($id = $this->getRequest()->getParam('id'))  {
	    	$model  = Mage::getModel('adaptivepayments/preapproval')->load($id);
	    	$model->setStatus(Location_AdaptivePayments_Model_Status::STATUS_ENABLED);
	    	$model->setUpdateTime(now());
	    	$model->save();
	    	$this->loadLayout();
			$this->renderLayout();
    	} else {
    		Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('Bad Request'));
    		$this->_redirect('*/*/');
    	}
    }

	public function cancelpreapprovalAction()
    {
    	if ($id = $this->getRequest()->getParam('id'))  {
	    	$model  = Mage::getModel('adaptivepayments/preapproval')->load($id);
			$model->setPreapprovalStatus('CANCELLED');
	    	$model->setUpdateTime(now());
	    	$model->save();
	    	$this->loadLayout();
			$this->renderLayout();
    	} else {
    		Mage::getSingleton('core/session')->addError(Mage::helper('adaptivepayments')->__('Bad Request'));
    		$this->_redirect('*/*/');
    	}
    }

   /**
    * Action predispatch
    *
    * Check customer authentication for some actions
    */
    public function preDispatch()
    {
        // a brute-force protection here would be nice
        Mage::registry('sne_left_tab_index')->setId(1);
        parent::preDispatch();
    }
}