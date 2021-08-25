<?php 
include '../../config.php';
include '../../administration/functions.php';
$regi = json_decode(file_get_contents("php://input"));

    $staff_id = $regi->staff_id;
    $vendor_id = $regi->vendor_id;
    $vehicle_number = $regi->vehicle_number;
    $vehicle_chassis_number = $regi->vehicle_chassis_number;
    $mobile_number = $regi->mobile_number;
    $vehicle_type = $regi->vehicle_type;
    $vehicle_in_date_time = $regi->vehicle_in_time;

    if($regi->staff_type=='yes'){
      $staff_vehicle_type = 'yes';  
    } else {
        $staff_vehicle_type = 'no'; 
    }
                $filename = $_FILES['vehicle_image']['name'];
		$file_path = "../uploads/" .$filename;
		$NewFileName = '';
		if($_FILES['vehicle_image'])  {
		$file_type = $_FILES['vehicle_image']['type'];
			if(($file_type == 'image/gif') || ($file_type == 'image/jpeg') || ($file_type == 'image/jpg') || ($file_type == 'image/png')){  
	 			if(move_uploaded_file($_FILES['vehicle_image']['tmp_name'], $file_path))
	 			{
					$NewFileName = $file_path;
				} 
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

        $serial_number="(SELECT COALESCE(MAX(vbg.serial_number),0)+1 FROM vehicle_service_booking as vbg where vbg.vendor_id='".$vendor_id."')";
    	$insert_vehicle = "INSERT INTO vehicle_service_booking(vendor_id,customer_id,serial_number,vehicle_chassis_number,vehicle_number,mobile_number,vehicle_image,vehicle_type,vehicle_in_date_time,vehicle_status,staff_vehicle_type,staff_in) VALUES('$vendor_id','$customer_id',$serial_number,'$vehicle_chassis_number','$vehicle_number','$mobile_number','$NewFileName','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$staff_vehicle_type','$staff_id')";

    	if ($con->query($insert_vehicle) === TRUE) {
            $booking_id= $con->insert_id;
                $select_vehicless = $con->query("SELECT serial_number FROM `vehicle_service_booking` Where id='".$booking_id."'");
			 $select_vehicles_ow=$select_vehicless->fetch_assoc();
            $array['error_code'] = 200;
            $array['service_id'] = $booking_id;
			$array['serial_number'] = $select_vehicles_ow['serial_number'];
			$array['message'] = 'Vehicle Successfully added for service';
        } else {
            $array['error_code'] = 400;
			$array['message'] = 'Some Datebase Error';
        }
$finalarray['response'] = $array;
echo json_encode($finalarray);