<?php 
include 'config.php';

$police_data="";
$user_id = $_REQUEST['user_id'];
$vehicle_number = $_REQUEST['vehicle_number'];
$mobile_number = $_REQUEST['mobile_number'];
$advance_amount = $_REQUEST['advance_amount'];
$booked_by = $_REQUEST['booked_by'];
$vehicle_type = $_REQUEST['vehicle_type'];
$parking_type = $_REQUEST['parking_type'];
$vehicle_in_date_time = date('Y-m-d H:i:s');
$vehicle_status = 'In';

$mail = $con->query("SELECT user_email FROM `pa_users` Where id='".$user_id."'");
if($mail->num_rows){
    $val_capicity = $mail->fetch_assoc();
    $booked_by = $val_capicity['user_email'];
}



function sendDataToPolice($jsonBookVehicleData){
//API Url
$url = 'http://164.100.222.109/policetest/policeparking/api/user/ParkingCheckIn';
 
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
$select_capicity = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
$numrows_capicity = $select_capicity->num_rows;
	if($numrows_capicity > 0){
		$val_capicity = $select_capicity->fetch_assoc();
		if($vehicle_type==2){
			$QueryCountParking = "SELECT count(*) as totalBooked FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_type='2' AND vehicle_status='In'"; 
			$TotalCapcity = $val_capicity['parking_capacity_2'];
		} else {
			$QueryCountParking = "SELECT count(*) as totalBooked FROM `vehicle_book` Where user_id='".$user_id."' AND (vehicle_type='3' OR vehicle_type='4') AND vehicle_status='In'"; 
			$TotalCapcity = $val_capicity['parking_capacity_3_4'];
		}
		$totalbooked = $con->query($QueryCountParking);
		$val_totalbooked = $totalbooked->fetch_assoc();
		$totalBooked = $val_totalbooked['totalBooked'];
			if($totalBooked < $TotalCapcity){
				$select_vehicle = $con->query("SELECT * FROM `vehicle_book` Where user_id='".$user_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'"); 
				$val_vehicle = $select_vehicle->fetch_assoc();
				$numrows_vehicle = $select_vehicle->num_rows;
					if($numrows_vehicle==0) {
						$insert_query = "INSERT INTO vehicle_book(user_id,vehicle_number,mobile_number,parking_type,advance_amount,booked_by,vehicle_type,vehicle_in_date_time,vehicle_status) VALUES('$user_id','$vehicle_number','$mobile_number','$parking_type','$advance_amount','$booked_by','$vehicle_type','$vehicle_in_date_time','$vehicle_status')";
						if ($con->query($insert_query) === TRUE) {
							$jsonData = array(
    							"VendorCode" => $user_id,
    							"VechileNo" => $vehicle_number,
    							"MobileNo" => $mobile_number,
    							"BookedBy" => $booked_by,
    							"VechileType" => $vehicle_type,
    							"Status" => $vehicle_status,
    							"VechileIntime"=>$vehicle_in_date_time,
    							"InTimeLatitude" => '0.0',
    							"InTimeLongitutude" => '0.0'
    							);
							$police_data=json_decode(sendDataToPolice($jsonData),true);
							if($police_data['status']=="1" && $police_data['message']=="success"){
							    $police_data_in_response_id=json_decode($police_data['Text'],true);
							    $update_sql = "UPDATE vehicle_book SET police_data_in='success', police_data_in_responseid='".$police_data_in_response_id['ResponseId']."'  WHERE user_id='".$user_id."'   and  vehicle_number='".$vehicle_number."'";
                                mysqli_query($con,$update_sql);
							}else{
					            $txt= json_decode($police_data['Text'],true);
					            $txt=str_replace("'","",$txt);
							    $update_sql = "UPDATE vehicle_book SET police_data_in='$txt'  WHERE user_id='".$user_id."' and  vehicle_number='".$vehicle_number."'";
                                mysqli_query($con,$update_sql);
							}
							
							$error_code = 200;
							$array['error_code'] = 200;
							$array['message'] = 'Vehicle Book Added Successfully';
							$array['veh_no'] = $vehicle_number;
							$array['veh_type'] = $vehicle_type;
							$array['indate'] = $vehicle_in_date_time;
							$array['adv_amt'] = $advance_amount;
							$array['police_data']=$police_data['status'];
							$array['police_data_message']=$police_data['Text'];

							
						} else {
							$array['error_code'] = 400;
							$array['message'] = 'Some occurred error';
						}
					} else {
						$array['error_code'] = 501;
						$array['message'] = 'Vehicle Allready in Parking';
					}
			} else {
				$array['error_code'] = 503;
				$array['message'] = 'Parking Capcity full. Now not Available space in parking.';
			}
		} else {
			$array['error_code'] = 502;
			$array['message'] = 'Parking Capcity Not Available';
	}
$finalarray['result'] = $array;
echo json_encode($finalarray);

