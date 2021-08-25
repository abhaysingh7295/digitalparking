<?php  require_once '../config.php';


//$regi =  json_decode('{"customer_id":"165", "vehicle_id":"165"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$customer_id = $regi->customer_id;
	$vehicle_id = $regi->vehicle_id;
	$sql = "DELETE FROM `customer_vehicle` WHERE customer_id=".$customer_id." AND id =".$vehicle_id."";
	if ($con->query($sql) === TRUE) {
		$finalArray['error_code'] = 200;
		$finalArray['message'] = 'Vehicle deleted sussessfully';
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'Some error';
	}
} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);