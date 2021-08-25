<?php 
include 'config.php';
include 'admin/common-functions.php';

function sendDataToPolice($jsonBookVehicleData){
//API Url
$url = 'http://164.100.222.109/policetest/policeparking/api/user/ParkingCheckOut';
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
/*$jsonData = array(
    'username' => 'MyUsername',
    'password' => 'MyPassword'
);*/
 
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonBookVehicleData);
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//Execute the request
return  curl_exec($ch);

}

$user_id = $_REQUEST['user_id'];
$vehicle_number = $_REQUEST['vehicle_number'];
$due_amount = $_REQUEST['due_amount'];
$to_pay_amount = $_REQUEST['to_pay_amount'];
$vehicle_out_date_time = date('Y-m-d H:i:s');
$vehicle_status = 'Out';

$select_vehicle_id = $con->query("SELECT * FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
$val_vehicle_id = $select_vehicle_id->fetch_assoc();
$admin_commission = round(($val_vehicle_id['total_amount'] * $site_settings_row['admin_commission']) / 100);

$amount_type = 'Cr';

$num0 = (rand(10,100));
$num1 = date("Ymd");
$num2 = (rand(100,1000));
$transaction_id = $num0 . $num1 . $num2;
$transaction_remarks = 'Admin Commssion / Vehicle '.$vehicle_number.' / Reference id '.$transaction_id;


$select_vendor_wallet = $con->query("SELECT * FROM `pa_users` Where id='".$user_id."'");
$val_vendor_wallet = $select_vendor_wallet->fetch_assoc();
$wallet_amount = $val_vendor_wallet['wallet_amount'] - $admin_commission;

if($val_vendor_wallet['wallet_amount'] >= $admin_commission){
	$aqled = "update `vehicle_book` SET due_amount = '".$due_amount."', to_pay_amount = '".$to_pay_amount."', vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where user_id = ".$user_id." AND vehicle_number = '".$vehicle_number."' AND vehicle_status='In'";

$ress = $con->query($aqled);
	 if($ress){
	     
	     $select_police_responseid = $con->query("SELECT police_data_in_responseid FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_number='".$vehicle_number."'");
        if($select_police_responseid->num_rows>0){
            
            $id = $select_police_responseid->fetch_assoc();
            $id = $id['police_data_in_responseid'];
            	$jsonData = array(
    			"ResponseId" => $id,
    			"VechileOutTime"=>$vehicle_out_date_time,
    			"OutTimeLatitude" => '0.0',
    			"OutTimeLongitutude" => '0.0'
    			);
    			$police_data=json_decode(sendDataToPolice($jsonData),true);
    				if($police_data['status']=="1" && $police_data['message']=="success"){
							    $police_data_out_response_id=json_decode($police_data['Text'],true);
							    $update_sql = "UPDATE vehicle_book SET police_data_out='success', police_data_out_responseid='".$police_data_out_response_id['ResponseId']."'  WHERE user_id='".$user_id."'   and  vehicle_number='".$vehicle_number."'";
                                mysqli_query($con,$update_sql);
							}else{
					            $txt= json_decode($police_data['Text'],true);
					            //$txt=str_replace("'","",$txt);
							    $update_sql = "UPDATE vehicle_book SET police_data_out='$txt'  WHERE user_id='".$user_id."' and  vehicle_number='".$vehicle_number."'";
                                mysqli_query($con,$update_sql);
							}
        
            
        }
	 	$array['error_code'] = 200;
		$array['message'] = 'Vehicle Checkout Successfully';
	$con->query("INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$admin_commission','$amount_type','$transaction_id','Wallet','$vehicle_out_date_time','$transaction_remarks')");
	$con->query("update `pa_users` SET wallet_amount = '".$wallet_amount."' where id = ".$user_id."");	

	 } else {
	$array['error_code'] = 400;
	$array['message'] = 'Some occurred error';
	}
} else {
	$array['error_code'] = 300;
	$array['message'] = 'Your Wallet Amount less then Admin Commssion (Rs.'.$admin_commission.'). You can\'t checkout any Vehicle. Please Contact to Admin to renew wallet amount';
}


$finalarray['result'] = $array;
echo json_encode($finalarray);