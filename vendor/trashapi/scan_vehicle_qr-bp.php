<?php 
include '../../config.php';

//$regi =  json_decode('{"qr_code":"IYURQ81SAK5W07O", "in_latitude":"", "in_longitude":""}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);
if($regi){
	$qr_code = $regi->qr_code;
	$latitude = $regi->in_latitude;
	$longitude = $regi->in_longitude;
	$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where qr_code='".$qr_code."'"); 
	$numrows_qr = $select_qr->num_rows;
	if($numrows_qr==1){
		$qr_code_row = $select_qr->fetch_assoc();
		$ref_id = $qr_code_row['ref_id'];
		$ref_type = $qr_code_row['ref_type'];

		if($ref_type=='monthly_pass'){
			$select_monthly_pass = $con->query("SELECT * FROM `monthly_pass` Where id=".$ref_id."");
			$monthly_pass_row = $select_monthly_pass->fetch_assoc();
			$status = $monthly_pass_row['status'];
			$vendor_id = $monthly_pass_row['vendor_id'];
			$customer_id = $monthly_pass_row['customer_id'];
			$mobile_number = $monthly_pass_row['mobile_number'];
			$vehicle_number = $monthly_pass_row['vehicle_number'];
			$vehicle_type = $monthly_pass_row['vehicle_type'];
			$pass_issued_date = $monthly_pass_row['pass_issued_date'];
			$pass_start_date = $monthly_pass_row['start_date'];
			$pass_end_date = $monthly_pass_row['end_date'];

			$passarray['customer_id'] = $customer_id;
			$passarray['vehicle_number'] = $vehicle_number;
			$passarray['vehicle_type'] = $vehicle_type;
			$passarray['pass_issued_date'] = date('Y-m-d', $pass_issued_date);
			$passarray['pass_start_date'] = $pass_start_date;
			$passarray['pass_end_date'] = $pass_end_date;
			$passarray['qr_type'] = 'monthly_pass';
			if($status==1){

				$current_date = date('Y-m-d'); 
			 	$start_pass = $pass_start_date;
			 	if($current_date >= $start_pass){
					$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
					if($select_vehicle->num_rows==0) {
						$vehicle_in_date_time = time();
						$vehicle_status = 'In';
						$insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status,latitude,longitude) VALUES('$vendor_id','$customer_id','$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status','$latitude','$longitude')";
						if ($con->query($insert_vehicle) === TRUE) {
							$array['error_code'] = 200;
							$array['message'] = 'Vehicle Park In Successfully';
						} else {
							$array['error_code'] = 400;
							$array['message'] = 'Some Datebase Error';
						}
					} else {
						$val_vehicle_id = $select_vehicle->fetch_assoc();
						$booking_id = $val_vehicle_id['id'];
						$vehicle_out_date_time = time();
						$vehicle_status = 'Out';
						$update_query = "update `vehicle_booking` SET vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where id = ".$booking_id."";
						if ($con->query($update_query) === TRUE) {
							$array['error_code'] = 200;
							$array['message'] = 'Vehicle Out Successfully';
						} else {
							$array['error_code'] = 400;
							$array['message'] = 'Some Datebase Error';
						}
					} 
		 		} else {
			 		$passarray['status'] = 'Not Activate';
					$array['error_code'] = 401;
					$array['result'] = $passarray;
					$array['message'] = 'Pass Not Ready for Activate';
		 		}
			} else {
				$passarray['status'] = 'Expired';
				$array['error_code'] = 401;
				$array['result'] = $passarray;
				$array['message'] = 'Pass Expired';
			}
		} else if($ref_type=='customer_vehicle'){
			$select_customer_vehicle = $con->query("SELECT * FROM `customer_vehicle` Where id=".$ref_id."");
			$customer_vehicle_row = $select_customer_vehicle->fetch_assoc();
			$passarray['customer_id'] = $customer_vehicle_row['customer_id'];
			$passarray['vehicle_number'] = $customer_vehicle_row['vehicle_number'];
			$passarray['vehicle_type'] = $customer_vehicle_row['vehicle_type'];
			$passarray['qr_type'] = 'customer_vehicle';
			$array['error_code'] = 200;
			$array['result'] = $passarray;
			$array['message'] = 'Vehicle Found';
		}
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray);
echo json_encode($finalarray);