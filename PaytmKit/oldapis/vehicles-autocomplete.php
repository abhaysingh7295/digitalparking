<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];

$select_vehicle = $con->query("SELECT vehicle_number FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_status = 'In' ORDER BY id DESC");

	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle > 0) {
		$val_vehicle= array();
		while($row=$select_vehicle->fetch_assoc())
		{
			$val_vehicle[] = $row;
		}
		$error_code = 200;
		$array['error_code'] = 200;
		$array['message'] = 'Vehicles Search Successfully';
		$array['val_vehicle'] = $val_vehicle;
	} else {
		$array['error_code'] = 501;
		$array['message'] = 'Vehicles Not Found';
	}


$finalarray['result'] = $array;
echo json_encode($finalarray);