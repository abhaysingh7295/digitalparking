<?php include '../../config.php'; 

$select_query = $con->query("SELECT * FROM `vehicle_pre_booking` WHERE status = 'Booked' ORDER BY id DESC");
while($row=$select_query->fetch_assoc()) {
	$id = $row['id'];
	$current_date = time();
	$end_date = $row['leaving_time'];
	if($current_date > $end_date){
		$con->query("update `vehicle_pre_booking` SET status = 'Expired' where id = '".$id."'");
	}
}