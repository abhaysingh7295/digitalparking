<?php include 'config.php';

include_once '../GCM.php';

$select_users = $_POST['select_users'];
$users_message = $_POST['message'];


$sender_id='12';

//print_r($select_users);

foreach($select_users as $key => $select_users_id) {


$gcm = new GCM();

$select_user = $con->query("SELECT * FROM `user` WHERE user_id='".$select_users_id."' AND os='android'");
$row_users=$select_user->fetch_assoc();

$receiver_id=$select_users_id;
$message=$users_message;
$deviceToken = $row_users['device_token'];
$registatoin_ids = array($deviceToken);

$badge=0;

$data = array('message' => $message , 'sender_id' => $sender_id, 'recipient_id' => $receiver_id , 'badge' => $badge);
$result = $gcm->send_notification($registatoin_ids, $data);

 echo $result;

}

 header('location:notifications.php');