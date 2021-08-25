<?php 
include '../config.php';

$vehicle_number = $_POST['vehicle_number'];
$vendor_id = $_POST['vendor_id'];

$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id=".$vendor_id." AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
if ($select_vehicle->num_rows > 0) {
	$row=$select_vehicle->fetch_assoc();
	$currentTime = time();
	$id = $row['id'];
	$vendor_id = $row['vendor_id'];	
	$vehicle_status = $row['vehicle_status'];
	$vehicle_number = $row['vehicle_number'];
	$vehicle_type = $row['vehicle_type'];
	$mobile_number = $row['mobile_number'];
	$array['booking_id'] = $row['id'];
	$array['vehicle_status'] = $vehicle_status;
	$array['mobile_number'] = $mobile_number;
	$array['vehicle_number'] = $vehicle_number;
	$array['vehicle_type'] = $vehicle_type;
	$array['vehicle_in_date_time'] = date('Y-m-d h:i A',$row['vehicle_in_date_time']);
	$array['vehicle_out_date_time'] = date('Y-m-d h:i A',$currentTime);
	$diff = abs($currentTime - $row['vehicle_in_date_time']);	
	$fullDays    = floor($diff/(60*60*24));   
	$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
	$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
	$array['vehicle_in_diff'] = $fullDays.' Day, '. $fullHours.' Hours, '.$fullMinutes.' Minutes';
	$array['time_in_days'] = $fullDays;
	$array['time_in_hours'] = $fullHours;
	$array['time_in_minutes'] = $fullMinutes;
	$select_payment = $con->query("SELECT sum(amount) AS previous_paid FROM `payment_history` Where booking_id=".$id."");
	$row_payment=$select_payment->fetch_assoc();
	$array['previous_paid'] = $row_payment['previous_paid'];

	$requestdata = json_encode(array(
	    'vehicle_number' => $vehicle_number,
	    'vendor_id' => $vendor_id,
	    'vehicle_type' => $vehicle_type,
	    'parking_status' => 'Out'
	));
 
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,SITE_URL."customer/get_vehicle_price.php"); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'request='.$requestdata.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$server_response =  json_decode($server_output);
	$response = $server_response->response;
	if($response->error_code==200){
		$array['error_code'] = $response->error_code;
		$array['total_parking_price'] = $response->total_parking_price;
		$array['due_parking_price'] = $response->due_parking_price;
	} else {
		$array['error_code'] = $response->error_code;
		$array['message'] = $response->message;
	}
	
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Vehicle Not Found';
}


echo json_encode($array);