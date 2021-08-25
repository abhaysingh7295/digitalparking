<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];

$select_face = $con->query("SELECT * FROM `face_info` Where user_id='".$user_id."'"); 
	$numrows_face = $select_face->num_rows;
	if($numrows_face==1) {
	 $val_face = $select_face->fetch_assoc();
    $array['error_code'] = 200;
    $array['message'] = 'Face Info Successfully';
    $array['face_info'] = $val_face;

	} else{
	    $array['error_code'] = 400;
		$array['message'] = 'No Face Info Found';
	}
	
	$finalarray['result'] = $array;
echo json_encode($finalarray);