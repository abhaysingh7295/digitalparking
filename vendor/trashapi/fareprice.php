<?php 
include '../../config.php';

$vendor_id = 150;
$fare_final_array = array();
$select_fare_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id."");
while($fare_row=$select_fare_query->fetch_assoc())
{ 
	
	$veh_type = $fare_row['veh_type'];
	$initial_hr = $fare_row['initial_hr'];
	$ending_hr = $fare_row['ending_hr'];
	$amount = $fare_row['amount'];
	$hr_status = $fare_row['hr_status'];

	$fare_array['initial_hr'] = $initial_hr;
	$fare_array['ending_hr'] = $ending_hr;
	$fare_array['amount'] = $amount;
	$fare_array['hr_status'] = $hr_status;

	$fare_final_array[$veh_type][] = $fare_array;

}

$array['fare_info_price'] = $fare_final_array;
echo '<pre>'; print_r($array); echo '</pre>';