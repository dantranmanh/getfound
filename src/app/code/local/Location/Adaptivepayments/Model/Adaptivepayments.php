<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_Adaptivepayments extends Mage_Core_Model_Abstract
{
    const ADAPTIVEPAYMENTS_TYPE_PAYPAL = 1;
    const ACTIONT_TYPE = "PAY";
    const CURRENCY_CODE = "USD";
    const PAYPAL_URL = "http://www.paypal.com";

    private $proxy_host;
    private $proxy_port;
    private $use_proxy;
    private $env;
    private $api_username;
    private $api_password;
    private $api_signature;
    private $api_appid;
    private $api_endpoint;
    private $senderEmail;

    static public $_adaptivepaymentsTypes = array();

    public function _construct()
    {
        parent::_construct();
        $this->_init('adaptivepayments/adaptivepayments');
        self::$_adaptivepaymentsTypes = self::$_adaptivepaymentsTypes + array(
        self::ADAPTIVEPAYMENTS_TYPE_PAYPAL => 'adaptivepayments/type_paypal'
        );
        $this->proxy_host 		= Mage::getStoreConfig('adaptivepayments/proxy/host');
        $this->proxy_port		= Mage::getStoreConfig('adaptivepayments/proxy/port');
        $this->use_proxy		= (Mage::getStoreConfig('adaptivepayments/proxy/use') == 1) ? true : false;
        $this->env				= (Mage::getStoreConfig('adaptivepayments/api/sandbox_flag') == 1) ? 'sandbox' : '';
        $this->api_username		= Mage::getStoreConfig('adaptivepayments/api/username'); // 'ravi.g_1333519926_biz_api1.com';
        $this->api_password		= Mage::getStoreConfig('adaptivepayments/api/password'); //'1333519959';
        $this->api_signature	= Mage::getStoreConfig('adaptivepayments/api/signature'); //'AQ7LS3BPSNwH3YPag2ad7wAkHj0YAAqJg7yrtNtkLYgn6WWhKOZaLXO3';
        $this->api_appid		= Mage::getStoreConfig('adaptivepayments/api/appid'); //'APP-80W284485P519543T';
        $this->senderEmail    	= Mage::getStoreConfig('adaptivepayments/api/senderemail'); //'APP-80W284485P519543T';

        if ($this->env == 'sandbox') {
            $this->api_endpoint = Mage::getStoreConfig('adaptivepayments/api/sandbox_endpoint');
        } else {
            $this->api_endpoint = Mage::getStoreConfig('adaptivepayments/api/live_endpoint');
        }
    }

    protected function generateCharacter()
    {
        $possible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        return $char;
    }

    public function generateTrackingID()
    {
        $GUID = $this->generateCharacter().$this->generateCharacter().$this->generateCharacter().$this->generateCharacter().$this->generateCharacter();
        $GUID .= $this->generateCharacter().$this->generateCharacter().$this->generateCharacter().$this->generateCharacter();
        return $GUID;
    }

    /**
     * Prepares the parameters for the Refund API Call.
     * @param payKey or trackingId or trasactionId or (payKey and receiverEmailArray and receiverAmountArray) or
     *  (trackingId and receiverEmailArray and receiverAmountArray) or
     *  (transactionId and receiverEmailArray and receiverAmountArray)
     * @return Object NVP Collection object of the Refund call response.
     */
    public function callRefund($payKey, $transactionId, $trackingId, $receiverEmailArray, $receiverAmountArray)
    {
        /* Gather the information to make the Refund call.
         The variable nvpstr holds the name value pairs
         */

        $nvpstr = "";

        // conditionally required fields
        if ("" != $payKey) {
            $nvpstr = "payKey=" . urlencode($payKey);
            if (0 != count($receiverEmailArray)) {
                reset($receiverEmailArray);
                while (list($key, $value) = each($receiverEmailArray)) {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").email=" . urlencode($value);
                    }
                }
            }
            if (0 != count($receiverAmountArray))
            {
                reset($receiverAmountArray);
                while (list($key, $value) = each($receiverAmountArray))
                {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").amount=" . urlencode($value);
                    }
                }
            }
        }
        elseif ("" != $trackingId)
        {
            $nvpstr = "trackingId=" . urlencode($trackingId);
            if (0 != count($receiverEmailArray))
            {
                reset($receiverEmailArray);
                while (list($key, $value) = each($receiverEmailArray))
                {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").email=" . urlencode($value);
                    }
                }
            }
            if (0 != count($receiverAmountArray))
            {
                reset($receiverAmountArray);
                while (list($key, $value) = each($receiverAmountArray))
                {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").amount=" . urlencode($value);
                    }
                }
            }
        }
        elseif ("" != $transactionId)
        {
            $nvpstr = "transactionId=" . urlencode($transactionId);
            // the caller should only have 1 entry in the email and amount arrays
            if (0 != count($receiverEmailArray))
            {
                reset($receiverEmailArray);
                while (list($key, $value) = each($receiverEmailArray))
                {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").email=" . urlencode($value);
                    }
                }
            }
            if (0 != count($receiverAmountArray))
            {
                reset($receiverAmountArray);
                while (list($key, $value) = each($receiverAmountArray))
                {
                    if ("" != $value)
                    {
                        $nvpstr .= "&receiverList.receiver(" . $key . ").amount=" . urlencode($value);
                    }
                }
            }
        }

        /* Make the Refund call to PayPal */
        $resArray = $this->hashCall("Refund", $nvpstr);

        /* Return the response array */
        return $resArray;
    }

    /*
     '-------------------------------------------------------------------------------------------------------------------------------------------
     ' Purpose: 	Prepares the parameters for the PaymentDetails API Call.
     '			The PaymentDetails call can be made with either
     '			a payKey, a trackingId, or a transactionId of a previously successful Pay call.
     ' Inputs:
     '
     ' Conditionally Required:
     '		One of the following:  payKey or transactionId or trackingId
     ' Returns:
     '		The NVP Collection object of the PaymentDetails call response.
     '--------------------------------------------------------------------------------------------------------------------------------------------
     */
    public function callPaymentDetails($payKey, $transactionId, $trackingId)
    {
        /* Gather the information to make the PaymentDetails call.
         The variable nvpstr holds the name value pairs
         */

        $nvpstr = "";

        // conditionally required fields
        if ("" != $payKey)
        {
            $nvpstr = "payKey=" . urlencode($payKey);
        }
        elseif ("" != $transactionId)
        {
            $nvpstr = "transactionId=" . urlencode($transactionId);
        }
        elseif ("" != $trackingId)
        {
            $nvpstr = "trackingId=" . urlencode($trackingId);
        }

        /* Make the PaymentDetails call to PayPal */
        $resArray = $this->hashCall("PaymentDetails", $nvpstr);

        /* Return the response array */
        return $resArray;
    }

    /*
     '-------------------------------------------------------------------------------------------------------------------------------------------
     ' Purpose: 	Prepares the parameters for the Pay API Call.
     ' Inputs:
     '
     ' Required:
     '
     ' Optional:
     '
     '
     ' Returns:
     '		The NVP Collection object of the Pay call response.
     '--------------------------------------------------------------------------------------------------------------------------------------------
     */
    public function callPay($paypalEmail, $amount, $vendorId)
    {
        $actionType = self::ACTIONT_TYPE;
        $cancelUrl = self::PAYPAL_URL;
        $returnUrl = self::PAYPAL_URL;
        $currencyCode = self::CURRENCY_CODE;
        $receiverEmailArray = array('0'=>$paypalEmail);
        $receiverAmountArray = array('0'=>round( $amount, 2));
        $receiverPrimaryArray = $receiverEmailArray;
        $receiverInvoiceIdArray = array();
        $feesPayer						= "";
        $ipnNotificationUrl				= "";
        $memo							= "";		// maxlength is 1000 characters
        $pin							= "";		// No pin for an implicit payment use case
        $preapprovalKey = "";
        $reverseAllParallelPaymentsOnError	= "";
        $senderEmail=$this->senderEmail;
        $trackingId = $this->generateTrackingID();

        /* Gather the information to make the Pay call.
         The variable nvpstr holds the name value pairs
         */

        // required fields
        $nvpstr = "actionType=" . urlencode($actionType) . "&currencyCode=" . urlencode($currencyCode);
        $nvpstr .= "&returnUrl=" . urlencode($returnUrl) . "&cancelUrl=" . urlencode($cancelUrl);
        $nvpstr .= "&vendorId=" . urlencode($vendorId);

        if (0 != count($receiverAmountArray))
        {
            reset($receiverAmountArray);
            while (list($key, $value) = each($receiverAmountArray))
            {
                if ("" != $value)
                {
                    $nvpstr .= "&receiverList.receiver(" . $key . ").amount=" . urlencode($value);
                }
            }
        }

        if (0 != count($receiverEmailArray))
        {
            reset($receiverEmailArray);
            while (list($key, $value) = each($receiverEmailArray))
            {
                if ("" != $value)
                {
                    $nvpstr .= "&receiverList.receiver(" . $key . ").email=" . urlencode($value);
                }
            }
        }

        if (0 != count($receiverPrimaryArray))
        {
            reset($receiverPrimaryArray);
            while (list($key, $value) = each($receiverPrimaryArray))
            {
                if ("" != $value)
                {
                    $nvpstr = $nvpstr . "&receiverList.receiver(" . $key . ").primary=" . urlencode($value);
                }
            }
        }

        if (0 != count($receiverInvoiceIdArray))
        {
            reset($receiverInvoiceIdArray);
            while (list($key, $value) = each($receiverInvoiceIdArray))
            {
                if ("" != $value)
                {
                    $nvpstr = $nvpstr . "&receiverList.receiver(" . $key . ").invoiceId=" . urlencode($value);
                }
            }
        }

        // optional fields
        if ("" != $feesPayer)
        {
            $nvpstr .= "&feesPayer=" . urlencode($feesPayer);
        }

        if ("" != $ipnNotificationUrl)
        {
            $nvpstr .= "&ipnNotificationUrl=" . urlencode($ipnNotificationUrl);
        }

        if ("" != $memo)
        {
            $nvpstr .= "&memo=" . urlencode($memo);
        }

        if ("" != $pin)
        {
            $nvpstr .= "&pin=" . urlencode($pin);
        }

        if ("" != $preapprovalKey)
        {
            $nvpstr .= "&preapprovalKey=" . urlencode($preapprovalKey);
        }

        if ("" != $reverseAllParallelPaymentsOnError)
        {
            $nvpstr .= "&reverseAllParallelPaymentsOnError=" . urlencode($reverseAllParallelPaymentsOnError);
        }

        if ("" != $senderEmail)
        {
            $nvpstr .= "&senderEmail=" . urlencode($senderEmail);
        }

        if ("" != $trackingId)
        {
            $nvpstr .= "&trackingId=" . urlencode($trackingId);
        }

        /* Make the Pay call to PayPal */
        $resArray = $this->hashCall("Pay", $nvpstr);

        /* Return the response array */
        return $resArray;
    }

    /*
     '-------------------------------------------------------------------------------------------------------------------------------------------
     ' Purpose: 	Prepares the parameters for the PreapprovalDetails API Call.
     ' Inputs:
     '
     ' Required:
     '		preapprovalKey:		A preapproval key that identifies the agreement resulting from a previously successful Preapproval call.
     ' Returns:
     '		The NVP Collection object of the PreapprovalDetails call response.
     '--------------------------------------------------------------------------------------------------------------------------------------------
     */
    public function callPreapprovalDetails( $preapprovalKey )
    {
        /* Gather the information to make the PreapprovalDetails call.
         The variable nvpstr holds the name value pairs
         */

        // required fields
        $nvpstr = "preapprovalKey=" . urlencode($preapprovalKey);

        /* Make the PreapprovalDetails call to PayPal */
        $resArray = $this->hashCall("PreapprovalDetails", $nvpstr);

        /* Return the response array */
        return $resArray;
    }

    /*
     '-------------------------------------------------------------------------------------------------------------------------------------------
     ' Purpose: 	Prepares the parameters for the Preapproval API Call.
     ' Inputs:
     '
     ' Required:
     '
     ' Optional:
     '
     '
     ' Returns:
     '		The NVP Collection object of the Preapproval call response.
     '--------------------------------------------------------------------------------------------------------------------------------------------
     */
    public function callPreapproval( $returnUrl, $cancelUrl, $currencyCode, $startingDate, $endingDate, $maxTotalAmountOfAllPayments,
    $senderEmail, $maxNumberOfPayments, $paymentPeriod, $dateOfMonth, $dayOfWeek,
    $maxAmountPerPayment, $maxNumberOfPaymentsPerPeriod, $pinType )
    {
        /* Gather the information to make the Preapproval call.
         The variable nvpstr holds the name value pairs
         */

        // required fields
        $nvpstr = "returnUrl=" . urlencode($returnUrl) . "&cancelUrl=" . urlencode($cancelUrl);
        $nvpstr .= "&currencyCode=" . urlencode($currencyCode) . "&startingDate=" . urlencode($startingDate);
        $nvpstr .= "&endingDate=" . urlencode($endingDate);
        $nvpstr .= "&maxTotalAmountOfAllPayments=" . urlencode($maxTotalAmountOfAllPayments);

        // optional fields
        if ("" != $senderEmail)
        {
            $nvpstr .= "&senderEmail=" . urlencode($senderEmail);
        }

        if ("" != $maxNumberOfPayments)
        {
            $nvpstr .= "&maxNumberOfPayments=" . urlencode($maxNumberOfPayments);
        }

        if ("" != $paymentPeriod)
        {
            $nvpstr .= "&paymentPeriod=" . urlencode($paymentPeriod);
        }

        if ("" != $dateOfMonth)
        {
            $nvpstr .= "&dateOfMonth=" . urlencode($dateOfMonth);
        }

        if ("" != $dayOfWeek)
        {
            $nvpstr .= "&dayOfWeek=" . urlencode($dayOfWeek);
        }

        if ("" != $maxAmountPerPayment)
        {
            $nvpstr .= "&maxAmountPerPayment=" . urlencode($maxAmountPerPayment);
        }

        if ("" != $maxNumberOfPaymentsPerPeriod)
        {
            $nvpstr .= "&maxNumberOfPaymentsPerPeriod=" . urlencode($maxNumberOfPaymentsPerPeriod);
        }

        if ("" != $pinType)
        {
            $nvpstr .= "&pinType=" . urlencode($pinType);
        }
        /* Make the Preapproval call to PayPal */
        $resArray = $this->hashCall("Preapproval", $nvpstr);

        /* Return the response array */
        return $resArray;
    }

    /**
     '-------------------------------------------------------------------------------------------------------------------------------------------
     * hashCall: Function to perform the API call to PayPal using API signature
     * @methodName is name of API method.
     * @nvpStr is nvp string.
     * returns an associative array containing the response from the server.
     '-------------------------------------------------------------------------------------------------------------------------------------------
     */
    protected function hashCall($methodName, $nvpStr)
    {
        $requestStart = microtime(true);
        $this->api_endpoint .= "/" . $methodName;
        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the HTTP Headers
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
		'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
		'X-PAYPAL-RESPONSE-DATA-FORMAT: NV',
		'X-PAYPAL-SECURITY-USERID: ' . $this->api_username,
		'X-PAYPAL-SECURITY-PASSWORD: ' .$this->api_password,
		'X-PAYPAL-SECURITY-SIGNATURE: ' . $this->api_signature,
		'X-PAYPAL-SERVICE-VERSION: 1.3.0',
		'X-PAYPAL-APPLICATION-ID: ' . $this->api_appid
        ));

        //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
        //if($USE_PROXY)
        //curl_setopt ($ch, CURLOPT_PROXY, $this->proxy_host. ":" . $this->proxy_port);

        // RequestEnvelope fields
        $detailLevel	= urlencode("ReturnAll");	// See DetailLevelCode in the WSDL for valid enumerations
        $errorLanguage	= urlencode("en_US");		// This should be the standard RFC 3066 language identification tag, e.g., en_US

        // NVPRequest for submitting to server
        $nvpreq = "requestEnvelope.errorLanguage=$errorLanguage&requestEnvelope.detailLevel=$detailLevel";
        $nvpreq .= "&$nvpStr";

        $created_time = Mage::getSingleton('core/date')->gmtDate();
        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
        $requestEnd = microtime(true);

        // initializing or creating array
        $request_info = $this->deformatNVP($nvpreq);

        // creating object of SimpleXMLElement
        $xml_request_info = new SimpleXMLElement("<?xml version=\"1.0\"?><PayRequest></PayRequest>");

        // function call to convert array to xml
        $this->arrayToXml($request_info, $xml_request_info);
        $xml_request_info->asXML();

        $responseStart = microtime(true);
        //getting response from server
        $response = curl_exec($ch);
        $responseEnd = microtime(true);

        //converting NVPResponse to an Associative Array
        $nvpResArray=$this->deformatNVP($response);
        $nvpReqArray=$this->deformatNVP($nvpreq);
        // creating object of SimpleXMLElement
        $xml_response_info = new SimpleXMLElement("<?xml version=\"1.0\"?><PayResponse></PayResponse>");

        // function call to convert array to xml
        $this->arrayToXml($nvpResArray, $xml_response_info);
        $xml_response_info->asXML();
        $_SESSION['nvpReqArray']=$nvpReqArray;

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
            $_SESSION['curl_error_no']=curl_errno($ch) ;
            $_SESSION['curl_error_msg']=curl_error($ch);

            //Execute the Error handling module to display errors.
        } else {
            //closing the curl
            curl_close($ch);
        }

        $request_time = $requestEnd - $requestStart;
        $response_time = $responseEnd - $responseStart;

        $adaptivePayement = array(
	                'table_name' => $this->_adaptivePaymentTable,
					'method' => $methodName,
	                'payment_id' => $nvpResArray['responseEnvelope.correlationId'],
					'vendor_id' => $request_info['vendorId'],
					'transaction_id' => $nvpResArray['responseEnvelope.correlationId'],
					'amount' => $request_info['receiverList.receiver(0).amount'],
					'currency' => $request_info['currencyCode'],
					'type' => $request_info['actionType'],
					'trasaction_status' => isset($nvpResArray['paymentExecStatus']) ? $nvpResArray['paymentExecStatus'] : $nvpResArray['responseEnvelope.ack'],
                    'created_time' => now(),
        			'update_time' => $nvpResArray['responseEnvelope.timestamp'],
	                'request_time' => $request_time,
					'response_time' => $response_time);

        $this->setData($adaptivePayement);
        $this->save();

        $adaptivePayementLog = array(
	                'table_name' => $this->_logTable,
	                'adaptivepayments_id' => $this->getAdaptivepaymentsId(),
					'request' => $xml_request_info->asXML(),
					'response' => $xml_response_info->asXML(),
					'ack' => $nvpResArray['responseEnvelope.ack'],
                    'payment_exec_status' => isset($nvpResArray['paymentExecStatus']) ? $nvpResArray['paymentExecStatus'] : $nvpResArray['responseEnvelope.ack'],
         			'created_time' => now(),
        			'update_time' => $nvpResArray['responseEnvelope.timestamp'],
					'request_time' =>$request_time,
					'response_time' => $response_time);

        $adaptivePaymentsLog = Mage::getModel('adaptivepayments/log');
        $adaptivePaymentsLog->setData($adaptivePayementLog);
        $adaptivePaymentsLog->save();

        return $nvpResArray;
    }

    /*'----------------------------------------------------------------------------------
     Purpose: Defination to convert array to xml.
     Inputs:  $request_info request array
     Inputs:  $xml_request_info SimpleXMLElement Object
     Returns:
     ----------------------------------------------------------------------------------
     */
    public function arrayToXml($request_info, &$xml_request_info)
    {
        foreach($request_info as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_request_info->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                }
                else{
                    $this->arrayToXml($value, $xml_request_info);
                }
            }
            else {
                $xml_request_info->addChild("$key","$value");
            }
        }
    }

    /*'----------------------------------------------------------------------------------
     Purpose: Redirects to PayPal.com site.
     Inputs:  $cmd is the querystring
     Returns:
     ----------------------------------------------------------------------------------
     */
    public function RedirectToPayPal ( $cmd )
    {
        $payPalURL = "";

        if ($this->env == "sandbox")
        {
            $payPalURL = "https://www.sandbox.paypal.com/webscr?" . $cmd;
        }
        else
        {
            $payPalURL = "https://www.paypal.com/webscr?" . $cmd;
        }
        return $payPalURL;
    }


    /*'----------------------------------------------------------------------------------
     * This function will take NVPString and convert it to an Associative Array and it will decode the response.
     * It is usefull to search for a particular key and displaying arrays.
     * @nvpstr is NVPString.
     * @nvpArray is Associative Array.
     ----------------------------------------------------------------------------------
     */
    protected function deformatNVP($nvpstr)
    {
        $intial=0;
        $nvpArray = array();

        while(strlen($nvpstr))
        {
            //postion of Key
            $keypos= strpos($nvpstr,'=');
            //position of value
            $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

            /*getting the Key and Value values and storing in a Associative Array*/
            $keyval=substr($nvpstr,$intial,$keypos);
            $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
            //decoding the respose
            $nvpArray[urldecode($keyval)] =urldecode( $valval);
            $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
        }
        return $nvpArray;
    }

    public function getAdaptivePaymentsTypes()
    {
        return self::$_adaptivepaymentsTypes;
    }

    public function getSelectType($data)
    {
        if (isset($data['redemtion_type']) and $data['redemtion_type'] != '') {
            return Mage::getModel(self::$_adaptivepaymentsTypes[$data['redemtion_type']]);
        }
        return false;
    }

    public function validate($data)
    {
        $isvalid = true;
        if (isset($data['points']) and $data['points'] > 0) {
            $customer = Mage::getModel('customer/customer')->load();
            $available = Mage::helper('enterprise_reward/data')->getAdaptivePaymentsablePoints(Mage::getSingleton('customer/session')->getId());
            if ($available < (int)$data['points']) {
                $isvalid = false;
            }
        }
        return $isvalid;
    }

    public function adaptivepayments($data)
    {
        try
        {
            $adaptivepaymentsType = Mage::getModel(self::$_adaptivepaymentsTypes[$data['type']]);
            $data = $adaptivepaymentsType->process($data);
            if ($data['status']) {
                $points = $data['points'];
                Mage::getModel('enterprise_reward/reward')
                ->setCustomerId(Mage::getSingleton('customer/session')->getId())
                ->setWebsiteId(Mage::app()->getStore(Mage::app()->getStore()->getId())->getWebsiteId())
                ->loadTypeByCustomer('adaptivepaymentsable')
                ->setPointsDelta(-$points)
                ->setAction(Zeon_Reward_Model_Reward::REWARD_ACTION_ADAPTIVEPAYMENTS)
                ->updateRewardPoints();


                $tosave = array();
                $tosave['customer_id'] = Mage::getSingleton('customer/session')->getId();
                $tosave['points'] = $data['points'];
                $tosave['amount'] = (Mage::helper('adaptivepayments/data')->getAdaptivePaymentsRate() * $data['points']) / 100;
                $tosave['currency'] = Mage::app()->getStore()->getCurrentCurrencyCode();
                $tosave['type'] = $data['type'];
                $tosave['details'] = serialize($data['details']);
                $tosave['status'] = $data['adaptivepayments_status'];

                $this->setData($tosave);
                $this->setCreatedTime(now())
                ->setUpdateTime(now());
                $this->save();
                return true;
            } else {
                if ($data['message'] != '') {
                    Mage::getSingleton('core/session')->addError($data['message']);
                } else {
                    Mage::getSingleton('core/session')->addError('Cannot process your request. Try again later');
                }
                return false;
            }
    	} catch (Exception $e) {
    		Mage::getSingleton('core/session')->addError($e->getMessage());
    		return false;
    	}
    }
}