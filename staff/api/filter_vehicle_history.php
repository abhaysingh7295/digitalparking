<?php 
include '../../config.php';
//include '../../administration/functions.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);

//$regi =  json_decode('{"staff_id":"75", "vendor_id":"150", "start_date":"2020-06-01", "end_date":"2020-08-30"}');
$currentdate = date('Y-m-d');

if($regi){
	$staff_id = $regi->staff_id;
	$vendor_id = $regi->vendor_id;

	/*	if($active_plans_row['report_export_capacity'] > 0){
		$start_date = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
		$end_date = $currentdate;
	} else {
		$start_date = $currentdate;
		$end_date = $currentdate;
	}*/


	$start_date = $regi->start_date;
	$end_date = $regi->end_date;

	
	$select_vehicle = $con->query("SELECT count(vb.vehicle_type) as total_vehicles, vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select staff_id, booking_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' AND staff_id = ".$staff_id." GROUP BY booking_id) as ph ON ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND (vb.staff_in = ".$staff_id." OR vb.staff_out = ".$staff_id.") AND vb.`staff_vehicle_type`='no' GROUP BY vb.vehicle_type");
 	$numrows_vehicle = $select_vehicle->num_rows;
 	$finalArray = array();
	if ($numrows_vehicle > 0) {
		while($row=$select_vehicle->fetch_assoc())
		{
			$total_vehicles = $row['total_vehicles'];
			$vehicle_type = $row['vehicle_type'];
			$total_booking_amount = $row['total_booking_amount'];
			$array = array();
			$array['vehicle_type'] = $vehicle_type;
			$array['total_vehicles'] = $total_vehicles;
			$array['total_booking_amount'] = $total_booking_amount;
			$VehicleArray[] = $array;
		}

		//$arrayNew['vehicle_history'] = $VehicleArray;
		$finalArray['error_code'] = 200;
		$finalArray['result'] = $VehicleArray;
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'No Vehicle Booking found';
	}
	

	$select_vehicle_staff = $con->query("SELECT count(vb.vehicle_type) as total_vehicles, vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select staff_id, booking_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' AND staff_id = ".$staff_id." GROUP BY booking_id) as ph ON ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND (vb.staff_in = ".$staff_id." OR vb.staff_out = ".$staff_id.") AND vb.`staff_vehicle_type`='yes' GROUP BY vb.vehicle_type");
	$staff_vehicle = $select_vehicle_staff->num_rows;
	if ($staff_vehicle > 0) {
		while($row=$select_vehicle_staff->fetch_assoc())
		{
			$total_staff_vehicles = $row['total_vehicles'];
			$vehicle_staff_type = $row['vehicle_type'];
			$total_staff_booking_amount = $row['total_booking_amount'];
			$staff_array = array();
			$staff_array['vehicle_type'] = $vehicle_staff_type;
			$staff_array['total_vehicles'] = $total_staff_vehicles;
			$staff_array['total_booking_amount'] = $total_staff_booking_amount;
			$StaffVehicleArray[] = $staff_array;
		}
		//$arrayNew['vehicle_history'] = $VehicleArray;
		$finalArray['Staff'] = $StaffVehicleArray;
	} 

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);

//echo '<pre>'; print_r($resparray);
