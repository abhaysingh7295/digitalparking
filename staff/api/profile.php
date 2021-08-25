<?php 
include '../../config.php';
include '../../administration/functions.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);
/*$regi =  json_decode('{"staff_id":"75"}');*/
 if($regi){
	 $select_user_name = $con->query("SELECT * FROM `staff_details` Where staff_id='".$regi->staff_id."'"); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$val_user = $select_user_name->fetch_assoc();
		$array['error_code'] = 200;
		$array['message'] = 'Staff found';

		if($val_user['profile_image']!=''){
			$val_user['profile_image'] = STAFF_UPLOAD.$val_user['profile_image'];
		} else {
			$val_user['profile_image'] = '';
		}
		
		$vendor_id = $val_user['vendor_id'];
		$active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
		$block_vechiles = GetVendorsBlockedVechiles($con,$vendor_id);

		$select_vendor = $con->query("SELECT * FROM `pa_users` Where id='".$vendor_id."' AND user_role='vandor'");
		if ($select_vendor->num_rows > 0) {
			$row_vendor = $select_vendor->fetch_assoc();
			if($row_vendor['parking_logo']!=''){
				$row_vendor['parking_logo'] = VENDOR_URL.$row_vendor['parking_logo'];
			} else {
				$row_vendor['parking_logo'] = '';
			}
			$val_user['vendor_details'] = $row_vendor;
		}
		
		if($active_plans_row['fare_info'] > 0){
			$fare_final_array = array();
			$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." ORDER BY initial_hr ASC");
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
		}

		if(sizeof($active_plans_row) > 0){
			$val_user['vendor_active_plan'] = $active_plans_row;
		}
		if(sizeof($block_vechiles) > 0){
			$val_user['block_vehicles'] = $block_vechiles;
		}

		$array['result'] = $val_user;
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Staff not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);