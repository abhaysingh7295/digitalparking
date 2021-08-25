<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];

$getstart = $_REQUEST['start_date'];
$getend = $_REQUEST['end_date'];

$vehicle_book_query = $con->query("SELECT *, sum(advance_amount) as total_booking_advance, sum(due_amount) as total_booked_amount, sum(to_pay_amount) as total_pay_amount FROM `vehicle_book` where (STR_TO_DATE(vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."')AND user_id = '".$user_id."' GROUP BY booked_by ORDER BY id DESC");

$numrows_vehicle = $vehicle_book_query->num_rows;
	if($numrows_vehicle > 0) {

$re_vehicle = array();
while($row=$vehicle_book_query->fetch_assoc())
{
	$total_booking_advance = $row['total_booking_advance'];
	$total_booked_amount = $row['total_booked_amount'];
	$total_pay_amount = $row['total_pay_amount'];
	 
	$total_amount_reveived = $total_booking_advance + $total_booked_amount - $total_pay_amount;
	$val_vehicle['start_date'] = $getstart;
	$val_vehicle['end_date'] = $getend;

	$val_vehicle['booked_by'] = $row['booked_by'];
	$val_vehicle['total_amount_reveived'] = $total_amount_reveived;

		$re_vehicle[] = $val_vehicle;
}

		$error_code = 200;
		$array['error_code'] = 200;
		$array['message'] = 'Records Found Successfully';
		$array['val_vehicle'] = $re_vehicle;


	} else {
		$array['error_code'] = 501;
		$array['message'] = 'Not Records';
	}

//echo '<pre>'; print_r($array); echo '</pre>';
$finalarray['result'] = $array;
echo json_encode($finalarray);