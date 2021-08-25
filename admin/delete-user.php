<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){
	
$sql = "DELETE FROM `user` WHERE user_id='".$_REQUEST['delete']."'";

if ($con->query($sql) === TRUE) {

$con->query("DELETE FROM `user_play_list` WHERE user_id='".$_REQUEST['delete']."'");
$con->query("DELETE FROM `favourite` WHERE user_id='".$_REQUEST['delete']."'");
//$con->query("DELETE FROM `feedback` WHERE user_id='".$_REQUEST['delete']."'");

    header('location:all-users.php');
} else {
    echo "Error deleting record: " ;
}
	
}

if(isset($_REQUEST['subscription'])){
	
$sql1 = "UPDATE `user` set notification_subscription ='".$_REQUEST['subscription']."' WHERE user_id='".$_REQUEST['userid']."'";

if ($con->query($sql1) === TRUE) {
    header('location:all-users.php');
} else {
    echo "Error deleting record: " ;
}
	
}