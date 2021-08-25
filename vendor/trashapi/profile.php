<?php 
include '../../config.php';

/*$regi =  json_decode('{"user_id":"150"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);
 if($regi){
	 $select_user_name = $con->query("SELECT * FROM `pa_users` Where id='".$regi->user_id."' AND user_role='vandor'"); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$val_user = $select_user_name->fetch_assoc();
		$array['error_code'] = 200;
		$array['message'] = 'Vendor found';

		if($val_user['profile_image']!=''){
			$val_user['profile_image'] = VENDOR_URL.$val_user['profile_image'];
		} else {
			$val_user['profile_image'] = '';
		}

		if($val_user['adhar_image']!=''){
			$val_user['adhar_image'] = VENDOR_URL.$val_user['adhar_image'];
		} else {
			$val_user['adhar_image'] = '';
		}

		if($val_user['pan_card_image']!=''){
			$val_user['pan_card_image'] = VENDOR_URL.$val_user['pan_card_image'];
		} else {
			$val_user['pan_card_image'] = '';
		}
		

		$vendor_id = $val_user['id'];
		$fare_final_array = array();
		$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id."");
		while($fare_row=$select_fare_query->fetch_assoc())
		{ 
			$veh_type = $fare_row['veh_type'];
			$initial_hr = $fare_row['initial_hr'];
			$ending_hr = $fare_row['ending_hr'];
			$amount = $fare_row['amount'];
			$hr_status = $fare_row['hr_status'];
			$fare_array['initial_hr'] = $initial_hr;
			$fare_array['ending_hr'] = $ending_hr;
			$fare_array['amount'] = $amount;
			$fare_array['hr_status'] = $hr_status;
			$fare_final_array[$veh_type][] = $fare_array;
		}
		$val_user['fare_info_price'] = $fare_final_array;

		$array['result'] = $val_user;
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Vendor not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);