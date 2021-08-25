<?php 
include '../config.php';

//$regi =  json_decode('{"customer_id":"165"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
$fcm_id = $regi->fcm_id; 
 if($regi){
	 $select_user_name = $con->query("SELECT id, user_email, first_name, last_name, mobile_number, register_date, profile_image, address, state, city, wallet_amount, fcm_id FROM `pa_users` Where id='".$regi->customer_id."' AND user_role='customer'"); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$val_user = $select_user_name->fetch_assoc();
		 
		$con->query("update `pa_users` SET fcm_id = '".$fcm_id."' where id = ".$regi->customer_id);   
		
		$array['error_code'] = 200;
		$array['message'] = 'Customer found';

		if($val_user['profile_image']!=''){
			$val_user['profile_image'] = UPLOAD_URL.$val_user['profile_image'];
		} else {
			$val_user['profile_image'] = '';
		}

		$select_pre_payments = $con->query("SELECT * FROM `monthly_pass_pre_payment` Where customer_id=".$regi->customer_id.""); 
		$numrows_username = $select_pre_payments->num_rows;
		if ($numrows_username > 0) {
			$val_user['digital_card_pre_payment'] = 'Yes';
		} else {
			$val_user['digital_card_pre_payment'] = 'No';
		}


		$array['result'] = $val_user;
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Customer not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);