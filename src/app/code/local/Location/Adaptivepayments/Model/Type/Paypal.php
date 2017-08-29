<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_Type_Paypal extends Location_Adaptivepayments_Model_Type_Abstract
{
	const ADAPTIVEPAYMENTS_TYPE_PAYPAL_BLOCK = 'adaptivepayments/type_paypal';

	public function getLabel() {
		return 'ADAPTIVEPAYMENTS TO PAYPAL ACCOUNT';
	}

	public function getAdaptivePaymentsMessage() {
		return 'REFUND TO PAYPAL ACCOUNT.';
	}

	public function getBlockName()
    {
    	return self::ADAPTIVEPAYMENTS_TYPE_PAYPAL_BLOCK;
    }

    public function process($data) {
    	$data['status'] = false;
    	$data['adaptivepayments_status'] = 'PENDING';
			$amount = (Mage::helper('adaptivepayments/data')->getAdaptivePaymentsRate() * $data['points']) / 100;
    		$preapproval = Mage::getModel('adaptivepayments/preapproval')->getCollection()
						->addFieldToSelect(array('preapproval_id', 'preapproval_key'))
     					->addFieldToFilter('status', 1)
     					->addFieldToFilter('preapproval_status', 'SUCCESS')
     					->addFieldToFilter('starting_date', array('date' => true, 'to' => date('Y-m-d H:i:s', strtotime("now")) ))
     					->addFieldToFilter('ending_date', array('date' => true, 'from' => date('Y-m-d H:i:s', strtotime("now")) ))
     					->addFieldToFilter('main_table.total_amount - main_table.used_amount', array('from' => $amount))
     					->addFieldToFilter('main_table.number_payments - main_table.number_payments_used', array('from' => 1))
     					->getFirstItem();

     		$preapprovalkey = $preapproval->getPreapprovalKey();
     		$preapprovalid = $preapproval->getPreapprovalId();

     		$receiverEmail = $data['details']['account_number'];
     		$receiverName = $data['details']['account_name'];

	    	$currency = Mage::app()->getStore()->getCurrentCurrencyCode();

	    	$invoiceId = $data['details']['paypal_invoice'] = 'c-'.Mage::getSingleton('customer/session')->getId().'-'.rand(11111, 999999);


	$adaptive_api = new Zeon_Paypal_Api();
    // ==================================
	// PayPal Platform Implicit Payment Module
	// ==================================

	// Request specific required fields
	$senderEmail		= Mage::getStoreConfig('adaptivepayments/api/senderemail');				// TODO - The paypal account email address of the sender
											// think of it as required for an implicit payment and
											// set to the same account that owns the API credentials

	$actionType			= "PAY";
	$cancelUrl			= "https://NoOp";	// There is no approval step for implicit payment
	$returnUrl			= "https://NoOp";	// There is no approval step for implicit payment
	$currencyCode		= $currency;

	// An implicit payment can be a simple or parallel or chained payment
	// TODO - specify the receiver emails
	//        remove or set to an empty string the array entries for receivers that you do not have
	//        for a simple payment, specify only receiver0email, and remove the other array entries
	$receiverEmailArray	= array($receiverEmail);

	// TODO - specify the receiver amounts as the amount of money, for example, '5' or '5.55'
	//        remove or set to an empty string the array entries for receivers that you do not have
	//        for a simple payment, specify only receiver0amount, and remove the other array entries
	$receiverAmountArray = array($amount);

	// TODO - specify values ONLY if you are doing a chained payment
	//        if you are doing a chained payment,
	//           then set ONLY 1 receiver in the array to 'true' as the primary receiver, and set the
	//           other receivers corresponding to those indicated in receiverEmailArray to 'false'
	//           make sure that you do NOT specify more values in this array than in the receiverEmailArray
	$receiverPrimaryArray = array($receiverName);

	// TODO - Set invoiceId to uniquely identify the transaction associated with each receiver
	//        set the array entries with value for receivers that you have
	//		  each of the array values must be unique
	$receiverInvoiceIdArray = array($invoiceId);

	// Request specific optional fields
	//   Provide a value for each field that you want to include in the request, if left as an empty string the field will not be passed in the request
	$feesPayer						= "";		// For an implicit payment use case, this cannot be "SENDER"
	$ipnNotificationUrl				= "";
	$memo							= "";		// maxlength is 1000 characters
	$pin							= "";		// No pin for an implicit payment use case
	$preapprovalKey					= $preapprovalkey;		// No preapprovalKey for an implicit use case
	$preapprovalKey = "";
	$reverseAllParallelPaymentsOnError	= "";				// Only specify if you are doing a parallel payment as your implicit payment
	$trackingId						= $adaptive_api->generateTrackingID();	// generateTrackingID function is found in paypalplatform.php

	//-------------------------------------------------
	// Make the Pay API call
	//
	// The CallPay function is defined in the paypalplatform.php file,
	// which is included at the top of this file.
	//-------------------------------------------------
	$resArray = $adaptive_api->CallPay ($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray,
							$receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray,
							$feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey,
							$reverseAllParallelPaymentsOnError, $senderEmail, $trackingId
	);

	$ack = strtoupper($resArray["responseEnvelope.ack"]);
	if($ack=="SUCCESS")
	{
		$use_log = '';
		$model = Mage::getModel('adaptivepayments/preapproval')->load($preapprovalid);
		$model->setUsedAmount($model->getUsedAmount()+$amount);
		$model->setNumberPaymentsUsed($model->getNumberPaymentsUsed()+1);
		$model->setUseLog($model->getUseLog() . '++++++' . $use_log);
		$model->setUpdateTime(now());
		$model->save();

		$data['status'] = true;
		$data['adaptivepayments_status'] = urldecode($resArray["paymentExecStatus"]);
		$data['details']['preapproval_key'] = $preapprovalkey;
		$data['details']['pay_key'] = urldecode($resArray["payKey"]);
		return $data;
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		//TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
		$ErrorCode = urldecode($resArray["error(0).errorId"]);
		$ErrorMsg = urldecode($resArray["error(0).message"]);
		$ErrorDomain = urldecode($resArray["error(0).domain"]);
		$ErrorSeverity = urldecode($resArray["error(0).severity"]);
		$ErrorCategory = urldecode($resArray["error(0).category"]);

		$errMsg = "Preapproval API call failed. <br>";
		$errMsg .= "Detailed Error Message: " . $ErrorMsg . '<br>';
		$errMsg .= "Error Code: " . $ErrorCode . '<br>';
		$errMsg .= "Error Severity: " . $ErrorSeverity . '<br>';
		$errMsg .= "Error Domain: " . $ErrorDomain . '<br>';
		$errMsg .= "Error Category: " . $ErrorCategory . '<br>';

		Mage::log('Paypal Pay API Failed. Error : ' . $errMsg, 1, 'Paypal-Adaptive-Payment-Error'.date('d-m-Y', strtotime("now")).'.log');
		return $data;
	}

    }
}