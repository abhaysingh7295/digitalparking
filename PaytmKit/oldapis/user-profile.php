<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$select_query = $con->query("SET NAMES utf8");
	 $select_query = $con->query("SELECT * FROM `pa_users` where id='".$user_id."'");
	 if($row = $select_query->fetch_assoc()) {
 	$array['error_code'] = 200;
	$array['message'] = 'Profile Successfully';
	$array['user_id'] = $row['id'];
	$array['user_email'] = $row['user_email'];
	$array['first_name'] = $row['first_name'];
	$array['last_name'] = $row['last_name'];
	$array['mobile_number'] = $row['mobile_number'];
	$array['date_of_birth'] = $row['date_of_birth'];
	$array['user_role'] = $row['user_role'];
 } else{
 	$array['error_code'] = 400;
	$array['message'] = 'Some occurred error.';
 }

$finalarray['result'] = $array;
echo json_encode($finalarray); 