<?php

include('config.php');

$userid = $_REQUEST['userid'];

$sql1 = "UPDATE `user` set notification_subscription ='0' WHERE user_id='".$userid."'";

if ($con->query($sql1) === TRUE) {

echo 'success';

} else {
echo 'fail';
}