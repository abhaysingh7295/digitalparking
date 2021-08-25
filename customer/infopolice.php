<?php  require_once '../config.php';

/*$regi =  json_decode('{"customer_id":"150",
"image":"imagedata",
"filename":"filename",
"vechicle_no":"RJ14DE1752",
"vechicle_type":"2W",
"vechicle_category":"No Parking",
"remark":"Test",
"latitude":"latitude",
"longitude":"longitude"}');*/

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$user_id  = $regi->customer_id; 
	$vechicle_no  = $regi->vechicle_no;
	$vechicle_type  = $regi->vechicle_type;
	$vechicle_category  = $regi->vechicle_category;
	$remark  = $regi->remark;
	$latitude  = $regi->latitude;
	$longitude  = $regi->longitude;
	$submit_date = time();


	//print_r($_FILES['image']); die; 
	$filename = $_FILES['image']['name'];
	$file_path = "../police-info-upload/" .$filename;
	$NewFileName = '';
	if($_FILES['image'])  {
		$file_type = $_FILES['image']['type'];
			if(($file_type == 'image/gif') || ($file_type == 'image/jpeg') || ($file_type == 'image/jpg') || ($file_type == 'image/png')){  
	 			if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path))
	 			{
					$NewFileName = $filename;
				} 
	 		}
	}

	$insert_query = "INSERT INTO info_police(user_id,upload_image,vechicle_no,vechicle_type,vechicle_category, remark, latitude, longitude,submit_date) VALUES('$user_id','$NewFileName','$vechicle_no','$vechicle_type','$vechicle_category','$remark', '$latitude', '$latitude','$submit_date')";
	if ($con->query($insert_query) === TRUE) {
		$info_police = $con->insert_id;
		$array['error_code'] = 200;
		$array['message'] = 'Inform to Police added Successfully';
		$array['res_image'] = $_FILES['image'];
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