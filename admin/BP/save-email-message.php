<?php 
include 'config.php';

if(isset($_POST['submit'])){
$subject = $_POST['subject'];
$message = $_POST['message'];
$date_time = date('Y-m-d H:i:s');
$status = $_POST['status'];
$insert_query = "INSERT INTO `email_notification_messages` (subject,message,date_time,status) VALUES ('$subject','$message','$date_time','$status')";
if ($con->query($insert_query) === TRUE) {
    header('location:all-email-messages.php');
} 
}