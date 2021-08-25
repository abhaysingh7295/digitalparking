<?php include '../config.php'; 
session_start();

$current_user_id = $_SESSION["current_user_ID"];

if($_POST['action']=='monthly_payment_received'){
	$current_year_received = $con->query("SELECT FROM_UNIXTIME(ph.payment_date_time, '%M') as payment_month, SUM(ph.amount) as total_amount FROM `payment_history` as ph JOIN vehicle_booking as vb on vb.id = ph.booking_id where FROM_UNIXTIME(ph.payment_date_time, '%Y') = ".date('Y')." GROUP BY payment_month");
	$Total_array = array();
	while($year_received_row=$current_year_received->fetch_assoc()) {
		$payment_month = $year_received_row['payment_month'];
		$Total_array[$payment_month] = $year_received_row['total_amount'];
	}
	$monthArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September","October","November","December");
	$month_amounting_array = array();
	foreach($monthArray as $monthA){
		$total_month_amount = 0;
	if($Total_array[$monthA]){
	    $total_month_amount = $Total_array[$monthA];
	}
		$month_amounting_array[] = $total_month_amount;
	}
	echo json_encode(array('labels' => $monthArray, 'values' => $month_amounting_array));

} else if($_POST['action']=='monthly_parking'){
	$first_day_this_month = date('Y-m-01');
	$last_day_this_month  = date('Y-m-t'); 

	//$select_month_booking_in = $con->query("SELECT id FROM `vehicle_booking` where (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$last_day_this_month."' OR FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') <= '".$last_day_this_month."')");

	$select_month_booking_in = $con->query("SELECT id FROM `vehicle_booking` where vehicle_in_date_time!=''");

	//$select_month_booking_out = $con->query("SELECT id FROM `vehicle_booking` where (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$last_day_this_month."' OR FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') <= '".$last_day_this_month."') AND vehicle_status = 'Out'");

	$select_month_booking_out = $con->query("SELECT id FROM `vehicle_booking` where vehicle_out_date_time!=''");

	echo json_encode(array('labels' => array('In', 'Out'), 'values' => array($select_month_booking_in->num_rows, $select_month_booking_out->num_rows)));

} else if($_POST['action']=='weekly_parking'){

	$first_day_of_the_week = 'Monday';
	$start_of_the_week     = strtotime("Last $first_day_of_the_week");
	if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
	{
	    $start_of_the_week = strtotime('today');
	}
	$end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
	$date_format =  'Y-m-d';
	$start_date = date($date_format, $start_of_the_week);
	$end_date  = date($date_format, $end_of_the_week);

	$weekArray = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuarday', 'Sunday');

	$select_week_booking_in = $con->query("SELECT count(id) total_in, FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') as in_date, FROM_UNIXTIME(vehicle_in_date_time, '%W') as in_week_day  FROM `vehicle_booking` WHERE (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY in_date, in_week_day");

	$Total_in = array();
	while($week_booking_in_row=$select_week_booking_in->fetch_assoc()) {
		$week_key_in = $week_booking_in_row['in_week_day'];
		$Total_in[$week_key_in] = $week_booking_in_row['total_in'];
	}


	$select_week_booking_out = $con->query("SELECT count(id) total_out, FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') as out_date, FROM_UNIXTIME(vehicle_out_date_time, '%W') as out_week_day  FROM `vehicle_booking` WHERE (FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY out_date, out_week_day");

	$Total_out = array();
	while($week_booking_out_row=$select_week_booking_out->fetch_assoc()) {
		$week_key_out = $week_booking_out_row['out_week_day'];
		$Total_out[$week_key_out] = $week_booking_out_row['total_out'];
	}

	foreach($weekArray as $week){
		$total_park_in = 0;
		$total_park_out = 0;
		if($Total_in[$week]){
		    $total_park_in = $Total_in[$week];
		}

		if($Total_out[$week]){
		    $total_park_out = $Total_out[$week];
		}

		$week_parkin_array[] = $total_park_in;
		$week_parkout_array[] = $total_park_out;
	}

	$week_data = array($week_parkin_array,$week_parkout_array);
	echo json_encode(array('labels' => $weekArray, 'week_data' => $week_data));


}
die; 