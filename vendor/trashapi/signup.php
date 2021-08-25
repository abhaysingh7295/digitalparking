<?php 
include '../../config.php';
//include 'function.php';


/*$regi =  json_decode('{
"first_name":"Deepak",
"last_name":"Sharma",
"mobile_number":"9874563211",
"email":"deepak2@gmail.com",
"password":"12345",
"cpassword":"12345",
"parking_name":"Test",
"parking_type":"Hotels",
"address":"jaipur",
"landmark":"jaipur",
"state":"raj",
"city":"jaipur"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
$password = $regi->password;
$cpassword = $regi->cpassword;

$email = $regi->email;

$select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$regi->mobile_number."' AND user_role = 'vandor'"); 
$numrows_username = $select_user_name->num_rows;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $array['error_code'] = 400;
	$array['message'] = 'Invalid email format please try to correct email address.';
	
} else if ($numrows_username > 0) {
    $array['error_code'] = 400;
	$array['message'] = 'Mobile Number already Registered';
	
} else {
	$first_name = $regi->first_name;
	$last_name = $regi->last_name;
	$mobile_number  = $regi->mobile_number;
	$address  = $regi->address.' '.$regi->landmark;
	$state  = $regi->state;
	$city  = $regi->city;
	$user_role = 'vandor';
	$user_status  = 1;
	$register_date  = date('Y-m-d h:i:s');
	$social_type  = 'simple';
	$os  = 'android';
	$parking_name  = $regi->parking_name;
	$parking_type  = $regi->parking_type;
	$date_of_birth  = '';

if($password == $cpassword){


 	$reflength = 10;
 	$refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 	$referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
               
 	$select_user_name = $con->query("SELECT * FROM `pa_users` Where user_email='".$email."' AND user_role = 'vandor'"); 
	$numrows_username = $select_user_name->num_rows;

	if($numrows_username==0) {
		$insert_query = "INSERT INTO pa_users(user_email,user_pass,first_name,last_name,mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code,address,state,city,parking_name,parking_type) VALUES('$email','$password','$first_name','$last_name','$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code','$address','$state','$city','$parking_name','$parking_type')";
		if ($con->query($insert_query) === TRUE) {
			$user_id = $con->insert_id;
			$select_user_name = $con->query("SELECT * FROM `pa_users` Where id='".$user_id."'"); 
			$val_user = $select_user_name->fetch_assoc();

			$array['error_code'] = 200;
			//$array['temp_otp'] = $password;
			$array['message'] = 'Registration Successfully';
			$array['result'] = $val_user;
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} else{
		$array['error_code'] = 400;
		$array['message'] = 'Email already Registered';
	}
}  else{
		$array['error_code'] = 400;
		$array['message'] = 'Password Not Match';
	}
}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);