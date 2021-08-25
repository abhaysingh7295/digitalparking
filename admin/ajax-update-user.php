<?php

include('config.php');
 
$user_id = $_POST['id'];

$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$col0 = $_POST['first_name'];
$col1 = $_POST['last_name'];
$col2 = $password;
$col3 = $_POST['os'];
$col4 = $_POST['user_email'];
 
$col7 = $_POST['date_of_birth'];
$wallet_amount = $_POST['wallet_amount'];
 


if($password!=''){
if($cpassword==$password){
	
$aqled = "update `pa_users` SET first_name = '".$col0."', last_name = '".$col1."', user_email = '".$col4."', user_pass = '".$col2."', os = '".$col3."', date_of_birth = '".$col7."', wallet_amount = '".$wallet_amount."' where id = ".$user_id;
	 $ress = $con->query($aqled);
	 if($ress){
echo 'User Update Successfully';
	 }
} else {
	echo 'Password Does Not Match Please fill correct Password'; 
}
} else {
$aqled = "update `pa_users` SET first_name = '".$col0."', last_name = '".$col1."', user_email = '".$col4."', os = '".$col3."', date_of_birth = '".$col7."', wallet_amount = '".$wallet_amount."' where id = ".$user_id;

	$ress = $con->query($aqled);
	 if($ress){
echo 'User Update Successfully';
	
	 }
}