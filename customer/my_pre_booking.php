<?php 
include '../config.php';


$request = $_REQUEST['request'];
$regi =  json_decode($request);
//$regi =  json_decode('{"customer_id":"186"}');

if($regi){
	$customer_id = $regi->customer_id;
	$vehicle_book_query = $con->query("SELECT b.*, u.first_name, u.mobile_number, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_pre_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id WHERE b.customer_id = ".$customer_id."  AND b.status IN('Booked', 'Expired') ORDER BY b.id DESC");
	$numrows_vehicle = $vehicle_book_query->num_rows;
	if ($numrows_vehicle > 0) {
		while($row=$vehicle_book_query->fetch_assoc())
		{
			$row['arriving_time'] = date('d-m-Y h:i A', $row['arriving_time']);
			$row['leaving_time'] = date('d-m-Y h:i A', $row['leaving_time']);
			$row['booking_date_time'] = date('d-m-Y h:i A', $row['booking_date_time']);
			$VehicleArray[] = $row;
		}

		$finalArray['error_code'] = 200;
		$finalArray['result'] = $VehicleArray;
		$finalArray['message'] = 'Vehicle Booking found';
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'No Vehicle Booking found';
	}

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);

//echo '<pre>'; print_r($resparray);