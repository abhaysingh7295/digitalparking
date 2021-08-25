<?php 
include '../../config.php';
include '../../administration/functions.php';
/*$regi =  json_decode('{
	"staff_id":"75", 
	"vendor_id":"150",
	"customer_id":"150",
	"vehicle_number":"RJ14DE1752",
	"vehicle_type":"2W",
	"latitude":"",
	"longitude":"",
	"mobile_number":"7728029388",
	"vehicle_in_time":"1596090600",
	"pre_booking_id":"9"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$staff_id = $regi->staff_id;
	$vendor_id = $regi->vendor_id;
	$customer_id = $regi->customer_id;
	$vehicle_number = $regi->vehicle_number;
    $vehicle_type = $regi->vehicle_type;
    $mobile_number = $regi->mobile_number;
    $vehicle_in_date_time = $regi->vehicle_in_time;
    $latitude = $regi->latitude;
    $longitude = $regi->longitude;
    $pre_booking_id = $regi->pre_booking_id;
    $vehicle_status = 'In';
    $active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
    $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
    if($select_vehicle->num_rows==0) {

    	$insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status,latitude,longitude,staff_in,parking_type) VALUES('$vendor_id','$customer_id','$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$latitude','$longitude','$staff_id','Online')";
    	if ($con->query($insert_vehicle) === TRUE) {
            $booking_id = $con->insert_id;

    		if(($mobile_number) && ($active_plans_row['sms_notification']==1)){
                $vendor_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as vendor_name FROM pa_users WHERE id = ".$vendor_id."");
                $vendor_ow=$vendor_query->fetch_assoc();
                $sendmessage = 'Hello,

                Your vehicle '.$vehicle_number.' '.$vehicle_type.' has been parked at '.$vendor_ow['vendor_name'].' on '.date('Y-m-d h:i A',$vehicle_in_date_time).' '.$amount.' Rs.

                For Any Query contact us on +91-7410906906.or visit http://thedigitalparking.com/';
                $message = urlencode($sendmessage);
                SendSMSNotification($mobile_number, $message);
            }
                
    		
            GetVendorsWantedVechiles($con,$vendor_id,$vehicle_number,$booking_id);
            SensitiveVechilesNotify($con,$vendor_id,$vehicle_number,$booking_id);
            GetMissingVehicleNumber($con,$vendor_id,$vehicle_number,$booking_id);

    		$con->query("update `payment_history` SET booking_id = ".$booking_id.", staff_id = ".$staff_id." where pre_booking_id = ".$pre_booking_id."");

    		$con->query("update `vehicle_pre_booking` SET status = 'In' where id = ".$pre_booking_id."");
    		$array['error_code'] = 200;
            $array['booking_id'] = $booking_id;
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