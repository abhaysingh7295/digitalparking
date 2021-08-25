<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){

$id = $_REQUEST['delete']; 
	
$sql = "DELETE FROM `email_notification_messages` WHERE id='".$id."'";

if ($con->query($sql) === TRUE) {

    header('location:all-email-messages.php');
} else {
    echo "Error deleting record: " ;
}
	
}
