<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$mobile_number  = $_REQUEST['mobile_number'];
$date_of_birth  = $_REQUEST['date_of_birth'];

$aqled = "update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', mobile_number = '".$mobile_number."', date_of_birth = '".$date_of_birth."' where id = ".$user_id;
//echo $aqled; die; 
$ress = $con->query($aqled);
	 if($ress){
	 	$array['error_code'] = 200;
		$array['message'] = 'Profile Updated Successfully';
	 } else {
	$array['error_code'] = 400;
	$array['message'] = 'Some occurred error';
}

$finalarray['result'] = $array;
echo json_encode($finalarray);