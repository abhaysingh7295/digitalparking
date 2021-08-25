<?php 
include '../../config.php';

/*$regi =  json_decode('{
	"user_id":"150",
	"vehicle_number":"RJ14MS8888",
	"mobile_number":"9874563210",
	"vehicle_type":"2W",
	"vehicle_out_time":"1592999747",
	"amount":"0"}');*/
$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$vendor_id = $regi->user_id;
	$vehicle_number = $regi->vehicle_number;
    $mobile_number = $regi->mobile_number;
    $amount = $regi->amount;
    $vehicle_type = $regi->vehicle_type;
    $vehicle_out_date_time = $regi->vehicle_out_time;
    $vehicle_status = 'Out';

    $select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role='customer'"); 
    $val_user = $select_user_name->fetch_assoc();
    $customer_id = $val_user['id'];
	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle==1) {
		$val_vehicle_id = $select_vehicle->fetch_assoc();
		$booking_id = $val_vehicle_id['id'];
		$update_query = "update `vehicle_booking` SET vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where id = ".$booking_id."";
		if ($con->query($update_query) === TRUE) {
			if($amount > 0){
    			$payment_type='Cash';
    			$con->query("INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time) VALUES('$booking_id','$amount','$payment_type','$vehicle_out_date_time')");
    		}
    		$array['error_code'] = 200;
			$array['message'] = 'Vehicle Out Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Vehicle not in Parking';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
echo json_encode($finalarray);