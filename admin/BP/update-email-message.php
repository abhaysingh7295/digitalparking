<?php 
include 'config.php';

if(isset($_POST['update'])){
$id = $_POST['id'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$status = $_POST['status'];
$insert_query = "update `email_notification_messages`  SET subject = '".$subject."',message = '".$message."', status = '".$status."' where id = '".$id."'";
if ($con->query($insert_query) === TRUE) {
    header('location:all-email-messages.php');
} 
}