<?php 
include '../../config.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);

 /*$regi =  json_decode('{"user_login":"9694449191","password":"12345"}');*/
 $select_user_name = $con->query("SELECT * FROM `pa_users` Where (mobile_number='".$regi->user_login."' OR user_email='".$regi->user_login."') AND user_role='vandor'"); 
 $numrows_username = $select_user_name->num_rows;

if ($numrows_username > 0) {
	$val_user = $select_user_name->fetch_assoc();
		if($val_user['user_pass']==$regi->password){
			if($val_user['user_status']==1){
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
				$array['error_code'] = 200;
				$array['result'] = $val_user;
				$array['message'] = 'User Login Successfully';
			} else {
				$array['error_code'] = 400;
				$array['message'] = 'You are Inactive User. Please Contact to Administration.';
			}
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Incorrect Password.';
		}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Incorrect Username Password';
}

$finalarray['response'] = $array;
//print_r($finalarray);
echo json_encode($finalarray);