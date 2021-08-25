<?php 
include '../../config.php';
//$regi =  json_decode('{"staff_id":"75", "vendor_id":"150", "start_date":"2020-08-01", "end_date":"2020-08-26"}');
$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$vendor_id = $regi->vendor_id;
	$staff_id = $regi->staff_id;
	$start_date = $regi->start_date;
	$end_date = $regi->end_date;

	if($start_date && $end_date){
		$getstart = $start_date;
		$getend = $end_date;
	} else {
		$currentdate = date('Y-m-d');
		$getstart = $currentdate;
		$getend = $currentdate;
	}

	$select_total_vehicle = $con->query("SELECT fi.veh_type, fi.amount as bs_fare_amount, CASE WHEN pd.total_vehicle > 0 THEN pd.total_vehicle ELSE 0 END as total_vehicles, CASE WHEN pd.total_amount > 0 THEN pd.total_amount ELSE 0 END as advance_amount FROM `fare_info` as fi LEFT JOIN (SELECT vb.vehicle_type, count(vb.vehicle_type) total_vehicle, CASE WHEN sum(ph.amount) > 0 THEN sum(ph.amount) ELSE 0 END as total_amount FROM `vehicle_booking` as vb LEFT JOIN payment_history as ph on ph.booking_id = vb.id AND ph.payment_date_time = vb.vehicle_in_date_time Where vb.vendor_id=".$vendor_id." AND vb.staff_in = ".$staff_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."') GROUP BY vb.vehicle_type ORDER BY vb.vehicle_type ASC) as pd ON pd.vehicle_type = fi.veh_type WHERE fi.user_id = ".$vendor_id." AND fi.hr_status = 'bs_fare' GROUP BY fi.veh_type");

	if ($select_total_vehicle->num_rows > 0) {
		while($row=$select_total_vehicle->fetch_assoc())
		{
			$final_total_vehicle[] = $row;
		}

		$select_vendor = $con->query("SELECT parking_name, CONCAT_WS(' ', address,city,state) as parking_address FROM `pa_users` Where id='".$vendor_id."' AND user_role='vandor'");
		$row_vendor = $select_vendor->fetch_assoc();
 
 		$select_staff = $con->query("SELECT staff_name FROM `staff_details` Where staff_id=".$staff_id."");
 		$row_staff = $select_staff->fetch_assoc();

		$finalArray['error_code'] = 200;
		$finalArray['vehicle_history'] = $final_total_vehicle;
		$finalArray['parking_name'] = $row_vendor['parking_name'];
		$finalArray['parking_address'] = $row_vendor['parking_address'];
		$finalArray['staff_name'] = $row_staff['staff_name'];
		$finalArray['date_range'] = $getstart.' to '.$getend;
		$finalArray['message'] = 'Vehicle found';
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'No Vehicle found';
	}

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);
//echo '<pre>'; print_r($resparray);