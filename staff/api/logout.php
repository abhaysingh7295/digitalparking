<?php 
include '../../config.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);

/* $regi =  json_decode('{"staff_id":"75"}');*/

 if($regi){
 	$staff_id = $regi->staff_id;
 	$con->query("update `staff_details` SET login_status = 0 where staff_id = ".$staff_id);
 	$finalArray['error_code'] = 200;
	$finalArray['message'] = 'Logout';
 } else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);