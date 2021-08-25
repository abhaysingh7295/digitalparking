<?php 
include '../../config.php';
//$regi =  json_decode('{"vehicle_type":"2W", "vendor_id":"150"}');
$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
    $vendor_id = $regi->vendor_id;
	$vehicle_type = $regi->vehicle_type;
    $select_fares = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." AND veh_type='".$vehicle_type."'");
	if ($select_fares->num_rows > 0){
		$fares_amount = array();
		while($row_fares=$select_fares->fetch_assoc())
		{
			$fares_amount[$row_fares['hr_status']][] = $row_fares;
		}

		$finalArray['fares_info'] = $fares_amount;
		$finalArray['error_code'] = 200;
		$finalArray['message'] = 'Vehicle Fare found';
	} else {
	    $finalArray['error_code'] = 400;
        $finalArray['message'] = 'Vehicle Fare not found';
	}
} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);
//echo '<pre>'; print_r($resparray);