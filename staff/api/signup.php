<?php 

include '../../config.php';
include '../../administration/functions,php';


if(isset($_POST['submit'])){
  
    
    
    
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

$email = $_POST['email'];

 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['forget_time'] = time();
	$_SESSION['forget_successfully'] = 'Invalid email format please try to correct email address.';
	$_SESSION['forget_alert'] = 'alert-danger';
	
} else {
if($cpassword==$password){

$password = $password;
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$user_role = 'vendor';
$user_status  = 1;
$register_date  = date('Y-m-d h:i:s');

$social_type  = 'simple';
$os  = 'android';
$mobile_number  = $_POST['mobile_number'];
$date_of_birth  = '';

 $reflength = 10;
 $refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 $referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
               
 	$select_user_name = $con->query("SELECT * FROM `pa_users` Where user_email='".$email."'"); 
	$val_user = $select_user_name->fetch_assoc();
	$numrows_username = $select_user_name->num_rows;

	if($numrows_username==0) {
		$insert_query = "INSERT INTO pa_users(user_email,user_pass,first_name,last_name,mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code) VALUES('$email','$password','$first_name','$last_name','$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code')";
		if ($con->query($insert_query) === TRUE) {
			$user_id = $con->insert_id;
			$amount = 50;
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
             $finalArray['error_code'] = 200;
   			$finalArray['message'] = 'Registration Successfully';
 
		} else {

        $finalArray['error_code'] = 400;
   		$finalArray['message'] = 'Some occurred error';
		}
	} else{
    	$finalArray['error_code'] = 400;
    	$finalArray['message'] = 'Email already Registered';
	}

} else {
    $finalArray['error_code'] = 400;
   	$finalArray['message'] = 'Password Not matched please try again.';
}

}
}


    
	




