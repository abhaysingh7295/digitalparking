<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];

$select_query = $con->query("SELECT * FROM `staff_details` WHERE user_id = ".$user_id." ORDER BY staff_id DESC");

	$numrows_query = $select_query->num_rows;
	if($numrows_query > 0) {
		$val_staff= array();
		while($row=$select_query->fetch_assoc())
		{
			$val_staff[] = $row;
		}
		$error_code = 200;
		$array['error_code'] = 200;
		$array['message'] = 'Staffs Found Successfully';
		$array['val_staff'] = $val_staff;
	} else {
		$array['error_code'] = 501;
		$array['message'] = 'Staff Not Found';
	}


$finalarray['result'] = $array;
echo json_encode($finalarray);