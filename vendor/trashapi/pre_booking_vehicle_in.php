<?php 
include '../../config.php';
/*$regi =  json_decode('{
	"user_id":"150",
	"customer_id":"150",
	"vehicle_number":"RJ14DE1752",
	"vehicle_type":"2W",
	"latitude":"",
	"longitude":"",
	"mobile_number":"7728029388",
	"vehicle_in_time":"1592999747",
	"pre_booking_id":"2"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){

	$vendor_id = $regi->user_id;
	$customer_id = $regi->customer_id;
	$vehicle_number = $regi->vehicle_number;
    $vehicle_type = $regi->vehicle_type;
    $mobile_number = $regi->mobile_number;
    $vehicle_in_date_time = $regi->vehicle_in_time;
    $latitude = $regi->latitude;
    $longitude = $regi->longitude;
    $pre_booking_id = $regi->pre_booking_id;
    $vehicle_status = 'In';

    $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
    if($select_vehicle->num_rows==0) {

    	$insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status,latitude,longitude) VALUES('$vendor_id','$customer_id','$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$latitude','$longitude')";
    	if ($con->query($insert_vehicle) === TRUE) {
    		$booking_id= $con->insert_id;
    		$con->query("update `payment_history` SET booking_id = '".$booking_id."' where pre_booking_id = ".$pre_booking_id."");
    		$con->query("update `vehicle_pre_booking` SET status = 'In' where id = ".$pre_booking_id."");
    		$array['error_code'] = 200;
			$array['message'] = 'Vehicle Park In Successfully';
    	}  else {
			$array['error_code'] = 400;
			$array['message'] = 'Some Database error';
		}
    } else {
		$array['error_code'] = 400;
		$array['message'] = 'Vehicle Already in Parking';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);