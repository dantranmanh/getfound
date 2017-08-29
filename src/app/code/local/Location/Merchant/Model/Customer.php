<?php

class Location_Merchant_Model_Customer extends Mage_Customer_Model_Customer
{
	 const XML_PATH_MERCHANT_FORGOT_EMAIL_TEMPLATE = 'merchant/password/forgot_email_template';
	 const XML_PATH_FORGOT_EMAIL_IDENTITY = 'merchant/password/forgot_email_identity';
	 const XML_PATH_FORGOT_EMAIL_TEMPLATE = 'customer/password/forgot_email_template';
     /**
     * Send email with reset password confirmation link
     *
     * @return Mage_Customer_Model_Customer
     */
    public function sendPasswordResetConfirmationEmail()
    {
		$customerGroup =  $this->getGroupId(); 
        $storeId = Mage::app()->getStore()->getId();
        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId();
        }
		if ($customerGroup == 4) {
			$emailTemplate = self::XML_PATH_MERCHANT_FORGOT_EMAIL_TEMPLATE;
		} else {
			$emailTemplate = self::XML_PATH_FORGOT_EMAIL_TEMPLATE;
		}

        $this->_sendEmailTemplate($emailTemplate, self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            array('customer' => $this), $storeId);

        return $this;
    }
}