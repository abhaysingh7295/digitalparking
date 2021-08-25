<?php 
include '../config.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);

//$regi =  json_decode('{"mobile_number":"9782303930"}');

if($regi){
	$select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$regi->mobile_number."' AND user_role = 'customer'");
	$numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
	    $array['error_code'] = 400;
		$array['message'] = 'Mobile Number already Registered';
	} else {
		$array['error_code'] = 200;
		$array['message'] = 'Mobile Number Not Registered';
	}

} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$resparray['response'] = $array;
echo json_encode($resparray);
//echo '<pre>'; print_r($resparray);