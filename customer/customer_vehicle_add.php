<?php  require_once '../config.php';
include '../administration/functions.php';

/*$regi =  json_decode('{"customer_id":"165",
"vehicle_no":"RJ14DE1752",
"vehicle_type":"2W"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$customer_id  = $regi->customer_id; 
	$vehicle_no  = $regi->vehicle_no;
	$vehicle_type  = $regi->vehicle_type;
	$date_time  = time();
	$vehicle_photo = $regi->vehicle_photo;


	$vehicle_photo_filename = $_FILES['vehicle_photo']['name'];
	$vehicle_photo_path = "../uploads/" .$vehicle_photo_filename;
	$vehicle_photo_name = '';
	if($_FILES['vehicle_photo'])  {
		$vehicle_photo_type = $_FILES['vehicle_photo']['type'];
			if(($vehicle_photo_type == 'image/gif') || ($vehicle_photo_type == 'image/jpeg') || ($vehicle_photo_type == 'image/jpg') || ($vehicle_photo_type == 'image/png')){  
	 			if(move_uploaded_file($_FILES['vehicle_photo']['tmp_name'], $vehicle_photo_path))
	 			{
					$vehicle_photo_name = $vehicle_photo_filename;
				} 
	 		}
	}

	$vehicle_rc_filename = $_FILES['vehicle_rc']['name'];
	$vehicle_rc_path = "../uploads/" .$vehicle_rc_filename;
	$vehicle_rc_name = '';
	if($_FILES['vehicle_rc'])  {
		$vehicle_rc_type = $_FILES['vehicle_rc']['type'];
			if(($vehicle_rc_type == 'image/gif') || ($vehicle_rc_type == 'image/jpeg') || ($vehicle_rc_type == 'image/jpg') || ($vehicle_rc_type == 'image/png')){  
	 			if(move_uploaded_file($_FILES['vehicle_rc']['tmp_name'], $vehicle_rc_path))
	 			{
					$vehicle_rc_name = $vehicle_rc_filename;
				} 
	 		}
	}

	$unique_vehicle_code = rand(1111111111111111,9999999999999999);

	$chk_code = $con->query("SELECT * FROM `customer_vehicle` Where unique_vehicle_code='".$unique_vehicle_code."'"); 
 	$numrows_code = $chk_code->num_rows;

 	if($numrows_code > 0){
 	 $unique_vehicle_code = rand(1111111111111111,9999999999999999);	
 	}

	$insert_query = "INSERT INTO customer_vehicle(customer_id,unique_vehicle_code,vehicle_number,vehicle_type,vehicle_photo,vehicle_rc,date_time) VALUES('$customer_id','$unique_vehicle_code','$vehicle_no','$vehicle_type','$vehicle_photo_name','$vehicle_rc_name','$date_time')";

	if ($con->query($insert_query) === TRUE) {
		$ref_id = $con->insert_id;
		$ref_type = 'customer_vehicle';
		//GenrateVechileQRcodes($con, $ref_id, $ref_type);
		GenrateVechileNumberQRcodes($con,$vehicle_no,$ref_type);
		$array['error_code'] = 200;
		$array['message'] = 'Vehicle added Successfully';
	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Some occurred error';
	}

} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}

$finalarray['response'] = $array;
echo json_encode($finalarray);