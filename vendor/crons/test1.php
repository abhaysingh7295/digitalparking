<?php include '../../config.php'; 

//include '../../administration/functions.php';

function CalculateFareAmount($con,$vendor_id,$vehicle_number,$vehicle_type){

	$return = false;

	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id=".$vendor_id." AND vehicle_number ='".$vehicle_number."' AND vehicle_type  ='".$vehicle_type."' AND vehicle_status = 'In'");
	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle==1) {
		$row_vehicle = $select_vehicle->fetch_assoc();
		$id = $row_vehicle['id'];
		$old_payment_sql = $con->query('SELECT IF(SUM(amount), SUM(amount), 0) as total_paid FROM `payment_history` where booking_id = '.$id);
		$select_old_price = $old_payment_sql->fetch_assoc();
		$total_paid = $select_old_price['total_paid'];
		$currentTime = time();
		$diff = abs($currentTime - $row_vehicle['vehicle_in_date_time']);
		$fullDays    = floor($diff/(60*60*24));   
		$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
		$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);



		$fullSeconds = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60 - $fullMinutes*60);


		echo $fullSeconds;


		$fullMinutes = 0;

		if($fullDays < 1){
			echo "Test 1";
			// HRS Calculation
			if($fullMinutes >= 0){
				$newHrs = $fullHours + 1;
			} else {
				$newHrs = $fullHours;
			}
			$farepricesql = $con->query("SELECT * FROM `fare_info` where veh_type = '".$vehicle_type."' AND user_id = ".$vendor_id." AND hr_status !='max' ORDER BY hr_status");
			$fareprice_vehicle = $farepricesql->num_rows;
			if($fareprice_vehicle > 0) {
				$return = true;
				$price_array = array();
				
				while($select_price=$farepricesql->fetch_assoc())
				{
					$amount = $select_price['amount'];
					$initial_hr = $select_price['initial_hr'];
					$ending_hr = $select_price['ending_hr'];
					$arrayString = $initial_hr.'-'.$ending_hr.'-'.$newHrs;
					if($select_price['hr_status']=='bs_fare'){
						if($initial_hr < $newHrs && $ending_hr >= $newHrs){ 
							$price_array[$arrayString] = $amount;
						} else if($ending_hr <= $newHrs){
							$price_array[$arrayString] = $amount;
						}
					} else if($select_price['hr_status']=='per_hr'){
						if($initial_hr < $newHrs && $ending_hr >= $newHrs){
							$hrcal = $newHrs - $initial_hr;
							$price_array[$arrayString] = $hrcal * $amount;
						} else if($ending_hr <= $newHrs){
							$hrcal = $ending_hr - $initial_hr;
							$price_array[$arrayString] = $hrcal * $amount;
						}
					}				
				}
				$totalPrice_Calculate = array_sum($price_array);
				$total_due_Amount = $totalPrice_Calculate - $total_paid;

				$parking_price = $total_due_Amount + $total_paid;
			} else {
				$return = true;
				$parking_price = 0;
				$total_due_Amount = $parking_price - $total_paid;
			}
		} else if($fullDays >= 1){
			// DAYs Calculation
			//$fullHours = 0;
			if($fullHours > 1){
				$newDays = $fullDays + 1;
			} else {
				$newDays = $fullDays;
			}

			echo "Test 2";
			$farepricesql = $con->query("SELECT * FROM `fare_info` where veh_type = '".$vehicle_type."' AND user_id = ".$vendor_id." AND hr_status ='max' LIMIT 1");
			$fareprice_vehicle = $farepricesql->num_rows;
			if($fareprice_vehicle==1) {
				$return = true;
				$select_price = $farepricesql->fetch_assoc();
				$amount = $select_price['amount'];
				$parking_price = $newDays * $amount;
				$total_due_Amount = $parking_price - $total_paid;
			} else {
				$return = true;
				$parking_price = 0;
				$total_due_Amount = $parking_price - $total_paid;
			}	
		}
	}  
		if($return==true){
			$array['total_parking_price'] = $parking_price;
			$array['due_parking_price'] = $total_due_Amount;
		} else {
			$array['total_parking_price'] = 0;
			$array['due_parking_price'] = 0;
		}

	print_r($array);
}




$fare_calculation = CalculateFareAmount($con,150,'RJ14TU4545','2W');

