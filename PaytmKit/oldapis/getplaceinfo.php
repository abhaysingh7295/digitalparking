<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];

	$select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
	$numrows_place = $select_place->num_rows;
	if($numrows_place==1) {
	$val_place = $select_place->fetch_assoc();
    $array['error_code'] = 200;
    $array['message'] = 'place Info Successfully';
    $array['place_info'] = $val_place;

	} else{
	    $array['error_code'] = 400;
		$array['message'] = 'No Place Info Found';
	}
	
	$finalarray['result'] = $array;
echo json_encode($finalarray);