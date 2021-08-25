<?php include 'config.php';

$user_id = $_POST['userid']; 

$sql = "DELETE FROM `pa_users` WHERE id='".$user_id."'";

if ($con->query($sql) === TRUE) {

 $con->query("DELETE FROM `face_info` WHERE user_id='".$user_id."'");
 $con->query("DELETE FROM `place_info` WHERE user_id='".$user_id."'");
 $con->query("DELETE FROM `vehicle_book` WHERE user_id='".$user_id."'");
 $con->query("DELETE FROM `wallet_history` WHERE user_id='".$user_id."'");
 $con->query("DELETE FROM `staff_details` WHERE user_id='".$user_id."'");

echo 'success';
} else {
   echo "Error deleting record: " ;
}

