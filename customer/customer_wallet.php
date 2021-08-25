<?php  require_once '../config.php';
include 'function.php';

/*$regi =  json_decode('{"customer_id":"165",
"wallet_amount":"100",
"transaction_id":"201251010",
"transaction_type":"Paytm",
"transaction_remarks":"Test"
}');
*/
$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$user_id  = $regi->customer_id; 
	$wallet_amount  = $regi->wallet_amount;
	$transaction_id  = $regi->transaction_id;
	$transaction_remarks  = $regi->transaction_remarks;
	$amount_type = 'Cr';
	$transaction_type = $regi->transaction_type;
	$order_id = $regi->order_id;

	AddAmountWallet($con,$user_id,$wallet_amount,$transaction_id,$transaction_remarks,$amount_type,$transaction_type,$order_id);
	$array['error_code'] = 200;
	$array['message'] = 'Wallet added Successfully';
	
	
	
	$select_user_name = $con->query("SELECT fcm_id FROM `pa_users` Where id='".$regi->customer_id."' AND user_role='customer'");
	$val_user = $select_user_name->fetch_assoc();
	$user_device_key = isset($val_user['fcm_id']) ? $val_user['fcm_id'] : '';
	
	$message = 'Dear '.$val_user['first_name'].' '.$wallet_amount.' added in your wallet';
	$mobile_number = $val_user['mobile_number'];
	SendSMSNotification($mobile_number, $message);
	
	if($user_device_key){
		$body_msg = $wallet_amount.' added in your wallet';
		$json_data = array(
			'to' => $user_device_key,
			'notification' => array(
			'body' => $body_msg,
			'title' => ucwords('Amount added in wallet'),
			'icon' => 'ic_launcher',
			'sound' => 'default'
			)
		);
		$data = json_encode($json_data);
        //FCM API end-point
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AAAADYXZAOk:APA91bHOvLIa9iklE1YO9Feb92byZV-lsksn9PtzjBsBDjR7yukBpnaIynGxQ1XAYM5Y1yvKH-bhjMjeBqw-4ij_K5sXx_QCZqIwLTZWze3Bcq4AICSW2gp3g-dWVCyRtXYz6PPLYR-I';
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key='.$server_key
			);
			//CURL request to route notification to FCM connection server (provided by Google)
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($ch);
			if ($result === FALSE) {
				log_message('debug', 'CURL API Response - FCM Response ERROR');	
				}
			curl_close($ch);

			$response = json_decode($result,true);
            
            echo "<pre>";
            print_r($result);
            die;
            
			$status = 0;
			if($response['success'] == 1)
			{
				$status = 1;
			}

		}
	/*$select_query = $con->query("SELECT * FROM pa_users where user_id = '".$user_id."' LIMIT 1");
	$row=$select_query->fetch_assoc();
	echo $mobile_number = $row['mobile_number'];
    die;*/
	/*if($wallet_amount >= 50){
		AddAmountWallet($con,$user_id,$wallet_amount,$transaction_id,$transaction_remarks,$amount_type,$transaction_type,$order_id);
		$array['error_code'] = 200;
		$array['message'] = 'Wallet added Successfully';
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'You can not add Wallet less then 50 Rs.';
	}*/

}  else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);