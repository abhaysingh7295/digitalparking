<?php  require_once '../../config.php';

/*$regi =  json_decode('{
"user_id":"150",
"vehicle_number":"RJ14DE1752"
}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$vendor_id = $regi->user_id;
	$vehicle_number = $regi->vehicle_number;
	$status = 'Booked';

	$select_vehicle = $con->query("SELECT pb.*, u.first_name, u.last_name, u.mobile_number FROM `vehicle_pre_booking` as pb JOIN pa_users as u on pb.customer_id = u.id Where pb.vendor_id='".$vendor_id."' AND pb.vehicle_number='".$vehicle_number."' AND pb.status='".$status."'");
	if($select_vehicle->num_rows==1) {
		$vehicle_row = $select_vehicle->fetch_assoc();
		$vehicle_row['pre_booking_id'] = $vehicle_row['id'];
		$array['error_code'] = 200;
		$array['result'] = $vehicle_row;
		$array['message'] = 'Vehicle Online Booking Found';
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Vehicle Not Online Booking Found';
	}
}  else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray); echo '</	pre>';
echo json_encode($finalarray);