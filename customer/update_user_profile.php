<?php 
include '../config.php';
include 'function.php';

/*$regi =  json_decode('{"customer_id":"65",
"first_name":"Deepak",
"last_name":"Sharma",
"address":"jaipur",
"state":"raj",
"city":"jaipur"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	 $select_user_name = $con->query("SELECT * FROM `pa_users` Where id='".$regi->customer_id."' AND user_role='customer'"); 
	 $numrows_username = $select_user_name->num_rows;
	if ($numrows_username > 0) {
		$customer_id = $regi->customer_id;
		$first_name = $regi->first_name;
		$last_name = $regi->last_name;
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
					$NewFileName = $filename;
				} 
	 		}

	 		$profile_update ="update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', address = '".$address."', state = '".$state."', city = '".$city."', profile_image = '".$filename."' where id = '".$customer_id."'";
		} else {
			$profile_update ="update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', address = '".$address."', state = '".$state."', city = '".$city."' where id = '".$customer_id."'";
		}


		if ( $con->query($profile_update) === TRUE) {
			$array['error_code'] = 200;
			$array['message'] = 'Customer Profile Updated';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}	
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Customer not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);