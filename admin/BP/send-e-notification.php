<?php include 'config.php';

$select_users = $_POST['select_users'];
$users_message = $_POST['message'];

$select_message = $con->query("SELECT * FROM `email_notification_messages` where id = '".$users_message."'");
$row_message=$select_message->fetch_assoc();


$date_time = date('Y-m-d H:i:s');

foreach($select_users as $key => $select_users_id) {
$insert_query = $con->query("SET NAMES utf8");

$select_user = $con->query("SELECT * FROM `user` where user_id = '".$select_users_id."'");
$row_users=$select_user->fetch_assoc();


if($row_users['email']!='') {

$message_status = 'Send Successfully';

$to = $row_users['email'];
$subject = $row_message['subject'];

$message = $row_message['message'];

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <deepak_sharma@technosoftwares.com>' . "\r\n";

//mail($to,$subject,$message,$headers);
} else {

$message_status = 'Send Failed';

}

$insert_query = "INSERT INTO `email_notifications` (user_id,date_time,message,message_status) VALUES ('$select_users_id','$date_time','$users_message','$message_status')";
$con->query($insert_query);
}

header('location:all-email-notifications.php');