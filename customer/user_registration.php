<?php 
include '../config.php';
include 'function.php';


/*$regi =  json_decode('{"email":"deepak2@gmail.com",
"name":"Deepak",
"mobile_number":"9874563211",
"address":"jaipur",
"state":"raj",
"city":"jaipur"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

 $otplength = 6;
 $otpchars = "0123456789";
 $otp_code = substr( str_shuffle( $otpchars ), 0, $otplength );

$password = $otp_code;
$cpassword = $otp_code;

$email = $regi->email;

$sendmessage = 'OTP For Sign Up : '.$password;
$message = urlencode($sendmessage);


$select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$regi->mobile_number."' AND user_role = 'customer'"); 
$numrows_username = $select_user_name->num_rows;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $array['error_code'] = 503;
	$array['message'] = 'Invalid email format please try to correct email address.';
	
} else if ($numrows_username > 0) {
    $array['error_code'] = 503;
	$array['message'] = 'Mobile Number already Registered';
	
} else {
	$password = $password;
	$first_name = $regi->name;
	$last_name = '';
	$mobile_number  = $regi->mobile_number;
	$address  = $regi->address;
	$state  = $regi->state;
	$city  = $regi->city;
	$user_role = 'customer';
	$user_status  = 0;
	$register_date  = date('Y-m-d h:i:s');
	$social_type  = 'simple';
	$os  = 'android';

	$date_of_birth  = '';

 	$reflength = 10;
 	$refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 	$referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
               
 	$select_user_name = $con->query("SELECT * FROM `pa_users` Where user_email='".$email."' AND user_role = 'customer'"); 
	$numrows_username = $select_user_name->num_rows;

	if($numrows_username==0) {
		$insert_query = "INSERT INTO pa_users(user_email,user_pass,first_name,last_name,mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code,address,state,city) VALUES('$email','$password','$first_name','$last_name','$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code','$address','$state','$city')";
		if ($con->query($insert_query) === TRUE) {
			$user_id = $con->insert_id;

			//SendSMS($mobile_number, $message);

			/*$amount = 0;
			$num0 = (rand(10,100));
			$num1 = date("Ymd");
			$num2 = (rand(100,1000));
			$transaction_id = $num0 . $num1 . $num2;
			$transaction_type = 'Trial';
			$transaction_remarks = 'New Vendor Registration Trial Amount '.$amount.'Rs / Ref. '. $transaction_id. ' / 15 Days';
			$wallet_date = date('Y-m-d H:i:s');
			$amount_type = 'Dr';
			$con->query("INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')");
			$con->query("update `pa_users` SET wallet_amount = '".$amount."' where id = ".$user_id);
			*/

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
}

$finalarray['response'] = $array;
echo json_encode($finalarray);