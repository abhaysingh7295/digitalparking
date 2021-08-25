<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$vehicle_number = $_REQUEST['vehicle_number'];
$due_amount = $_REQUEST['due_amount'];
$to_pay_amount = $_REQUEST['to_pay_amount'];
$vehicle_out_date_time = date('Y-m-d H:i:s');
$vehicle_status = 'Out';

$aqled = "update `vehicle_book` SET due_amount = '".$due_amount."', to_pay_amount = '".$to_pay_amount."', vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where user_id = ".$user_id." AND vehicle_number = '".$vehicle_number."' AND vehicle_status='In'";

$ress = $con->query($aqled);
	 if($ress){
	 	$array['error_code'] = 200;
		$array['message'] = 'Vehicle Checkout Successfully';
	 } else {
	$array['error_code'] = 400;
	$array['message'] = 'Some occurred error';
}

$finalarray['result'] = $array;
echo json_encode($finalarray);