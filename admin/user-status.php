<?php

include('config.php');
 
$user_id = $_GET['user_id'];
$status = $_GET['status'];
$return = $_GET['return'];

$aqled = "update `pa_users` SET user_status = '".$status."' where id = ".$user_id;
	 $ress = $con->query($aqled);
	 if($ress){
	 header('location:'.$return);
}