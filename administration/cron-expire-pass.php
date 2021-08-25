<?php 
include '../config.php';

$select_query = $con->query("SELECT * FROM `monthly_pass` WHERE status = 1 ORDER BY id DESC");
while($row=$select_query->fetch_assoc()) {
	$id = $row['id'];
	$current_date = strtotime(date('Y-m-d'));
	$end_date = strtotime($row['end_date']);
    $grace_date =  strtotime($row['grace_date']);
    $expiry_date='';
    if($grace_date!='')
    {
        $expiry_date = $grace_date;
    }
    else
    {
        $expiry_date = $end_date;
    }
    
//	    if($current_date > $end_date){

    if($current_date > $expiry_date)
    {
		$con->query("update `monthly_pass` SET status = 0 where id = '".$id."'");
		$con->query("update `vehicle_qr_codes` SET status = '0' where ref_type = 'monthly_pass' AND ref_id = ".$id);
	}
}