<?php 
include '../../config.php';
include '../../administration/functions.php';
/*$regi =  json_decode('{
    "staff_id":"75",
	"vendor_id":"150",
	"vehicle_number":"RJ14MS8888",
	"mobile_number":"9874563210",
	"vehicle_type":"2W",
	"vehicle_in_time":"1592999747",
	"amount":"0",
    "qr_type":"",
 "staff_type":""}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
    $staff_id = $regi->staff_id;
	$vendor_id = $regi->vendor_id;
	$vehicle_number = $regi->vehicle_number;
	
    $mobile_number = $regi->mobile_number;
    $amount = $regi->amount;
    $vehicle_type = $regi->vehicle_type;
    $vehicle_in_date_time = $regi->vehicle_in_time;
    $latitude = $regi->in_latitude;
    $longitude = $regi->in_longitude;
    $qr_type = $regi->qr_type;
    if($regi->staff_type=='yes'){
      $staff_vehicle_type = 'yes';  
    } else {
        $staff_vehicle_type = 'no'; 
    }
    

    if($qr_type==''){
        $select_monthly_pass = $con->query("SELECT id FROM `monthly_pass` Where vendor_id='".$vendor_id."' AND vehicle_number = '".$vehicle_number."' AND status = 1 LIMIT 1");
        if($select_monthly_pass->num_rows==1){
            $qr_type = 'monthly_pass';
        }
    }

    $vehicle_status = 'In';
    $active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
    if($mobile_number){
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
    } else {
        $customer_id = 0;
    }

    //$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");

    $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");

    if($select_vehicle->num_rows==0) {
        $serial_number="(SELECT COALESCE(MAX(vbg.serial_number),0)+1 FROM vehicle_booking as vbg where vbg.vendor_id='".$vendor_id."')";
    	$insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,serial_number,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status,latitude,longitude,qr_type,staff_vehicle_type,staff_in) VALUES('$vendor_id','$customer_id',$serial_number,'$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$latitude','$longitude','$qr_type','$staff_vehicle_type','$staff_id')";

    	if ($con->query($insert_vehicle) === TRUE) {
            $booking_id= $con->insert_id;
            if($regi->services){
                foreach($regi->services as $services){
                    $con->query("INSERT INTO booking_services SET bookingid='". $booking_id."', categoryid='".$services->cat_id."',subcategoryid='".$services->subcat_id."',amount='".$services->amount."'");
                }
                
            }
                GetVendorsWantedVechiles($con,$vendor_id,$vehicle_number,$booking_id);
                SensitiveVechilesNotify($con,$vendor_id,$vehicle_number,$booking_id);
                GetMissingVehicleNumber($con,$vendor_id,$vehicle_number,$booking_id);

                if(($mobile_number) && ($active_plans_row['sms_notification']==1)){
                    $vendor_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as vendor_name, parking_name FROM pa_users WHERE id = ".$vendor_id."");
                    $vendor_ow=$vendor_query->fetch_assoc();

                    $customer_name = '';
                    if($customer_id!=0){
                      $customer_name = $val_user['first_name'].' '.$val_user['last_name'].' ';
                    }

                    $sendmessage = 'Hello, '.$customer_name.'Your vehicle '.$vehicle_number.' '.$vehicle_type.' has been parked at '.$vendor_ow['parking_name'].' on '.date('Y-m-d h:i A',$vehicle_in_date_time).', Rs. '.$amount.', View More '.SITE_URL.'/booking_invoice.php?id='. base64_encode($booking_id);
                    
                    $message = urlencode($sendmessage);
                    SendSMSNotification($mobile_number, $message);
                }

           // if(($amount) && ($amount > 0)){
                $payment_type='Cash';
                $con->query("INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time,staff_id) VALUES('$booking_id','$amount','$payment_type','$vehicle_in_date_time','$staff_id')");
            //}
			 $select_vehicless = $con->query("SELECT serial_number FROM `vehicle_booking` Where id='".$booking_id."'");
			 $select_vehicles_ow=$select_vehicless->fetch_assoc();
            $array['error_code'] = 200;
            $array['booking_id'] = $booking_id;
			$array['serial_number'] = $select_vehicles_ow['serial_number'];
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