<?php  require_once '../config.php';
	include 'function.php';
	include '../administration/functions.php';
//$regi =  json_decode('{"qr_code":"61MEQS72Z5TIJF8"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$qr_code = $regi->qr_code;
	$select_vendor = $con->query("SELECT vendor_id,user_email,first_name,last_name,mobile_number,open_time,close_time,parking_name,address,city,state FROM `vendor_qr_codes` as qr JOIN pa_users as u ON qr.vendor_id = u.id  Where qr_code='".$qr_code."'"); 
	$numrows_vendor = $select_vendor->num_rows;
	if($numrows_vendor==1) {
		$vendor_row = $select_vendor->fetch_assoc();
		$vendor_id = $vendor_row['vendor_id'];
		if($vendor_row['open_time'] && $vendor_row['close_time']){
			$current_time = time();
			$open_time = strtotime($vendor_row['open_time']);
			$close_time = strtotime($vendor_row['close_time']);

			$block_vechiles = GetVendorsBlockedVechiles($con,$vendor_id);
			if(sizeof($block_vechiles) > 0){
				$vendor_row['block_vehicles'] = $block_vechiles;
			}
			
			if($current_time >= $open_time && $current_time < $close_time) {
				$array['error_code'] = 200;
				$array['message'] = 'Vendor Found Successfully';
				$array['vendor'] = $vendor_row;
			} else {
				$array['error_code'] = 400;
				$array['message'] = 'Parking Close Now. Please contact to Parking Vendor';
			}
			
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Parking Vendor Not set Open Close Time. Please contact to Parking Vendor';
		}
		
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Vendor Not Found Successfully';	
	}
}  else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
echo json_encode($finalarray);