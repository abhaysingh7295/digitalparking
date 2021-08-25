<?php 
include '../config.php';

//$regi =  json_decode('{"customer_id":"182"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$customer_id = $regi->customer_id;
	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id=".$customer_id." ORDER BY id DESC");
	$numrows_vehicle = $select_vehicle->num_rows;
	$finalArray = array();
	if ($numrows_vehicle > 0) {
		while($row=$select_vehicle->fetch_assoc())
		{
			$array = array();
			$id = $row['id'];
			$vendor_id = $row['vendor_id'];	
			$vehicle_status = $row['vehicle_status'];
			$vehicle_number = $row['vehicle_number'];
			$array['id'] = $row['id'];
			$array['vehicle_status'] = $vehicle_status;
			$array['vehicle_number'] = $vehicle_number;
			$array['vehicle_type'] = $row['vehicle_type'];
			$array['booking_type'] = $row['parking_type'];
			$array['qr_type'] = $row['qr_type'];
			$array['vehicle_in_date_time'] = date('Y-m-d h:i A',$row['vehicle_in_date_time']);
			if($vehicle_status=='In'){
				$currentTime = time();
				$diff = abs($currentTime - $row['vehicle_in_date_time']);	
			} else {
				$array['vehicle_out_date_time'] = date('Y-m-d h:i A',$row['vehicle_out_date_time']);
				$diff = abs($row['vehicle_out_date_time'] - $row['vehicle_in_date_time']);
			}

			$fullDays    = floor($diff/(60*60*24));   
			$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
			$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
			$array['vehicle_in_diff'] = $fullDays.' Day, '. $fullHours.' Hours, '.$fullMinutes.' Minutes';
			$array['time_in_days'] = $fullDays;
			$array['time_in_hours'] = $fullHours;
			$array['time_in_minutes'] = $fullMinutes;

			$finalpayment = array();
			$select_payment = $con->query("SELECT * FROM `payment_history` Where booking_id=".$id." ORDER BY id DESC");
			if ($select_payment->num_rows > 0){
				while($row_payment=$select_payment->fetch_assoc())
				{	$payment_array = array();
					$payment_array['id'] = $row_payment['id'];
					$payment_array['amount'] = $row_payment['amount']; 
					$payment_array['payment_type'] = $row_payment['payment_type'];
					$payment_array['transaction_id'] = $row_payment['transaction_id'];
					$payment_array['payment_date_time'] = date('Y-m-d h:i A', $row_payment['payment_date_time']);
					$finalpayment[] = $payment_array;
				}
				$array['payment_history'] = $finalpayment;
			}

			$select_vendor = $con->query("SELECT id as vendor_id,first_name,last_name,mobile_number,parking_name,address,state,city FROM `pa_users` Where id=".$vendor_id."");
			$row_vendor=$select_vendor->fetch_assoc();
			$array['vendor_details'] = $row_vendor;

			$VehicleArray[] = $array;
		}
		$finalArray['error_code'] = 200;
		$finalArray['vehicle_history'] = $VehicleArray;
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'No Vehicle Booking found';
	}
} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);

//echo '<pre>'; print_r($resparray);