<?php 
include '../../config.php';
/*$regi =  json_decode('{
	"user_id":"150",
	"vehicle_number":"RJ14MS8888",
	"mobile_number":"9874563210",
	"vehicle_type":"2W",
	"vehicle_in_time":"1592999747",
	"amount":"0",
    "qr_type":""}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$vendor_id = $regi->user_id;
	$vehicle_number = $regi->vehicle_number;
    $mobile_number = $regi->mobile_number;
    $amount = $regi->amount;
    $vehicle_type = $regi->vehicle_type;
    $vehicle_in_date_time = $regi->vehicle_in_time;
    $latitude = $regi->in_latitude;
    $longitude = $regi->in_longitude;
    $qr_type = $regi->qr_type;

    $vehicle_status = 'In';

    $select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role='customer'"); 
    $numrows_username = $select_user_name->num_rows;
    if ($numrows_username > 0) {
        $val_user = $select_user_name->fetch_assoc();
        $customer_id = $val_user['id'];
    } else {
        $user_role = 'customer';
        $user_status  = 1;
        $register_date  = date('Y-m-d h:i:s');
        $social_type  = 'simple';
        $os  = 'android';
        $reflength = 10;
	 	$refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	 	$referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
        $insert_query = "INSERT INTO pa_users(mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code) VALUES('$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code')";
        if ($con->query($insert_query) === TRUE) {
            $customer_id = $con->insert_id;
        }
    }

    $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");

    if($select_vehicle->num_rows==0) {
    	$insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status,latitude,longitude,qr_type) VALUES('$vendor_id','$customer_id','$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$latitude','$longitude','$qr_type')";

    	if ($con->query($insert_vehicle) === TRUE) {
            $booking_id= $con->insert_id;
            if(($amount) && ($amount > 0)){
                $payment_type='Cash';
                $con->query("INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time) VALUES('$booking_id','$amount','$payment_type','$vehicle_in_date_time')");
            }
            $array['error_code'] = 200;
			$array['message'] = 'Vehicle Park In Successfully';
        } else {
            $array['error_code'] = 400;
			$array['message'] = 'Some Datebase Error';
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