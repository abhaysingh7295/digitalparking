<?php 
include 'config.php';

$email = $_REQUEST['email'];

$password = $_REQUEST['password'];
 

$select_query = $con->query("SET NAMES utf8");
	 $select_query = $con->query("SELECT * FROM `pa_users` where user_email='".$email."' AND user_pass='".$password."'");
	 if($row = $select_query->fetch_assoc()) {
	 	if($row['user_status']==0){
	 		$array['error_code'] = 500;
			$array['message'] = 'Sorry You can\'t login. Your Account has been deactivated. Please contact to Admin for Activate your account.';
	 	} else {
		 	$array['error_code'] = 200;
			$array['message'] = 'Login Successfully';
			$array['user_id'] = $row['id'];
			$array['user_email'] = $row['user_email'];
			$array['first_name'] = $row['first_name'];
			$array['last_name'] = $row['last_name'];
			$array['mobile_number'] = $row['mobile_number'];
			$array['date_of_birth'] = $row['date_of_birth'];
			$array['os'] = $row['os'];
			$array['social_type'] = $row['social_type'];
			$array['user_role'] = $row['user_role'];
			$array['user_status'] = $row['user_status'];
			$array['register_date'] = $row['register_date'];
			$array['referral_code'] = $row['referral_code'];
	}

 } else{
 	$array['error_code'] = 400;
	$array['message'] = 'Oops! The details you entered were incorrect.';
 }

$finalarray['result'] = $array;
echo json_encode($finalarray);

<body>
<html>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 6 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-5004041286650700"
     data-ad-slot="8747536832"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>