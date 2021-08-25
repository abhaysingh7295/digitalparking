<?php 
include '../../config.php';

$regi =  json_decode('{"staff_id":"75", "vendor_id":"201", "qr_code":"6S4HDQRPJ807T31"}');

//$request = $_REQUEST['request'];
//$regi =  json_decode($request);
if($regi){
	$qr_code = $regi->qr_code;
	$vendor_id = $regi->vendor_id;
	//$latitude = $regi->in_latitude;
	//$longitude = $regi->in_longitude;
	$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where qr_code='".$qr_code."' LIMIT 1"); 
	$numrows_qr = $select_qr->num_rows;
	if($numrows_qr==1){
		$qr_code_row = $select_qr->fetch_assoc();
	 	$qr_vehicle_number = $qr_code_row['vehicle_number']; 
		$select_monthly_pass = $con->query("SELECT * FROM `monthly_pass` Where vendor_id='".$vendor_id."' AND vehicle_number = '".$qr_vehicle_number."' ORDER BY status DESC");
		if($select_monthly_pass->num_rows==1){
			$monthly_pass_row = $select_monthly_pass->fetch_assoc();
				$status = $monthly_pass_row['status'];
				$customer_id = $monthly_pass_row['customer_id'];
				$mobile_number = $monthly_pass_row['mobile_number'];
				$vehicle_number = $monthly_pass_row['vehicle_number'];
				$vehicle_type = $monthly_pass_row['vehicle_type'];
				$pass_issued_date = $monthly_pass_row['pass_issued_date'];
				$pass_start_date = $monthly_pass_row['start_date'];
				$pass_end_date = $monthly_pass_row['end_date'];
				$user_image = $monthly_pass_row['user_image'];
				$vehicle_image = $monthly_pass_row['vehicle_image'];
				$MONTHLY_TEMP_DIR = VENDOR_URL.'monthlypass/'.$row['vendor_id'].'/';
				if($vehicle_image){
					$passarray['vehicle_image'] = $MONTHLY_TEMP_DIR.$vehicle_image;
				} else {
					$passarray['vehicle_image'] = '';
				}

				$passarray['customer_id'] = $customer_id;
				$passarray['vehicle_number'] = $vehicle_number;
				$passarray['vehicle_type'] = $vehicle_type;
				$passarray['pass_issued_date'] = date('Y-m-d', $pass_issued_date);
				$passarray['pass_start_date'] = $pass_start_date;
				$passarray['pass_end_date'] = $pass_end_date;
				$passarray['pass_end_date'] = $pass_end_date;
				$passarray['qr_type'] = 'monthly_pass';

				$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
				$row_customer=$select_customer->fetch_assoc();
				$passarray['customer_details'] = $row_customer;

				$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
				if($select_vehicle->num_rows==0) {
					//$passarray['booking_details'] = '';
				} else {
					$row_vehicle=$select_vehicle->fetch_assoc();
					$row_vehicle['vehicle_in_date_time'] = date('Y-m-d h:i A',$row_vehicle['vehicle_in_date_time']);
					$passarray['booking_details'] = $row_vehicle;
				}

				if($status==1){
					$current_date = date('Y-m-d'); 
				 	$start_pass = $pass_start_date;
				 	if($current_date >= $start_pass){
				 		$passarray['status'] = 'Pass Activate';
						$array['error_code'] = 200;
						$array['result'] = $passarray;
						$array['message'] = 'Pass Activate';
			 		} else {
				 		$passarray['status'] = 'Not Activate';
						$array['error_code'] = 401;
						$array['result'] = $passarray;
						$array['message'] = 'Pass Not Ready for Activate';
			 		}
				} else if($status==2){
					$passarray['status'] = 'Applied';
					$array['error_code'] = 401;
					$array['result'] = $passarray;
					$array['message'] = 'Pass Applied.';
				} else {
					$passarray['status'] = 'Expired';
					$array['error_code'] = 401;
					$array['result'] = $passarray;
					$array['message'] = 'Pass Expired';
				}

		} else if($select_monthly_pass->num_rows > 1){
			while($monthly_pass_row=$select_monthly_pass->fetch_assoc())
			{
				$status = $monthly_pass_row['status'];
				$customer_id = $monthly_pass_row['customer_id'];
				$mobile_number = $monthly_pass_row['mobile_number'];
				$vehicle_number = $monthly_pass_row['vehicle_number'];
				$vehicle_type = $monthly_pass_row['vehicle_type'];
				$pass_issued_date = $monthly_pass_row['pass_issued_date'];
				$pass_start_date = $monthly_pass_row['start_date'];
				$pass_end_date = $monthly_pass_row['end_date'];
				$user_image = $monthly_pass_row['user_image'];
				$vehicle_image = $monthly_pass_row['vehicle_image'];
				$MONTHLY_TEMP_DIR = VENDOR_URL.'monthlypass/'.$row['vendor_id'].'/';
				if($vehicle_image){
					$passarray['vehicle_image'] = $MONTHLY_TEMP_DIR.$vehicle_image;
				} else {
					$passarray['vehicle_image'] = '';
				}
				$passarray['customer_id'] = $customer_id;
				$passarray['vehicle_number'] = $vehicle_number;
				$passarray['vehicle_type'] = $vehicle_type;
				$passarray['pass_issued_date'] = date('Y-m-d', $pass_issued_date);
				$passarray['pass_start_date'] = $pass_start_date;
				$passarray['pass_end_date'] = $pass_end_date;
				$passarray['pass_end_date'] = $pass_end_date;
				$passarray['qr_type'] = 'monthly_pass';

				$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
				$row_customer=$select_customer->fetch_assoc();
				$passarray['customer_details'] = $row_customer;

				$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
				if($select_vehicle->num_rows==0) {
					//$passarray['booking_details'] = '';
				} else {
					$row_vehicle=$select_vehicle->fetch_assoc();
					$row_vehicle['vehicle_in_date_time'] = date('Y-m-d h:i A',$row_vehicle['vehicle_in_date_time']);
					$passarray['booking_details'] = $row_vehicle;
				}

				if($status==1){
					$current_date = date('Y-m-d'); 
				 	$start_pass = $pass_start_date;
				 	if($current_date >= $start_pass){
				 		$passarray['status'] = 'Pass Activate';
						$array['error_code'] = 200;
						$array['result'] = $passarray;
						$array['message'] = 'Pass Activate';
			 		} else {
				 		$passarray['status'] = 'Not Activate';
						$array['error_code'] = 401;
						$array['result'] = $passarray;
						$array['message'] = 'Pass Not Ready for Activate';
			 		}
			 		break;
				} else {
					$passarray['status'] = 'Expired';
					$array['error_code'] = 401;
					$array['result'] = $passarray;
					$array['message'] = 'Pass Expired';
					break;
				}
			}
		} else {
			$select_customer_vehicle = $con->query("SELECT * FROM `customer_vehicle` Where vehicle_number = '".$qr_vehicle_number."' ORDER BY id DESC LIMIT 1");
			if($select_customer_vehicle->num_rows==1){
				$customer_vehicle_row = $select_customer_vehicle->fetch_assoc();
				$customer_id = $customer_vehicle_row['customer_id'];
				$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
				$row_customer=$select_customer->fetch_assoc();
				$vehicle_number = $customer_vehicle_row['vehicle_number'];
				$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
				if($select_vehicle->num_rows==0) {
					//$passarray['booking_details'] = '';
				} else {
					$row_vehicle=$select_vehicle->fetch_assoc();
					$row_vehicle['vehicle_in_date_time'] = date('Y-m-d h:i A',$row_vehicle['vehicle_in_date_time']);
					$passarray['booking_details'] = $row_vehicle;
				}
				$vehicle_photo = $customer_vehicle_row['vehicle_photo'];
				if($vehicle_photo){
					$passarray['vehicle_image'] = UPLOAD_URL.$vehicle_photo;
				} else {
					$passarray['vehicle_image'] = '';
				}
				$passarray['customer_id'] = $customer_id;
				$passarray['vehicle_number'] = $customer_vehicle_row['vehicle_number'];
				$passarray['vehicle_type'] = $customer_vehicle_row['vehicle_type'];
				$passarray['qr_type'] = 'customer_vehicle';
				$passarray['customer_details'] = $row_customer;
				$array['error_code'] = 200;
				$array['result'] = $passarray;
				$array['message'] = 'Vehicle Found';
			} else {
				$select_customer_vehicle = $con->query("SELECT * FROM `monthly_pass` Where vehicle_number = '".$qr_vehicle_number."' ORDER BY id DESC LIMIT 1");
				$customer_vehicle_row = $select_customer_vehicle->fetch_assoc();
				$customer_id = $customer_vehicle_row['customer_id'];
				$select_customer = $con->query("SELECT id as customer_id,first_name,last_name,mobile_number,address,state,city FROM `pa_users` Where id=".$customer_id."");
				$row_customer=$select_customer->fetch_assoc();
				$vehicle_number = $customer_vehicle_row['vehicle_number'];
				$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
				if($select_vehicle->num_rows==0) {
					//$passarray['booking_details'] = '';
				} else {
					$row_vehicle=$select_vehicle->fetch_assoc();
					$row_vehicle['vehicle_in_date_time'] = date('Y-m-d h:i A',$row_vehicle['vehicle_in_date_time']);
					$passarray['booking_details'] = $row_vehicle;
				}
				$vehicle_photo = $customer_vehicle_row['vehicle_photo'];
				if($vehicle_photo){
					$passarray['vehicle_image'] = UPLOAD_URL.$vehicle_photo;
				} else {
					$passarray['vehicle_image'] = '';
				}
				$passarray['customer_id'] = $customer_id;
				$passarray['vehicle_number'] = $customer_vehicle_row['vehicle_number'];
				$passarray['vehicle_type'] = $customer_vehicle_row['vehicle_type'];
				$passarray['qr_type'] = 'customer_vehicle';
				$passarray['customer_details'] = $row_customer;
				$array['error_code'] = 200;
				$array['result'] = $passarray;
				$array['message'] = 'Vehicle Found';
			} 
		}
	} else {
			$passarray['status'] = 'Expired';
			$array['error_code'] = 401; 
			$array['message'] = 'QR Code is not Allowed due to some reason';
		}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray);
echo json_encode($finalarray);