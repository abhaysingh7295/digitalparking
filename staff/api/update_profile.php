<?php 
include '../../config.php';

/*$regi =  json_decode('{"staff_id":"75",
"staff_name":"Deepak",
"address":"jaipur",
"state":"raj",
"city":"jaipur"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	 $select_user_name = $con->query("SELECT * FROM `staff_details` Where staff_id=".$regi->staff_id.""); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$user_id = $regi->staff_id;
		$staff_name = $regi->staff_name;
		$address = $regi->address;
		$state = $regi->state;
		$city = $regi->city;

		$filename = $_FILES['profile_image']['name'];
		$file_path = "../uploads/" .$filename;
		$NewFileName = '';
		if($_FILES['profile_image'])  {
		$file_type = $_FILES['profile_image']['type'];
			if(($file_type == 'image/gif') || ($file_type == 'image/jpeg') || ($file_type == 'image/jpg') || ($file_type == 'image/png')){  
	 			if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path))
	 			{
					$NewFileName = $file_path;
				} 
	 		}

	 		$profile_update ="update `staff_details` SET staff_name = '".$staff_name."', address = '".$address."', state = '".$state."', city = '".$city."', profile_image = '".$filename."' where staff_id = '".$user_id."'";
		} else {
			$profile_update ="update `staff_details` SET staff_name = '".$staff_name."', address = '".$address."', state = '".$state."', city = '".$city."' where staff_id = '".$user_id."'";
		}


		if ( $con->query($profile_update) === TRUE) {
			$array['error_code'] = 200;
			$array['message'] = 'User Profile Updated';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}	
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'User not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);