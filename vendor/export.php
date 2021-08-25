<?php 
include '../config.php';
include '../administration/functions.php';
ob_start(); session_start();
set_time_limit(500000);
function outputCSV($data,$file_name = 'file.csv') {
       # output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
    
        # Start the ouput
        $output = fopen("php://output", "w");
        
         # Then loop through the rows
        foreach ($data as $row) {
            # Add the rows to the body
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        # Close the stream off
        fclose($output);
 }


$user_id = $_SESSION["current_user_ID"];

$active_plans_row = GetVendorActivatedPlan($con,$user_id);

$export_capacity = $active_plans_row['report_export_capacity'];

if($_REQUEST['action']=='parking_history'){

 $condition = "";
    if (isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date']) && isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date'])) {
        $getstart = $_REQUEST['start_date'];
        $getend = $_REQUEST['end_date'];
        $condition .= " AND (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '" . $getend . "' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '" . $getend . "') ";
    }
    if (isset($_REQUEST['staff_name']) && !empty($_REQUEST['staff_name'])) {
        $staff = $_REQUEST['staff_name'];
        $condition .= " And sdin.staff_name LIKE '%$staff%'";
    }
    if (isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
        $status = $_REQUEST['status'];
        $condition .= " And b.vehicle_status='" . $status . "'";
    }
    if (isset($_REQUEST['vehicle_type']) && !empty($_REQUEST['vehicle_type'])) {
        $vehicle_type = $_REQUEST['vehicle_type'];
        $condition .= " And b.vehicle_type='" . $vehicle_type . "'";
    }

    $vehicle_book_query = $con->query("SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name,b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where   b.vendor_id = '" . $user_id . "' $condition ORDER BY b.serial_number DESC");
    /*$diff = abs(strtotime($getstart) - strtotime($getend));
    $years = floor($diff / (365*60*60*24));  
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)) + 1;

    if($months > $export_capacity){
     echo "<script>
      alert('You can not export grater ".$months." month. If you want to export more months you needs to upgrate your subscrption Plan');
            window.location.href = 'parking-history.php';
        </script>";
    } else {*/
		 
     // $vehicle_book_query = $con->query("SELECT b.*, u.first_name FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') AND b.vendor_id = '".$user_id."' ORDER BY b.id DESC");

    #$vehicle_book_query = $con->query("SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where b.vendor_id = '".$user_id."' AND (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");


		  $fileName = 'parking-history-'.$getstart.'-'.$getend;
		  $arrayvalues = array();
      $arrayvalues[] = array("S No","Booking ID", "Vehicle Number", "Vehicle Type", "Customer",  "In Time", "Out Time", "Duration", "Amount", "In Staff", "Out Staff", "Status", "Book Type");
 	    while($row=$vehicle_book_query->fetch_assoc())
      	{
      		$id = $row['id'];  
            $serial_number=$row['serial_number'];
      		$vehicle_number = $row['vehicle_number'];
      		$vehicle_type = $row['vehicle_type'];
      		$mobile_number = $row['mobile_number'];
      		$customer = $row['first_name'].' '.$mobile_number;
      		$vehicle_in_date_time = date('Y-m-d h:i A',$row['vehicle_in_date_time']);
      		$vehicle_out_date_time = date('Y-m-d h:i A',$row['vehicle_out_date_time']);
  			  $vehicle_book_payment = $con->query("SELECT IF(SUM(amount) > 0, SUM(amount), 0) as total_amount FROM `payment_history` where booking_id = '".$id."'");
  			$row_payment=$vehicle_book_payment->fetch_assoc();
  			$amount = $row_payment['total_amount'];
  			$vehicle_status = $row['vehicle_status'];
        $in_staff_name = $row['in_staff_name'];
        $out_staff_name = $row['out_staff_name'];

        $passtype = '';
        if($row['qr_type']=='monthly_pass'){ $passtype = ' (Pass)'; }

        $parking_type = $row['parking_type'].$passtype; 

        if($vehicle_status=='In'){
            $currentTime = time();
            $diff = abs($currentTime - $row['vehicle_in_date_time']); 
          } else {
            $diff = abs($row['vehicle_out_date_time'] - $row['vehicle_in_date_time']);
          }

          $fullDays    = floor($diff/(60*60*24));   
          $fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
          $fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
          $totalDuration = '';
          if($fullDays > 0){
            $totalDuration .= $fullDays.' Day ';
          }
          if($fullHours > 0){
            $totalDuration .= $fullHours.' Hrs ';
          }
          //if($fullMinutes > 0){
            $totalDuration .= $fullMinutes.' Mins';
          //}

		    $arrayvalues[] = array($serial_number,$id, $vehicle_number, $vehicle_type, $customer, $vehicle_in_date_time, $vehicle_out_date_time, $totalDuration, $amount, $in_staff_name, $out_staff_name, $vehicle_status, $parking_type);
      	}
       //echo '<pre>'; print_r($arrayvalues);  echo '</pre>';
      	outputCSV($arrayvalues,$fileName.'.csv');
     // }
 		die;
	
	
}else {
		echo "<script>
		alert('Please Select Atleast one filter for Export Parking History');
            window.location.href = 'parking-history.php';
        </script>";
	}
