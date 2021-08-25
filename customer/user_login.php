<?php 
include '../config.php';

$request = $_REQUEST['request'];
$regi =  json_decode($request);

 //$regi =  json_decode('{"mobile_number":"9782303930","otp":"276934"}');
 $select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$regi->mobile_number."' AND user_role='customer'"); 
 $numrows_username = $select_user_name->num_rows;
if($regi){
	if ($numrows_username > 0) {
		$val_user = $select_user_name->fetch_assoc();
			if($val_user['user_pass']==$regi->otp){
				if($val_user['user_status']==0){
					$profile_update = $con->query("update `pa_users` SET user_status = 1 where id = ".$val_user['id']."");
				}

				$select_pre_payments = $con->query("SELECT * FROM `monthly_pass_pre_payment` Where customer_id=".$val_user['id'].""); 
				$numrows_username = $select_pre_payments->num_rows;
				if ($numrows_username > 0) {
					$val_user['digital_card_pre_payment'] = 'Yes';
				} else {
					$val_user['digital_card_pre_payment'] = 'No';
				}
                
                $message = 'Dear '.$val_user['first_name'].' you account is logged in. Thankyou The Digital Parking Team.';
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "http://webmsg.smsbharti.com/app/smsapi/index.php?key=25EE104B6291EC&campaign=0&routeid=9&type=text&contacts=".$regi->mobile_number."&%20senderid=PREKIN&msg=".$message,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "Cache-Control: no-cache"
                ),
              ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
                
				$array['error_code'] = 200;
				$array['result'] = $val_user;
				$array['message'] = 'User Login Successfully';
			} else {
				$array['error_code'] = 400;
				$array['message'] = 'OTP Not Match';
			}
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Mobile Number not found';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
//print_r($finalarray);
echo json_encode($finalarray);