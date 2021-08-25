<?php  require_once '../config.php';


//$regi =  json_decode('{"customer_id":"165"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$customer_id = $regi->customer_id;
	$select_vehicle = $con->query("SELECT * FROM `customer_vehicle` Where customer_id=".$customer_id." ORDER BY id DESC");
	$numrows_vehicle = $select_vehicle->num_rows;
	$finalArray = array();
	if ($numrows_vehicle > 0) {
		while($row=$select_vehicle->fetch_assoc())
		{
			$array = array();
			$array['id'] = $row['id'];
			$array['unique_vehicle_code'] = $row['unique_vehicle_code'];
			$array['vehicle_id'] = $row['id'];
			$array['customer_id'] = $row['customer_id'];
			$array['vehicle_number'] = $row['vehicle_number'];
			$array['vehicle_type'] = $row['vehicle_type'];

			if($row['vehicle_photo']!=''){
				$vehicle_photo = UPLOAD_URL.$row['vehicle_photo'];
			} else {
				$vehicle_photo = '';
			}
			$array['vehicle_photo'] = $vehicle_photo;

			if($row['vehicle_rc']!=''){
				$vehicle_rc = UPLOAD_URL.$row['vehicle_rc'];
			} else {
				$vehicle_rc = '';
			}
			$array['vehicle_rc'] = $vehicle_rc;
			$array['date_time'] = date('d-m-Y h:i A',$row['date_time']);

			$VehicleArray[] = $array;
		}

		$finalArray['error_code'] = 200;
		$finalArray['vehicles'] = $VehicleArray;
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