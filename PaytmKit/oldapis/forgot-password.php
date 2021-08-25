<?php  include 'config.php'; 
$email = $_REQUEST['email'];
$select_query = $con->query("SET NAMES utf8");
$select_query = $con->query("SELECT * FROM `pa_users` where user_email='".$email."'");
	if($row = $select_query->fetch_assoc()) { 
		$username = $row['first_name'];
		$passlength = 12;
		$passchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$pass_code = substr( str_shuffle( $passchars ), 0, $passlength );
		$to = $email;

		$aqled = "update `pa_users` SET user_pass = '".$pass_code."' where user_email = '".$email."'";
	 	$ress = $con->query($aqled);
	 	
		$subject = "Your Passowrd has been changed";
		$message = '
		Dear '.$username.', <br/>
		<br/>
		Your Password has been changed please note your new password with your login detials : <br/>
		Username / Email : '.$email.'<br/>
		Password : '.$pass_code.'<br/>

		Thank You<br/>
		Supporter Team<br/>
		';

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <info@amazingit.in>' . "\r\n";
		mail($to,$subject,$message,$headers);
		$array['error_code'] = 200;
		$array['message'] = 'Your new password has been sent you on your email address now can login with your new details.';
	} else{
		$array['error_code'] = 400;
		$array['message'] = 'Oops! The details you entered were incorrect.';
	}
$finalarray['result'] = $array;
echo json_encode($finalarray);