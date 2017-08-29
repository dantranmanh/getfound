<?php
set_time_limit(0);
$servername = "localhost";
$username = "dentalk0_sandy";
$password = "Animal12!@";
$dbname = "dentalk0_shoplocalstores";

//$paypalProductId = $_REQUEST['item_number'];
$paypalProductId = $_REQUEST['item_number'];
$amount = $_REQUEST['mc_gross'];

$payment_type = $_REQUEST['payment_type'];
$payer_email = $_REQUEST['payer_email'];
$address_street = $_REQUEST['address_street'];
$address_name = $_REQUEST['address_name'];
$address_zip = $_REQUEST['address_zip'];
$address_state = $_REQUEST['address_state'];
$address_city = $_REQUEST['address_city'];
$address_country = $_REQUEST['address_country'];
$first_name = $_REQUEST['first_name'];

$alt_pay_token = $_REQUEST['pay_key'];
$alt_pay_payer_id = $_REQUEST['payer_id'];

//$_REQUEST['item_number'] = '342';
//$_REQUEST['mc_gross'] = '179.95';



$data = array();

/*
$data['productId'] = $paypalProductId;
$data['price'] = $amount;
$data['creditCardType'] = $payment_type;
$data['email'] = 'devd@gmail.com';
$data['shippingAddress1'] = $address_street;
$data['shippingAddress1']= $address_street;
$data['shippingZip'] = $address_zip;
$data['shippingCity'] = $address_city;
$data['shippingState'] = $address_state;
$data['shippingCountry'] = $address_country;

$data['firstName'] = $first_name;

$data['billingAddress1'] = $address_street;
$data['billingAddress1']= $address_street;
$data['billingZip'] = $address_zip;
$data['billingCity'] = $address_city;
$data['billingState'] = $address_state;
$data['billingCountry'] = $address_country;

$data['alt_pay_token'] = $alt_pay_token;
$data['alt_pay_payer_id'] = $alt_pay_payer_id;
*/



$data['username'] = 'ultimate';
$data['password'] = 'SHSkpQk8YyDUqN';
$data['three_d_redirect_url'] = 'https://www.totalwellnesscrm.com';
$data['method'] = 'NewOrder';
$data['ipAddress'] = '198.54.115.191';
$data['shippingId'] = '5';
$data['campaignId'] = '111';
$data['tranType'] = 'Sale';
$data['lastName'] = 'D';
$data['phone'] = '8007387953';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$to = "pradipsww@gmail.com";
$subject = "Testing Paypal";
$txt = "Hello world!";
$headers = "From: sandip.saini@gmail.com" . "\r\n" .
"CC: sandip.saini@gmail.com";

//$mailStatus =  mail($to,$subject,$txt,$headers);

if($mailStatus){
	echo "Mail has been Sent";
}else{
	echo "Not Sent";
}


$sql = "INSERT INTO `test_paypal`(`alt_pay_token`,`alt_pay_payer_id`,`item_number`,`mc_gross`,`payment_type`,`payer_email`,`address_street`,`address_name`,`address_zip`,`address_state`,`address_city`,`address_country`,`first_name`) 
VALUES ('$alt_pay_token','$alt_pay_payer_id','$paypalProductId','$amount','$payment_type','$payer_email','$address_street','$address_name','$address_zip','$address_state','$address_city','$address_country','$first_name')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();




   $output = array();
   //$url = $_POST['site'].'transact.php';
   $url = 'https://totalwellnesscrm.limelightcrm.com/admin/transact.php';
   
   //$data = $_POST;
   //print_r($data);
    unset($data['billingStateUS']);
	unset($data['billingStateCA']);
	unset($data['shippingStateUS']);
	unset($data['shippingStateCA']);

 
   $curlSession = curl_init();
   curl_setopt($curlSession, CURLOPT_URL, $url);
   curl_setopt($curlSession, CURLOPT_HEADER, 0);
   curl_setopt($curlSession, CURLOPT_POST, 1);
   curl_setopt($curlSession, CURLOPT_POSTFIELDS, http_build_query($data));
   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($curlSession, CURLOPT_TIMEOUT,5000);
   curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
   curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 1);
   curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);
   $rawresponse = curl_exec($curlSession);
   
   if (strpos($rawresponse, '&'))
   {
      $response = explode('&', $rawresponse);
      $output = array();
      $count = count($response);
      for ($i=0; $i < $count; $i++)
      {
         $splitAt = strpos($response[$i], "=");
         $output[trim(substr($response[$i], 0, $splitAt))] = trim(substr(urldecode($response[$i]), ($splitAt+1)));
      }
   }
   else
   {
      $output = $rawresponse;
   }
   
	echo json_encode($output);
   
   
   /*print_r($output);
   echo "</PRE> <BR>";*/
   curl_close ($curlSession);

?>

<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Ultimate Erection Booster</title>
		<meta name="description" content="Worthy a Bootstrap-based, Responsive HTML5 Template">
		<meta name="author" content="htmlcoder.me">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed|Roboto:300,400,500" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
		<link href="css/style.css" rel="stylesheet"> 
		<link href="css/responsive.css" rel="stylesheet"> 
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <script src="js/ajax_libs_jquery_1.12.4_jquery.min.js"></script>
        <script src="js/bootstrap_3.3.7_js_bootstrap.min.js"></script>

	</head>

	<body >
              <form name="cardForm" id="cardForm" action="notify.php">
					<input type="hidden" name="username" id="username" value="ultimate"/>
					<input type="hidden" name="password" id="password"  value="SHSkpQk8YyDUqN"/>
					<!--<input type="hidden" name="site"  id="site"  value="https://www.totalwellnesscrm.com/admin/"/>-->
					<input type="hidden" name="site"  id="site"  value="https://totalwellnesscrm.limelightcrm.com/admin/"/>
					<input type="hidden" name="method"  id="method"  value="NewOrder"/>
					<input type="hidden" name="three_d_redirect_url" value="https://www.totalwellnesscrm.com">
					<input type="hidden" name="ipAddress" value="198.54.115.191">
					<input type="hidden" name="shippingId" id="shippingId" value="5">
					<input type="hidden" name="campaignId" value="111">
					<input type="hidden" name="tranType" value="Sale"> 
					<input type="hidden" name="productId" id="productId" value="<?php echo $paypalProductId; ?>">
					<input type="hidden" name="email" id="email" value="<?php echo $payer_email; ?>">
					
					<input type="hidden" name="creditCardType" id="creditCardType" value="<?php echo $payment_type; ?>">
					<input type="hidden" name="alt_pay_token" id="alt_pay_token" value="<?php echo $alt_pay_token; ?>">
					<input type="hidden" name="alt_pay_payer_id" id="alt_pay_payer_id" value="<?php echo $alt_pay_payer_id; ?>">
					<input type="hidden" name="firstName" id="firstName" value="<?php echo $first_name; ?>">
					<input type="hidden" name="lastName" id="lastName" value="D">
					<input type="hidden" name="shippingAddress1" id="shippingAddress1" value="<?php echo $address_street; ?>">
					<input type="hidden" name="shippingCity" id="shippingCity" value="<?php echo $address_city; ?>">
					<input type="hidden" name="shippingState" id="shippingState" value="<?php echo $address_state; ?>">
					<input type="hidden" name="shippingZip" id="shippingZip" value="<?php echo $address_zip; ?>">
					<input type="hidden" name="shippingCountry" id="shippingCountry" value="<?php echo $address_country; ?>">
					<input type="hidden" name="phone" id="phone" value="8007387953">
					<input type="hidden" name="billingAddress1" id="billingAddress1" value="<?php echo $address_street; ?>">
					<input type="hidden" name="billingCity" id="billingCity" value="<?php echo $address_city; ?>">
					<input type="hidden" name="billingState" id="billingState" value="<?php echo $address_state; ?>">
					<input type="hidden" name="billingZip" id="billingZip" value="<?php echo $address_zip; ?>">
					<input type="hidden" name="billingCountry" id="billingCountry" value="<?php echo $address_country; ?>">					

					<!--<input type="hidden" name="creditCardNumber" id="creditCardNumber" value="1444444444444440">
					<input type="hidden" name="expirationDate" id="expirationDate" value="1019">
					<input type="hidden" name="CVV" id="CVV" value="123">-->	
					
					
							<input type="radio" name="productId" id="product1" value="340" data-price="59.95" data-name="1 Month supply" class="hidden">
							<input type="radio" name="productId" id="product3" value="341" data-price="119.95" data-name="3 Month supply" class=" hidden">	
							<input type="radio" name="productId" id="product2" value="342" data-price="179.95" data-name="6 Month supply" class=" hidden">
					<?php 
					if($paypalProductId == '340'){
					?>	
						<input type="radio" name="productId" id="product1" value="340" data-price="59.95" data-name="1 Month supply" class="hidden">
					<?php	
					}
					if($paypalProductId == '341'){
					?>	
						<input type="radio" name="productId" id="product3" value="341" data-price="119.95" data-name="3 Month supply" class=" hidden">	
					<?php	
					}
					if($paypalProductId == '342'){
					?>	
						<input type="radio" name="productId" id="product2" value="342" data-price="179.95" data-name="6 Month supply" class=" hidden">
					<?php	
					}	
					?>				
														
                   <!--<input type="submit" name="btn_submit" value="Submit">-->
              </form>
			  
			  
			   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
				<script>
				$(document).ready(function(){
					// $("#cardForm").submit();
				});
				</script>
				
			 	
	</body>
</html>
