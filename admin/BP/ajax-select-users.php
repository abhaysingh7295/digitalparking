<?php

include('config.php');

$alpha = $_REQUEST['alpha'];
$os = $_REQUEST['os'];


//echo "SELECT * FROM `user` where name LIKE '$alpha%' ORDER BY name ASC"; die;
if($os=='all') {
$select_user = $con->query("SELECT * FROM `user` where notification_subscription ='1' AND name LIKE '$alpha%' ORDER BY name ASC");
} else {
$select_user = $con->query("SELECT * FROM `user` where notification_subscription ='1' AND os ='$os' AND name LIKE '$alpha%' ORDER BY name ASC");
}
//echo $select_user->num_rows; die; 
if($select_user->num_rows > 0) { 
while($row_users=$select_user->fetch_assoc())
{ 

$select_user_last_msg = $con->query("SELECT *,email_notifications.date_time as recent_send_time, email_notifications.message as message_id  FROM `email_notifications` INNER JOIN `email_notification_messages` ON email_notifications.message=email_notification_messages.id where email_notifications.user_id = '".$row_users['user_id']."' ORDER BY email_notifications.id DESC LIMIT 0, 1");
$row_users_last_msg=$select_user_last_msg->fetch_assoc();
?>
<lable class="col-lg-11 col-xs-11" id="lableuser-<?php echo $row_users['user_id']; ?>" style="margin:3px;">
  <input type="checkbox" class="" id="select_users" name="select_users[]" value="<?php echo $row_users['user_id']; ?>"> <?php echo $row_users['name'].' ('.$row_users['email'].')'; ?> 
<?php if($select_user_last_msg->num_rows > 0) { ?>
<span style="color:green"> Recent Message : <?php echo $row_users_last_msg['subject'].' '.$row_users_last_msg['recent_send_time']; ?> </span>
<?php } ?>

<a style="color:red; float:right;" href="#" class="unsubscribeusers" id="<?php echo $row_users['user_id']; ?>"> <i class="fa fa-bell-slash-o"></i> <!--Unsubscribe--></a>
</lable>

<?php } 
} else {
echo 'No User Exists';
}