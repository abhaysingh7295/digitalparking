<?php  require_once '../config.php';

$regi =  json_decode($_REQUEST['request']);
//$regi =  json_decode('{"customer_id":"182"}');

if($regi){
	$customer_id = $regi->customer_id;
	$select_monthly_pass = $con->query("SELECT * FROM `monthly_pass` Where customer_id=".$customer_id." ORDER BY id DESC");
	$numrows_monthly_pass = $select_monthly_pass->num_rows;

	if($numrows_monthly_pass > 0){
		while($row_monthly_pass=$select_monthly_pass->fetch_assoc())
		{
			$vendor_id = $row_monthly_pass['vendor_id'];

			$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where vehicle_number='".$row_monthly_pass['vehicle_number']."'");
            $qr_code_row = $select_qr->fetch_assoc();
           	$qr_code = $qr_code_row['qr_code'].'.png';

            $QR_FILE_DIR = CUSTOMER_QR_DIR.$qr_code;
            if(file_exists($QR_FILE_DIR)){
            	$vqrcode = CUSTOMER_QR_URL.$qr_code;
            } else {
            	$vqrcode = '';	
            }

            $row_monthly_pass['qr_code'] = $vqrcode;

			if($row_monthly_pass['vehicle_image']!=''){
				$vehicle_image = MONTHLY_PASS_URL.$vendor_id.'/'.$row_monthly_pass['vehicle_image'];
			} else {
				$vehicle_image = '';
			}
			$row_monthly_pass['vehicle_image'] = $vehicle_image;

			if($row_monthly_pass['user_image']!=''){
				$user_image = MONTHLY_PASS_URL.$vendor_id.'/'.$row_monthly_pass['user_image'];
			} else {
				$user_image = '';
			}
			$row_monthly_pass['user_image'] = $user_image;

			if($row_monthly_pass['status']==1){
				$row_monthly_pass['pass_status'] = 'Active';
			} else if($row_monthly_pass['status']==2){
				$row_monthly_pass['pass_status'] = 'Applied';
			} else { 
				$row_monthly_pass['pass_status'] = 'Expired';
			}


            if($row_monthly_pass['start_date']){
               $row_monthly_pass['start_date'] = date('d-m-Y', strtotime($row_monthly_pass['start_date']));
            }
            if($row_monthly_pass['end_date']){
               $row_monthly_pass['end_date'] = date('d-m-Y', strtotime($row_monthly_pass['end_date']));
            }


			$select_vendor = $con->query("SELECT * FROM `pa_users` Where id=".$vendor_id."");
			$row_vendor=$select_vendor->fetch_assoc();
			$row_monthly_pass['vendor_details'] = $row_vendor;

			$MonthlyPassArray[] = $row_monthly_pass;
		}

		$finalArray['error_code'] = 200;
		$finalArray['result'] = $MonthlyPassArray;
	} else {
		$finalArray['error_code'] = 400;
		$finalArray['message'] = 'No Monthly Pass found';
	}

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);
//echo '<pre>'; print_r($resparray);