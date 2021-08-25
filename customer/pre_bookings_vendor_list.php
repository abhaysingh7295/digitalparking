<?php include '../config.php'; 
include '../administration/functions.php';
$request = $_REQUEST['request'];
$regi =  json_decode($request);
//$regi =  json_decode('{"customer_id":"165"}');
if($regi){
	$activate_subscriptions_plans = $con->query("select vs.vendor_id,v.parking_name, v.parking_type, v.latitude, v.longitude, v.user_email, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name from `vendor_subscriptions` as vs JOIN pa_users as v on vs.vendor_id = v.id where vs.status = 1 AND vs.pre_booking = 1 AND v.user_role = 'vandor'");
	$numrows_subscriptions = $activate_subscriptions_plans->num_rows;
	if ($numrows_subscriptions > 0) {
		while($active_plans_row=$activate_subscriptions_plans->fetch_assoc())
		{
			$vendor_id = $active_plans_row['vendor_id'];
			if($active_plans_row['parking_name']){
				$parking_name = $active_plans_row['parking_name'];
			} else {
				$parking_name = $active_plans_row['vendor_name'];
			}
			
			$parking['parking_id'] = $vendor_id;
			$parking['parking_name'] = $parking_name;
			$parking['parking_type'] = $active_plans_row['parking_type'];
			$parking['latitude'] = $active_plans_row['latitude'];
			$parking['longitude'] = $active_plans_row['longitude'];

			$active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
			if($active_plans_row['fare_info'] > 0){
				$fare_final_array = array();
				$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND hr_status = 'bs_fare'");
				while($fare_row=$select_fare_query->fetch_assoc())
				{ 
					$veh_type = $fare_row['veh_type'];
					$initial_hr = $fare_row['initial_hr'];
					$ending_hr = $fare_row['ending_hr'];
					$amount = $fare_row['amount'];
					$hr_status = $fare_row['hr_status'];
					$fare_array['veh_type'] = $veh_type;
					$fare_array['initial_hr'] = $initial_hr;
					$fare_array['ending_hr'] = $ending_hr;
					$fare_array['amount'] = $amount;
					$fare_array['hr_status'] = $hr_status;
					$fare_final_array[$veh_type][] = $fare_array;
				}
				$parking['fare_info_price'] = $fare_final_array;
			}

			$listwithparking[] = $parking;
		}
		$parking_list['parking_list'] = $listwithparking;
		$array['error_code'] = 200;
		$array['message'] = 'Parkings for Online Booking';
		$array['result'] = $parking_list;

	} else {
		$array['error_code'] = 400;
		$array['message'] = 'No any Parkings for Online Booking';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray); echo '</pre>';
echo json_encode($finalarray);