<?php  require_once '../config.php';
include 'function.php';

/*$regi =  json_decode('{"customer_id":"185",
"amount":"121",
"payment_type":"Wallet",
"transaction_id":"4220180927936"
}');
*/
$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$customer_id = $regi->customer_id;
	$amount = $regi->amount;
	$payment_type = $regi->payment_type;
	$transaction_id = $regi->transaction_id;
	$date_time = time();
	if($amount > 0){
		$insert_query = "INSERT INTO monthly_pass_pre_payment(customer_id,amount,payment_type,transaction_id,date_time) VALUES('$customer_id','$amount','$payment_type','$transaction_id','$date_time')";
		if ($con->query($insert_query) === TRUE) {
			$order_id = $con->insert_id;
			if($payment_type=='Wallet'){
				$transaction_remarks = 'Amount Detect by '.$amount.' Rs for Monthly Pass Pre Payment';
				$amount_type = 'Dr';
				WalletTransaction($con,$customer_id,$amount,$transaction_id,$transaction_remarks,$amount_type,$payment_type,$order_id);	
			}
			$array['error_code'] = 200; 
			$array['message'] = 'Monthly Pass Pre Payment Successfully';
			
			$select_user_name = $con->query("SELECT fcm_id FROM `pa_users` Where id='".$regi->customer_id."' AND user_role='customer'");
        	$val_user = $select_user_name->fetch_assoc();
        	
        	$message = 'Monthly Pass Pre Payment Successfully. Thank you The Digital Parking.';
        	$mobile_number = $val_user['mobile_number'];
        	SendSMSNotification($mobile_number, $message);
		}
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Please enter Amount grater 0 Rs.';

	}

} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
echo json_encode($finalarray);
//echo '<pre>'; print_r($finalarray); 