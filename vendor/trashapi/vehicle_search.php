<?php 
include '../../config.php';

/*$regi =  json_decode('{ "user_id":"150",
	"vehicle_number":"RJ1234"}');*/
$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$vendor_id = $regi->user_id;
	$vehicle_number = $regi->vehicle_number;
	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle==1) {
		$row = $select_vehicle->fetch_assoc();
		$id = $row['id'];
		$customer_id = $row['customer_id'];	
		$vehicle_status = $row['vehicle_status'];
		$vehicle_number = $row['vehicle_number'];
		$array['id'] = $row['id'];
		$array['vehicle_status'] = $vehicle_status;
		$array['vehicle_number'] = $vehicle_number;
		$array['vehicle_type'] = $row['vehicle_type'];
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

			$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
			$row_customer=$select_customer->fetch_assoc();
			$array['customer_details'] = $row_customer;


		$finalArray['error_code'] = 200;
		$finalArray['result'] = $array;
		$finalArray['message'] = 'Vehicle Found';
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'Vehicle not in Parking';
	}

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}
$resparray['response'] = $finalArray;
echo json_encode($resparray);