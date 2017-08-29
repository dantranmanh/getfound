<?php
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AccountController.php');
class Location_Customer_AccountController extends Mage_Customer_AccountController
{
	 /**
     * Customer login form page
     */
    public function loginAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $this->getResponse()->setHeader('Login-Required', 'true');
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    /**
     * Login post action
     */
    public function loginPostAction()
    {
		
        if (!$this->_validateFormKey()) {
			
            $this->_redirect('*/*/');
            return;
        }

        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
			$customer = Mage::getModel('customer/customer');
			$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
			$customer->loadByEmail($login['username']);
			if( $customer->getGroupId() != Mage::helper('merchant')->getMerchantCustomerGroupId()) {
				if (!empty($login['username']) && !empty($login['password'])) {
					try {
						$session->login($login['username'], $login['password']);
						if ($session->getCustomer()->getIsJustConfirmed()) {
							$this->_welcomeCustomer($session->getCustomer(), true);
						}
					} catch (Mage_Core_Exception $e) {
						switch ($e->getCode()) {
							case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
								$value = $this->_getHelper('customer')->getEmailConfirmationUrl($login['username']);
								$message = $this->_getHelper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
								break;
							case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
								$message = $e->getMessage();
								break;
							default:
								$message = $e->getMessage();
						}
						$session->addError($message);
						$session->setUsername($login['username']);
					} catch (Exception $e) {
						// Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
					}
				} else {
					$session->addError($this->__('Login and password are required.'));
				}
			} else {
				$session->addError($this->__('This email is associated with the Merchant. Please create an account with different email address'));
			}
        }
        $this->_loginPostRedirect();
    }
}
?>