<?php 
include '../config.php';
include 'function.php';

//$regi =  json_decode('{"mobile_number":"9782303930"}');

//print_r($regi); 

$request = $_REQUEST['request'];
$regi =  json_decode($request);

 $otplength = 6;
 $otpchars = "0123456789";
 $otp_code = substr( str_shuffle( $otpchars ), 0, $otplength );
$mobile_number = $regi->mobile_number;
if($mobile_number!=''){
	$select_user_name = $con->query("SELECT id,user_role FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role='customer'"); 
	$numrows_username = $select_user_name->num_rows;

	if ($numrows_username > 0) {
		$val_user = $select_user_name->fetch_assoc();
		if($val_user['user_role']=='customer'){
			$sendmessage = 'OTP : '.$otp_code;
			//$message = urlencode($sendmessage);
			//SendSMS($mobile_number, $message);
			
			$curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&sender_id=PREKIN&message=".urlencode('121426')."&variables_values=".urlencode("$otp_code.'  pOo6tTTbVw+'")."&route=dlt&numbers=".urlencode($mobile_number),
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                  ),
                ));
                
                curl_exec($curl);
                curl_error($curl);
                
                curl_close($curl);
			
			$con->query("update `pa_users` SET user_pass = '".$otp_code."' where mobile_number = '".$mobile_number."' AND user_role='customer'");
			$array['error_code'] = 200;
			$array['temp_otp'] = $otp_code;
			$array['message'] = 'OTP Send on Mobile Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Mobile Number not registered for customer';
		}
	} else {
		
		$email = '';
		$password = $otp_code;
    	$first_name = '';
    	$last_name = '';
    	$address  = '';
    	$state  = '';
    	$city  = '';
    	$user_role = 'customer';
    	$user_status  = 0;
    	$register_date  = date('Y-m-d h:i:s');
    	$reflength = 10;
     	$refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
     	$referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
    	$social_type  = 'simple';
    	$os  = 'android';
        $date_of_birth  = '';
        $profile_image = '';
		$adhar_image = '';
		$pan_card_image = '';
		$parking_logo = '';
		$wallet_amount = 0;
		$parking_name = '';
		$parking_type = '';
		$latitude = '';
		$longitude = '';
		$open_time = '';
		$close_time = '';
		$parking_capacity = 0;
		$online_booking_capacity = 0;
		
		
		
		$insert_query = "INSERT INTO pa_users(user_email,user_pass,first_name,last_name,mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code,profile_image,adhar_image,pan_card_image,parking_logo,wallet_amount,parking_name,parking_type,address,state,city,latitude,longitude,open_time,close_time,parking_capacity,online_booking_capacity) VALUES('$email','$password','$first_name','$last_name','$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code','$profile_image','$adhar_image','$pan_card_image','$parking_logo','$wallet_amount','$parking_name','$parking_type','$address','$state','$city','$latitude','$longitude','$open_time','$close_time','$parking_capacity','$online_booking_capacity')";
		
		$con->query($insert_query);
		
		$sendmessage = 'OTP : '.$otp_code;
		$message = urlencode($sendmessage);
		SendSMS($mobile_number, $message);
		$con->query("update `pa_users` SET user_pass = '".$otp_code."' where mobile_number = '".$mobile_number."' AND user_role='customer'");
		$array['error_code'] = 200;
		$array['temp_otp'] = $otp_code;
		$array['message'] = 'OTP Send on Mobile Successfully';
		
		/*$array['error_code'] = 400;
		$array['message'] = 'Mobile Number not found';*/
	
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Mobile Number Required';
}

$finalarray['response'] = $array;
echo json_encode($finalarray);