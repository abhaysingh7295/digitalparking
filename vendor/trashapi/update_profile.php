<?php 
include '../../config.php';

/*$regi =  json_decode('{"user_id":"65",
"first_name":"Deepak",
"last_name":"Sharma",
"parking_name":"Test",
"parking_type":"Hotels",
"address":"jaipur",
"landmark":"jaipur",
"state":"raj",
"city":"jaipur"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	 $select_user_name = $con->query("SELECT * FROM `pa_users` Where id='".$regi->user_id."' AND user_role='vandor'"); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$user_id = $regi->user_id;
		$first_name = $regi->first_name;
		$last_name = $regi->last_name;
		$parking_name = $regi->parking_name;
		$parking_type = $regi->parking_type;

		$address = $regi->address.' '.$regi->address;
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

	 		$profile_update ="update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', address = '".$address."', state = '".$state."', city = '".$city."', profile_image = '".$filename."', parking_name = '".$parking_name."', parking_type = '".$parking_type."' where id = '".$user_id."'";
		} else {
			$profile_update ="update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', address = '".$address."', state = '".$state."', city = '".$city."', parking_name = '".$parking_name."', parking_type = '".$parking_type."' where id = '".$user_id."'";
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