<?php  require_once '../config.php';
include 'function.php';
include '../administration/functions.php';

/*$regi =  json_decode('{"customer_id":"182",
"vendor_id":"150",
"arriving_time":"1596090600",
"leaving_time":"1596090900",
"vehicle_number":"RJ14DE1752",
"vechicle_type":"2W",
"latitude":"",
"longitude":"",
"booking_date_time":"1596090600",
"amount":"10",
"payment_type":"Wallet",
"transaction_id":"4220180927936"
}');*/


$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$customer_id = $regi->customer_id;
	$vendor_id = $regi->vendor_id;
	$vehicle_number = $regi->vehicle_number;
	$vehicle_type = $regi->vechicle_type;
	$booking_date_time = $regi->booking_date_time;
	$arriving_time = $regi->arriving_time;
	$leaving_time = $regi->leaving_time;
	$amount = $regi->amount;
	$payment_type = $regi->payment_type;
	$transaction_id = $regi->transaction_id;
	$latitude = $regi->latitude;
	$longitude = $regi->longitude;
	$order_id = '';
	$status = 'Booked';

	$ParkingCapacity = getParkingCapacity($con,$vendor_id);

	if($ParkingCapacity['online_capacity'] > 0){

		$select_vehicle = $con->query("SELECT * FROM `vehicle_pre_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND status='".$status."'"); 
	$numrows_vehicle = $select_vehicle->num_rows;
		if($numrows_vehicle==0) {
			$insert_query = "INSERT INTO vehicle_pre_booking(vendor_id,customer_id,vehicle_number,vehicle_type,arriving_time,leaving_time,status,latitude,longitude,booking_date_time,amount,payment_type,transaction_id) VALUES('$vendor_id','$customer_id','$vehicle_number','$vehicle_type','$arriving_time','$leaving_time','$status','$latitude','$longitude','$booking_date_time','$amount','$payment_type','$transaction_id')";
			if ($con->query($insert_query) === TRUE) {
				$pre_booking_id= $con->insert_id;
				if($amount > 0){
					if($payment_type=='Wallet'){
						$transaction_remarks = 'Amount Detect by '.$amount.'Rs / Ref. '. $transaction_id.' / Vehicle Number '.$vehicle_number;
						$amount_type = 'Dr';
						WalletTransaction($con,$customer_id,$amount,$transaction_id,$transaction_remarks,$amount_type,$payment_type,$order_id);	
					}
					$con->query("INSERT INTO payment_history(pre_booking_id,amount,payment_type,transaction_id,payment_date_time) VALUES('$pre_booking_id','$amount','$payment_type','$transaction_id','$booking_date_time')");
				}
				$array['error_code'] = 200;
				$array['message'] = 'Vehicle Online Booking Successfully';
			}
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Vehicle Already Booked';
		}
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Parking Full you can not Booked';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray); echo '</	pre>';
echo json_encode($finalarray);