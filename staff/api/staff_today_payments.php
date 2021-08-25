<?php 
include '../../config.php';
include '../../administration/functions.php';


$request = $_REQUEST['request'];
$regi =  json_decode($request);

/*$regi =  json_decode('{"staff_id":"75", "vendor_id":"150"}');*/
$currentdate = date('Y-m-d');
if($regi){

	$vendor_id = $regi->vendor_id;
	$staff_id = $regi->staff_id;
	
	/*$active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
	if($active_plans_row['report_export_capacity'] > 0){
		$getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
		$getend = $currentdate;
	} else {
		$getstart = $currentdate;
		$getend = $currentdate;
	}*/

	$getstart = $currentdate;
	$getend = $currentdate;


 	$select_payments = $con->query("SELECT CASE WHEN sum(ph.amount) > 0 THEN sum(ph.amount) ELSE 0 END as total_amount FROM `vehicle_booking` as vb LEFT JOIN payment_history as ph on ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (vb.staff_in = ".$staff_id." OR vb.staff_out = ".$staff_id.") AND ph.staff_id = ".$staff_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY vb.id DESC ");

 		$row = $select_payments->fetch_assoc();
 		$payment_array['total_amount'] = $row['total_amount'];
 		$finalArray['error_code'] = 200;
		$finalArray['result'] = $payment_array;

} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'Please provide request parameter';
}

$resparray['response'] = $finalArray;
echo json_encode($resparray);
//echo '<pre>'; print_r($resparray);