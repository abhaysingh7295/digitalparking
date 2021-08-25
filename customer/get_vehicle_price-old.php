<?php  require_once '../config.php';

//$regi =  json_decode('{"vendor_id":"150","vehicle_type":"2W","vehicle_number":"ready 1246","parking_status":"Out"}');

$regi =  json_decode($_REQUEST['request']);
if($regi){
	$vendor_id = $regi->vendor_id;
	$vehicle_type = $regi->vehicle_type;
	$vehicle_number = $regi->vehicle_number;
	$parking_status = $regi->parking_status;

	if($parking_status=='In'){
		$select_fare_info = $con->query("SELECT * FROM `fare_info` Where user_id=".$vendor_id." AND veh_type ='".$vehicle_type."' AND hr_status = 'bs_fare' LIMIT 1"); 
		$numrows_fare_info = $select_fare_info->num_rows;
		if($numrows_fare_info==1) {
			$fare_info_row = $select_fare_info->fetch_assoc();
			$array['error_code'] = 200;
			$array['message'] = 'Price Found Successfully';
			$array['parking_price'] = $fare_info_row['amount'];
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Price Not Found';	
		}
		
	} else {
		$return = false;
		$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id=".$vendor_id." AND vehicle_number ='".$vehicle_number."' AND vehicle_type  ='".$vehicle_type."' AND vehicle_status = 'In'");
		$numrows_vehicle = $select_vehicle->num_rows;
		if($numrows_vehicle==1) {
			$row_vehicle = $select_vehicle->fetch_assoc();
			$id = $row_vehicle['id'];
			$old_payment_sql = $con->query('SELECT SUM(amount) total_paid FROM `payment_history` where booking_id = '.$id);
			$select_old_price = $old_payment_sql->fetch_assoc();
			$total_paid = $select_old_price['total_paid'];
			$currentTime = time();
			$diff = abs($currentTime - $row_vehicle['vehicle_in_date_time']);
			$fullDays    = floor($diff/(60*60*24));   
			$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
			$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
			//echo $fullHours.' Hours, '.$fullMinutes.' Minutes';
				
			//$fullDays = 1;
			if($fullDays < 1){
				// HRS Calculation
				if($fullMinutes > 1){
					$newHrs = $fullHours + 1;
				} else {
					$newHrs = $fullHours;
				}

				//$newHrs = 3;
				$farepricesql = $con->query("SELECT * FROM `fare_info` where initial_hr <= ".$newHrs." AND ending_hr > ".$newHrs." AND veh_type = '".$vehicle_type."' AND user_id = ".$vendor_id." AND hr_status !='max' LIMIT 1");
				$fareprice_vehicle = $farepricesql->num_rows;
				if($fareprice_vehicle==1) {
					$return = true;
					$select_price = $farepricesql->fetch_assoc();
					$amount = $select_price['amount'];
					if($select_price['hr_status']=='bs_fare'){
						$total_due_Amount = 0;
						$parking_price = $total_paid;
					} else {
						$totalextraHrs = $newHrs - $select_price['initial_hr'];
						$total_due_Amount = $totalextraHrs * $amount;
						$parking_price = $total_due_Amount + $total_paid;
					}
				}		 
			} else if($fullDays >= 1){
				// DAYs Calculation
				if($fullHours > 1){
					$newDays = $fullDays + 1;
				} else {
					$newDays = $fullDays;
				}

				$farepricesql = $con->query("SELECT * FROM `fare_info` where veh_type = '".$vehicle_type."' AND hr_status ='max' LIMIT 1");
				$fareprice_vehicle = $farepricesql->num_rows;
				if($fareprice_vehicle==1) {
					$return = true;
					$select_price = $farepricesql->fetch_assoc();
					$amount = $select_price['amount'];
					$parking_price = $newDays * $amount;
					$total_due_Amount = $parking_price - $total_paid;
				}	
			}


			if($return==true){
				$array['error_code'] = 200;
				$array['message'] = 'Price Found Successfully';
				$array['total_parking_price'] = $parking_price;
				$array['due_parking_price'] = $total_due_Amount;
			} else {
				$array['error_code'] = 400;
				$array['message'] = 'Price Not Found';
			}	
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Vehicle Not Found';	
		}

	}		
				
}  else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

//echo '<pre>'; print_r($array);
$finalarray['response'] = $array;
echo json_encode($finalarray);