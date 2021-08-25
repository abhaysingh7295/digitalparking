<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$area = $_REQUEST['area'];
$landmark = $_REQUEST['landmark'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$country = $_REQUEST['country'];
$pincode = $_REQUEST['pincode'];
$parking_capacity_2 = $_REQUEST['parking_capacity_2'];
$parking_capacity_3_4 = $_REQUEST['parking_capacity_3_4'];

$select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
	$val_place = $select_place->fetch_assoc();
	$numrows_place = $select_place->num_rows;
	if($numrows_place==0) {
	    $insert_query = "INSERT INTO place_info(user_id,area,landmark,city,state,country,pincode,parking_capacity_2,parking_capacity_3_4) VALUES('$user_id','$area','$landmark','$city','$state','$country','$pincode','$parking_capacity_2','$parking_capacity_3_4')";
	    
	    if ($con->query($insert_query) === TRUE) {
	    	$error_code = 200;
			$array['error_code'] = 200;
			$array['message'] = 'Place Info Added Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} /* else {
	   $insert_query = "update `place_info` SET area = '".$area."', landmark = '".$landmark."', city = '".$city."',state = '".$state."',country = '".$country."',pincode = '".$pincode."',parking_capacity_2 = '".$parking_capacity_2."',parking_capacity_3_4 = '".$parking_capacity_3_4."' where user_id = '".$user_id."'";
	    if ($con->query($insert_query) === TRUE) {
	    	$error_code = 200;
			$array['error_code'] = 200;
			$array['message'] = 'Place Info Updated Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	}*/
	
	if($error_code == 200){
		$select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
		$numrows_place = $select_place->num_rows;
			if($numrows_place==1) {
				$val_place = $select_place->fetch_assoc();
			    $array['place_info'] = $val_place;
			}	
	}
	

$finalarray['result'] = $array;
echo json_encode($finalarray);	