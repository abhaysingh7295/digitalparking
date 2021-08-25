<?php  require_once '../config.php';
	include 'function.php';
include '../administration/functions.php';

/*$regi =  json_decode('{"customer_id":"150",
	"vendor_id":"150",
"mobile_number":"9874563210",
"vehicle_number":"RJ14DE1752",
"vechicle_type":"2W",
"amount":"0",
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
	$mobile_number = $regi->mobile_number;
	$amount = $regi->amount;
	$payment_type = $regi->payment_type;
	$transaction_id = $regi->transaction_id;
	$order_id = $regi->order_id;
	$vehicle_out_date_time = time();
	$vehicle_status = 'Out';


	$vendor_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as vendor_name, parking_name FROM pa_users WHERE id = ".$vendor_id."");
	$vendor_ow=$vendor_query->fetch_assoc();

 	$customer_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as customer_name FROM pa_users WHERE id = ".$customer_id.""); 
 	$customer_ow=$customer_query->fetch_assoc();

 	$sendmessage = 'Hello, '.$customer_ow['customer_name'].'Your vehicle '.$vehicle_number.' '.$vehicle_type.' successfully out from '.$vendor_ow['parking_name'].' on '.date('Y-m-d h:i A',$vehicle_out_date_time).', Rs. '.$amount.', View More https://bit.ly/3iNx8b0';

	$message = urlencode($sendmessage);


	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle==1) {
		$val_vehicle_id = $select_vehicle->fetch_assoc();
		$booking_id = $val_vehicle_id['id'];
		$update_query = "update `vehicle_booking` SET vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where id = ".$booking_id.""; 
		if ($con->query($update_query) === TRUE) {

			UpdateUsersLatLong($con,$customer_id,$latitude,$longitude);
			SensitiveVechilesNotify($con,$vendor_id,$vehicle_number,$booking_id);
			SendVehicleinoutSMS($mobile_number, $message);
			//SendSMS($mobile_number, $message);

			if($amount > 0){
				if($payment_type=='Wallet'){
					$transaction_remarks = 'Amount Detect by '.$amount.'Rs / Ref. '. $transaction_id.' / Vehicle Number '.$vehicle_number;
					$amount_type = 'Dr';
					WalletTransaction($con,$customer_id,$amount,$transaction_id,$transaction_remarks,$amount_type,$payment_type,$order_id);	
				}
			} else {
				$transaction_id = '';
			}

			$con->query("INSERT INTO payment_history(booking_id,order_id,amount,payment_type,transaction_id,payment_date_time) VALUES('$booking_id','$order_id','$amount','$payment_type','$transaction_id','$vehicle_out_date_time')");

			$array['error_code'] = 200;
			$array['message'] = 'Vehicle Out Successfully';
		} else {
			$array['error_code'] = 400;
			$array['message'] = 'Some occurred error';
		}
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Vehicle not in Parking';
	}
} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
echo json_encode($finalarray);