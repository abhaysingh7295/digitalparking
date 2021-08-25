<?php 
include 'config.php';

$user_id = $_REQUEST['user_id'];
$vehicle_number = $_REQUEST['vehicle_number'];

$select_vehicle = $con->query("SELECT * FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");

	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle > 0) {
		$val_vehicle = $select_vehicle->fetch_assoc();
		$in_time = $val_vehicle['vehicle_in_date_time'];
		$parking_type = $val_vehicle['parking_type'];
		$vehicle_type = $val_vehicle['vehicle_type'];
		$advance_amount = $val_vehicle['advance_amount'];
		
		$face_info = $con->query("SELECT * FROM `face_info` Where user_id='".$user_id."'");
		$val_face_info = $face_info->fetch_assoc(); 
		$perhouramount = 0;
		$hour_diffrance = 0;
		$days_diffrance = 0;

		if($parking_type=='hour'){
			if($vehicle_type=='2'){
				$wheeler = 'h_two_wheeler';
			} else if($vehicle_type=='3'){
				$wheeler = 'h_three_wheeler';
			} else if($vehicle_type=='4'){
				$wheeler = 'h_four_wheeler';
			}


			$starttimestamp = strtotime($in_time);
			$endtimestamp = strtotime(date('Y-m-d H:i:s'));
			$difference = abs($endtimestamp - $starttimestamp)/3600;
			$hour_diffrance = ceil($difference);
			$perhouramount = $val_face_info[$wheeler];
			$total_bill_amount = $perhouramount * $hour_diffrance;
		} else if($parking_type=='days'){
			if($vehicle_type=='2'){
				$wheeler = 'd_two_wheeler';
			} else if($vehicle_type=='3'){
				$wheeler = 'd_three_wheeler';
			} else if($vehicle_type=='4'){
				$wheeler = 'd_four_wheeler';
			}

			$then = $in_time;
			$then = strtotime($then);
			$now = time();
			//Calculate the difference.
			$difference = $now - $then;
			//Convert seconds into days.
			$days_diffrance = ceil($difference / (60*60*24) );
			$perdayamount = $val_face_info[$wheeler];
			$total_bill_amount = $perdayamount * $days_diffrance;
		}
	
			$due_amount = $total_bill_amount - $advance_amount;
			if($due_amount < 0){
		 		$total_due_amount = 0;
		 		$total_pay_amount = $due_amount;
		 	} else {
		 		$total_due_amount = $due_amount;
		 		$total_pay_amount = 0;
		 	}

		$error_code = 200;
		$array['error_code'] = 200;
		$array['message'] = 'Vehicle Search Successfully';

		$con->query("update `vehicle_book` SET total_amount = '".$total_bill_amount."' where user_id = ".$user_id." AND vehicle_number = '".$vehicle_number."' AND vehicle_status='In'");
 
		$val_vehicle['total_amount'] = $total_bill_amount;
		$val_vehicle['total_hour'] = $hour_diffrance;
		$val_vehicle['total_days'] = $days_diffrance;
		$val_vehicle['due_amount'] = $total_due_amount;
		$val_vehicle['to_pay_amount'] = $total_pay_amount;
		$array['val_vehicle'] = $val_vehicle;
	} else {
		$array['error_code'] = 501;
		$array['message'] = 'Vehicle Not Found';
	}

//echo '<pre>'; print_r($array); echo '</pre>';
$finalarray['result'] = $array;
echo json_encode($finalarray);