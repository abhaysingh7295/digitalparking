<?php 
include '../../config.php';
include '../../administration/functions.php';


$request = $_REQUEST['request'];
$regi =  json_decode($request);

/*$regi =  json_decode('{"staff_id":"75", "vendor_id":"150", "start_date":"2020-06-01", "end_date":"2020-08-20"}');*/
$currentdate = date('Y-m-d');
if($regi){
	$vendor_id = $regi->vendor_id;
	$vehicle_number = $regi->vehicle_number;

	

	$select_vehicle = $con->query("SELECT vb.*, sdin.staff_name as in_staff_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as vb LEFT JOIN pa_users as v ON vb.vendor_id = v.id LEFT JOIN staff_details as sdin ON vb.staff_in = sdin.staff_id Where vb.vendor_id = ".$vendor_id." AND vb.vehicle_number like '%".$vehicle_number."%' AND vb.vehicle_status='In' ORDER BY vb.id DESC limit 5");

	//$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id=".$vendor_id." AND vehicle_status = 'In' AND (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");
	$numrows_vehicle = $select_vehicle->num_rows;
	$finalArray = array();
	if ($numrows_vehicle > 0) {
		while($row=$select_vehicle->fetch_assoc())
		{
			$array = array();
			$id = $row['id'];
			$customer_id = $row['customer_id'];
			$staff_in = $row['staff_in'];	
			$vehicle_status = $row['vehicle_status'];
			$vehicle_number = $row['vehicle_number'];
			$vehicle_type = $row['vehicle_type'];
			$staff_vehicle_type = $row['staff_vehicle_type'];
			$array['id'] = $row['id'];
			$array['customer_id'] = $customer_id;
			$array['staff_name'] = $row['in_staff_name'];
			$array['parking_name'] = $row['parking_name'];
			$array['parking_address'] = $row['parking_address'];
			$array['vehicle_status'] = $vehicle_status;
			$array['vehicle_number'] = $vehicle_number;
			$array['vehicle_type'] = $row['vehicle_type'];
			$array['qr_type'] = $row['qr_type'];
			$array['staff_vehicle_type'] = $staff_vehicle_type;
			$array['vehicle_in_date_time'] = date('d-m-Y h:i A',$row['vehicle_in_date_time']);
			if($vehicle_status=='In'){
				$currentTime = time();
				$diff = abs($currentTime - $row['vehicle_in_date_time']);	
			} else {
				$array['vehicle_out_date_time'] = date('d-m-Y h:i A',$row['vehicle_out_date_time']);
				$diff = abs($row['vehicle_out_date_time'] - $row['vehicle_in_date_time']);
			}

			$fullDays    = floor($diff/(60*60*24));   
			$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
			$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
			$array['vehicle_in_diff'] = $fullDays.' Day, '. $fullHours.' Hours, '.$fullMinutes.' Minutes';
			$array['time_in_days'] = $fullDays;
			$array['time_in_hours'] = $fullHours;
			$array['time_in_minutes'] = $fullMinutes;
			

			if($row['qr_type']=='monthly_pass'){
				$array['total_parking_price'] = 0;
				$array['due_parking_price'] = 0;
			} else {
				$fare_calculation = CalculateFareAmount($con,$vendor_id,$vehicle_number,$vehicle_type);
				$array['total_parking_price'] = $fare_calculation['total_parking_price'];
				$array['due_parking_price'] = $fare_calculation['due_parking_price'];
			}


			if($staff_vehicle_type=='yes'){
				$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND veh_type='Staff' AND hr_status = 'bs_fare' LIMIT 1");

			} else {
				$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND veh_type='".$row['vehicle_type']."' AND hr_status = 'bs_fare' LIMIT 1");
			}
			$fare_row=$select_fare_query->fetch_assoc();
			$array['base_fare_amount'] = $fare_row['amount'];
			$finalpayment = array();
			$select_payment = $con->query("SELECT * FROM `payment_history` Where booking_id=".$id." ORDER BY id DESC");
			
			if ($select_payment->num_rows > 0){
				$advance_amount = array();
				while($row_payment=$select_payment->fetch_assoc())
				{	$payment_array = array();
					$payment_array['id'] = $row_payment['id'];
					$payment_array['amount'] = $row_payment['amount']; 
					$payment_array['payment_type'] = $row_payment['payment_type'];
					$payment_array['transaction_id'] = $row_payment['transaction_id'];
					$payment_array['payment_date_time'] = date('d-m-Y h:i A', $row_payment['payment_date_time']);
					$finalpayment[] = $payment_array;

					$advance_amount[] = $row_payment['amount'];
				}
			
				$array['advance_amount'] = array_sum($advance_amount);
				$array['payment_history'] = $finalpayment;
			} else {
				$array['advance_amount'] = 0;
			}

			
			if($staff_vehicle_type=='yes'){
				$select_fares = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND veh_type='Staff'");
			} else {
				$select_fares = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND veh_type='".$row['vehicle_type']."'");
			}
			if ($select_fares->num_rows > 0){
				$fares_amount = array();
				while($row_fares=$select_fares->fetch_assoc())
				{
					$fares_amount[] = $row_fares;
				}

				$array['fares_info'] = $fares_amount;
			}


			$select_monthly_pass = $con->query("SELECT * FROM `monthly_pass` Where vendor_id='".$vendor_id."' AND vehicle_number = '".$vehicle_number."' AND status = 1 LIMIT 1");
	        if($select_monthly_pass->num_rows==1){
	            $row_monthly_pass=$select_monthly_pass->fetch_assoc();
	            $array['pass_status'] = 'Active';
	            $array['monthly_pass'] = $row_monthly_pass;
	        }
	        
			if($customer_id!=0){
				$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
				$row_customer=$select_customer->fetch_assoc();
				$array['customer_details'] = $row_customer;
			}

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