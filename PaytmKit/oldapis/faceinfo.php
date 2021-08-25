<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$hourly = 'Yes';
$h_two_wheeler = $_REQUEST['h_two_wheeler'];
$h_three_wheeler = $_REQUEST['h_three_wheeler'];
$h_four_wheeler = $_REQUEST['h_four_wheeler'];
$h_extra_amount = 0;

$days = 'Yes';
$d_two_wheeler = $_REQUEST['d_two_wheeler'];
$d_three_wheeler = $_REQUEST['d_three_wheeler'];
$d_four_wheeler = $_REQUEST['d_four_wheeler'];

$select_face = $con->query("SELECT * FROM `face_info` Where user_id='".$user_id."'"); 
	$val_face = $select_face->fetch_assoc();
	$numrows_face = $select_face->num_rows;
	if($numrows_face==0) {
	    $insert_query = "INSERT INTO face_info(user_id,hourly,h_two_wheeler,h_three_wheeler,h_four_wheeler,h_extra_amount,days,d_two_wheeler,d_three_wheeler,d_four_wheeler) VALUES('$user_id','$hourly','$h_two_wheeler','$h_three_wheeler','$h_four_wheeler','$h_extra_amount','$days','$d_two_wheeler','$d_three_wheeler','$d_four_wheeler')";
	    
	    if ($con->query($insert_query) === TRUE) {
	    	$error_code = 200;
			$array['error_code'] = 200;
			$array['message'] = 'Face Info Added Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} /* else {
	   $insert_query = "update `face_info` SET hourly = '".$hourly."', h_two_wheeler = '".$h_two_wheeler."', h_three_wheeler = '".$h_three_wheeler."',h_four_wheeler = '".$h_four_wheeler."',h_extra_amount = '".$h_extra_amount."',days = '".$days."',d_two_wheeler = '".$d_two_wheeler."',d_three_wheeler = '".$d_three_wheeler."', d_four_wheeler = '".$d_four_wheeler."' where user_id = '".$user_id."'";
	    if ($con->query($insert_query) === TRUE) {
	    	$error_code = 200;
			$array['error_code'] = 200;
			$array['message'] = 'Face Info Updated Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} */
	
	if($error_code == 200){
		$select_face = $con->query("SELECT * FROM `face_info` Where user_id='".$user_id."'"); 
		$numrows_face = $select_face->num_rows;
		if($numrows_face==1) {
			$val_face = $select_face->fetch_assoc();
		    $array['error_code'] = 200;
		    $array['message'] = 'Face Info Successfully';
		    $array['face_info'] = $val_face;
		}
	}
$finalarray['result'] = $array;
echo json_encode($finalarray);	