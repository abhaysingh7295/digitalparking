<?php 
/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;*/

function getAdminSettings($con){
	$site_settings_query = $con->query("select * from `settings` where id = '1'");
	$site_settings_row = $site_settings_query->fetch_assoc();
	return $site_settings_row;
}

function AdminUserPermission($con, $userId){
	$admin_user = $con->query("select access_permission from `login` where Id = '".$userId."'");
	$admin_user_row = $admin_user->fetch_assoc();
	$row_access_permission = explode(',',$admin_user_row['access_permission']);
	$predefined_access = array('profile.php','admin-password-change.php');
	$access_permission = array_merge($row_access_permission,$predefined_access);
	return $access_permission;
}
function StaffUserPermission($con, $userId){
	$admin_user = $con->query("select access_permission from `staff_details` where staff_id = '".$userId."'");
	$admin_user_row = $admin_user->fetch_assoc();
	$row_access_permission = explode(',',$admin_user_row['access_permission']);
	$predefined_access = array('profile.php','admin-password-change.php');
	$access_permission = array_merge($row_access_permission,$predefined_access);
	return $access_permission;
}

function UpdateUsersLatLong($con,$user_id,$latitude,$longitude){
	$con->query("update `pa_users` SET latitude = '".$latitude."', longitude = '".$longitude."' where id = ".$user_id."");
}

function CalculateFareAmount($con,$vendor_id,$vehicle_number,$vehicle_type){

	$return = false;
	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id=".$vendor_id." AND vehicle_number ='".$vehicle_number."' AND vehicle_type  ='".$vehicle_type."' AND vehicle_status = 'In'");
	$numrows_vehicle = $select_vehicle->num_rows;
	if($numrows_vehicle==1) {
		$row_vehicle = $select_vehicle->fetch_assoc();
		$id = $row_vehicle['id'];
		$staff_vehicle_type = $row_vehicle['staff_vehicle_type'];

		if($staff_vehicle_type=='yes'){
			$vehicle_type = 'Staff';
		}

		$old_payment_sql = $con->query('SELECT IF(SUM(amount), SUM(amount), 0) as total_paid FROM `payment_history` where booking_id = '.$id);
		$select_old_price = $old_payment_sql->fetch_assoc();
		$total_paid = $select_old_price['total_paid'];
		$currentTime = time();
		$diff = abs($currentTime - $row_vehicle['vehicle_in_date_time']);
		$fullDays    = floor($diff/(60*60*24));   
		$fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
		$fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);
		if($fullDays < 1){
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
			if($fullHours >= 1){
				$newDays = $fullDays + 1;
			} else {
				if($fullMinutes > 0){
					$newDays = $fullDays + 1;
				} else {
					$newDays = $fullDays;
				}
			}

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

	return $array; 
}



function AdminPermissionArray(){
	$permission = array(
		'index.php' => 'Dashboard',
		'infopolice.php' => 'Inform to Controle',
		'all-monthly-pass.php' => 'Vehicle Pass',
		'edit-monthly-pass.php' => 'Edit Monthly Pass',
		'digital-card-pre-payment.php' => 'Digital Card Pre Payment',
		'all-entity.php' => 'Parking Entity',
		'pre-bookings.php' => 'Online Bookings',
		'vehicle-payment-history.php' => 'Vehicle Payment History',
		'vehicle-search.php' => 'Vehicle Search',
		'all-vendors.php' => 'All Vendors',
		'user-details.php' => 'View Vendor Details',
		'edit-vendor-details.php' => 'Edit Vendor Details',
		'all-customers.php' => 'All Customers',
		'customer-vehicle.php' => 'View Customer Vehicles',
		'edit-customer-vehicle.php' => 'Edit Customer Vehicles',
		'wallet-history.php' => 'User Wallet History',
		'vendor-wallet-history.php' => 'Vendor Wallet History',
		'add-vendor-wallet.php' => 'Add Vendor Wallet',
		'all-admins.php' => 'All Admins',
		'add-admin.php' => 'Add/Edit Admin',
		'subscriptions-plan.php' => 'Subscriptions Plan',
		'add-subscription-plan.php' => 'Add/Edit Subscription Plan',
		'vendor-subscriptions.php' => 'View Vendor Subscriptions',
		'edit-vendor-subscription.php' => 'Edit Vendor Subscription',
		'all-police-stations.php' => 'Police Stations',
		'add-police-station.php' => 'Add/Edit Police Station',
		'all-sensitive-vehicles.php' => 'Sensitive Vehicles',
		'add-sensitive-vehicle.php' => 'Add/Edit Sensitive Vehicles',
		'view-sensitive-vehicle-remarks.php' => 'Sensitive Vehicles Remarks',
		'add-sensitive-vehicle-remark.php' => 'Add Sensitive Vehicle Remark',
		'settings.php' => 'Settings'
	);
	$permission = array_chunk($permission, ceil(count($permission) / 2), true);
	return $permission;
}

function StaffPermissionArray(){
	$permission = array(
		'index.php' => 'Dashboard',
		'add-fare.php' => 'Add Fare',
		'fare-info.php' => 'Fare Info',
		'new-renewpass.php' => 'Renew Vehicle Pass',
		'add-monthly-pass.php' => 'Add Monthly Pass',
		'all-monthly-pass.php' => 'All Monthly Pass',
		'vehicle-in.php' => 'Vehicle IN',
		'vehicle-out.php' => 'Vehicle OUT',
		'pre-bookings.php' => 'Pre Bookings',
		'parking-history.php' => 'Parking History',
		'payment-history.php' => 'Parking Payment Received',
		'block-vehicles.php' => 'All Block Vehicles',
		'add-block-vehicle.php' => 'Add Block Vehicle',
		'wallet-history.php' => 'Wallet History',
		'add-wallet.php' => 'Add Wallet Amount',
		'add-staff.php' => 'Add Staff',
		'all-staff.php' => 'All Staff',
		'staff-wise-report.php' => 'All Staffwise Report',
		'vehicle-type-wise-report.php' => 'Vehicle Type Wise Repor',
		'profile.php' => 'Profile',
		'my-qrcode.php' => 'My QR code',
		'subscriptions.php' => 'Subscriptions',
		'my-subscriptions.php' => 'My Subscriptions',
		'my-password-change.php'=>'Password Change'
		);
	$permission = array_chunk($permission, ceil(count($permission) / 2), true);
	return $permission;
}

function GetVendorActivatedPlan($con,$vendor_id){
	$activate_subscriptions_plans = $con->query("select * from `vendor_subscriptions` where vendor_id = ".$vendor_id." AND status = 1");
	
        $active_plans_row_row = $activate_subscriptions_plans->num_rows;
       
			if($active_plans_row_row==1) {
                             $active_plans_row = $activate_subscriptions_plans->fetch_assoc();
		$plan_end =  date('d-m-Y',$active_plans_row['subscription_end_date']);

		$t = time();
        $today = date('d-m-Y',$t);
        if($t < $active_plans_row['subscription_end_date']){
        	return $active_plans_row;
         }
         else{
         	return false;
                        }}else{
                            return false;
                        }	
         //return $active_plans_row;

}

function GetVendorsBlockedVechiles($con,$vendor_id){
	$Array_block_vechiles = array();
	$active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
	if($active_plans_row['block_vehicle']==1){
		$block_vechiles = $con->query("select vehicle_number from `block_vehicles` where vendor_id = ".$vendor_id."");
		while($row=$block_vechiles->fetch_assoc())
	    {
	    	$Array_block_vechiles[] = $row['vehicle_number'];
	    }
	}
    return $Array_block_vechiles;
}


function GetVendorsWantedVechiles($con,$vendor_id,$vehicle_number,$booking_id){
	$active_plans_row = GetVendorActivatedPlan($con,$vendor_id);
	if($active_plans_row['wanted_vehicle']==1){
		$wanted_vechiles = $con->query("select * from `wanted_vehicles` where vendor_id = ".$vendor_id." AND vehicle_number='".$vehicle_number."'");
		$numrows_vehicle = $wanted_vechiles->num_rows;
		if ($numrows_vehicle > 0) {
			$select_vehicle = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email as vendor_email, v.mobile_number as vendor_mobile FROM `vehicle_booking` as vb JOIN pa_users as v ON vb.vendor_id = v.id Where vb.id=".$booking_id." AND vb.vendor_id=".$vendor_id."");
			$row=$select_vehicle->fetch_assoc();
			extract($row);
			ob_start();
			?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <title>Vendors Wanted Vechiles Notification</title>
		    <style type="text/css">
			    body {margin: 0; padding: 0; min-width: 100%!important;}
			    .content {width: 100%; max-width: 600px;}  
		    </style>
		</head>
		<body yahoo bgcolor="#f6f8f1">
			<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
		    	<tr>
		    		<td>
						<table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr style="border-collapse:collapse"> 
									<td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;text-align: center;"><img src="http://thedigitalparking.com/digital-parking/administration/upload/logo.png"><br></td> 
								</tr>
								<tr>
									<td>
										<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" style="word-break:normal;color:rgb(0,0,0);font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;text-decoration-style:initial;text-decoration-color:initial;box-sizing:border-box;border-radius:3px;background-color:rgb(255,255,255);margin:0px;border:1px solid rgb(233,233,233)">
										   <tbody>
										      <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										         <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:20px">
										         	<strong>Wanted Vehicle Found in Our Parking!</strong><br><br><br>
										            Vehicle Details :- 
										            <br>Vehicle Number :-&nbsp; <?php echo $vehicle_number; ?>
										            <br>Mobile No :- <?php echo $mobile_number; ?>
										            <br>In Time :- <?php echo date('d/m/Y h:i A',$vehicle_in_date_time); ?>
										            <?php if($vehicle_status=='Out'){ ?> 
										           	<br>Out Time :- <?php echo date('d/m/Y h:i A',$vehicle_out_date_time); ?>
										            <?php } ?>
										            <br>Status :- <?php echo $vehicle_status; ?>		
										            <br>
										            
										            <table width="100%" cellpadding="0" cellspacing="0" style="word-break:normal;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										               <tbody>
										                  <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										                     <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:0px 0px 20px">
										                        <div><br></div>
										                        <div>Thanks,<br></div>
										                        <div>Team The Digital Parking <br></div>
										                     </td>
										                  </tr>
										               </tbody>
										            </table>
										         </td>
										      </tr>
										   </tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
		    		</td>
		    	</tr>
		    </table>
		</body>
		</html>
		<?php
			$message = ob_get_contents();
			ob_end_clean();
			$to = $vendor_email;
			$subject = 'Wanted Vehicle Found';
			SendEmailNotification($to,$subject,$message);
		}
	}
}

function SensitiveVechilesNotify($con,$vendor_id,$vehicle_number,$booking_id){
     
	$sensitive_vechiles = $con->query("select sensitive_vehicle.*,police_stations.mobile_number as police_stations_mobile  from `sensitive_vehicle` left join police_stations on police_stations.id=sensitive_vehicle.polic_station where sensitive_vehicle.vehicle_number='".$vehicle_number."' AND sensitive_vehicle.status = 0");
	$numrows_vehicle = $sensitive_vechiles->num_rows;
	if ($numrows_vehicle > 0) {
		$row_sensitive=$sensitive_vechiles->fetch_assoc();
		$select_vehicle = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email as vendor_email, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as vendor_address FROM `vehicle_booking` as vb JOIN pa_users as v ON vb.vendor_id = v.id Where vb.id=".$booking_id." AND vb.vendor_id=".$vendor_id."");
			$row=$select_vehicle->fetch_assoc();
			extract($row);
                    
			ob_start();   ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <title>Sensitive Vechiles Notification</title>
		    <style type="text/css">
			    body {margin: 0; padding: 0; min-width: 100%!important;}
			    .content {width: 100%; max-width: 600px;}  
		    </style>
		</head>
		<body yahoo bgcolor="#f6f8f1">
			<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
		    	<tr>
		    		<td>
						<table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr style="border-collapse:collapse"> 
									<td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;text-align: center;"><img src="http://thedigitalparking.com/digital-parking/administration/upload/logo.png"><br></td> 
								</tr>
								<tr>
									<td>
										<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" style="word-break:normal;color:rgb(0,0,0);font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;text-decoration-style:initial;text-decoration-color:initial;box-sizing:border-box;border-radius:3px;background-color:rgb(255,255,255);margin:0px;border:1px solid rgb(233,233,233)">
										   <tbody>
										      <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										         <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:20px">
										         	<?php if($vehicle_status=='Out'){ ?>
										         		<strong>Sensitive Vehicle Out Form <?php echo $parking_name; ?>!</strong>
										         	<?php } else { ?>
										         		<strong>Sensitive Vehicle Found in <?php echo $parking_name; ?>!</strong>
										         	<?php } ?>
										         	
										         	<br><br><br>
										            <strong>Vehicle Details :- </strong>
										            <br>Vehicle Number :-&nbsp; <?php echo $vehicle_number; ?>
										            <br>Mobile No :- <?php echo $mobile_number; ?>
										            <br>In Time :- <?php echo date('d/m/Y h:i A',$vehicle_in_date_time); ?>
										            <?php if($vehicle_status=='Out'){ ?> 
										           	<br>Out Time :- <?php echo date('d/m/Y h:i A',$vehicle_out_date_time); ?>
										            <?php } ?>
										            <br>Status :- <?php echo $vehicle_status; ?>		
										            <br><br><br>

										            <strong>Vendor Details :- </strong>
										            <br>Vendor Name :-&nbsp; <?php echo $vendor_name; ?>
										            <br>Vendor Mobile :-&nbsp; <?php echo $vendor_mobile; ?>
										            <br>Vendor Email :-&nbsp; <?php echo $vendor_email; ?>
										            <br>Vendor Address :-&nbsp; <?php echo $vendor_address; ?>
										            
										            <table width="100%" cellpadding="0" cellspacing="0" style="word-break:normal;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										               <tbody>
										                  <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										                     <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:0px 0px 20px">
										                        <div><br></div>
										                        <div>Thanks,<br></div>
										                        <div>Team VehiclePe - The Digital Parking<br></div>
										                     </td>
										                  </tr>
										               </tbody>
										            </table>
										         </td>
										      </tr>
										   </tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
		    		</td>
		    	</tr>
		    </table>
		</body>
		</html>
		<?php 
		$con->query("update `sensitive_vehicle` SET founded_vendor_id = ".$vendor_id.", find = '1' where id = ".$row_sensitive['id']."");
		$message = ob_get_contents();
		ob_end_clean();
                $to = "support@thedigitalparking.com";
		        $to = "manoj@snehlaxmi.com";
		        $subject = 'Sensitive Vechile Found';
                $datas['parameters']=array(array('name'=>'parking_name','value'=>$parking_name),array('name'=>'vehicle','value'=>$vehicle_number),array('name'=>'date','value'=>date('d/m/Y h:i A',$vehicle_in_date_time)),array('name'=>'status','value'=>$vehicle_status),array('name'=>'vendor_name','value'=>$vendor_name),array('name'=>'mobile','value'=>$vendor_mobile),array('name'=>'email','value'=>$vendor_email),array('name'=>'address','value'=>$vendor_address));
                $datas['template_name']='sensitive_vehicle';
                 $datas['broadcast_name']='sensitive vehicle';
                 whatsAppMessage('9694449191', $datas);
                 whatsAppMessage($row_sensitive['police_stations_mobile'], $datas);
		        SendEmailNotification($to,$subject,$message);
                 
	}
}

function GetMissingVehicleNumber($con,$vendor_id,$vehicle_number,$booking_id){
	$select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
	if($select_vehicle->num_rows > 1) {
		$select_vehicle_missing = $con->query("SELECT * FROM `vehicle_missing` Where vehicle_number='".$vehicle_number."'");
		if($select_vehicle_missing->num_rows == 0) {
			$insert_vehicle_missing = "INSERT INTO vehicle_missing(vehicle_number) VALUES('$vehicle_number')";
		} else {
			$insert_vehicle_missing = "update `vehicle_missing` SET vehicle_number = ".$vehicle_number." where vehicle_number = ".$vehicle_number."";
		}

		if ($con->query($insert_vehicle_missing) === TRUE) {

			$select_book_vehicle = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email as vendor_email, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as vendor_address FROM `vehicle_booking` as vb JOIN pa_users as v ON vb.vendor_id = v.id Where vb.id=".$booking_id." AND vb.vendor_id=".$vendor_id."");
			$row_book_vehicle = $select_book_vehicle->fetch_assoc();
			extract($row_book_vehicle);
			ob_start(); ?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			    <title>Missing Vehicle Number Notification</title>
			    <style type="text/css">
				    body {margin: 0; padding: 0; min-width: 100%!important;}
				    .content {width: 100%; max-width: 600px;}  
			    </style>
			</head>
			<body yahoo bgcolor="#f6f8f1">
				<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
			    	<tr>
			    		<td>
							<table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
								<tbody>
									<tr style="border-collapse:collapse"> 
										<td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;text-align: center;"><img src="http://thedigitalparking.com/digital-parking/administration/upload/logo.png"><br></td> 
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" style="word-break:normal;color:rgb(0,0,0);font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;text-decoration-style:initial;text-decoration-color:initial;box-sizing:border-box;border-radius:3px;background-color:rgb(255,255,255);margin:0px;border:1px solid rgb(233,233,233)">
											   <tbody>
											      <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
											         <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:20px">
											         	<strong>Missing Vehicle Found in <?php echo $parking_name; ?>!</strong>
											         	<br><br><br>
											            <strong>Vehicle Details :- </strong>
											            <br>Vehicle Number :-&nbsp; <?php echo $vehicle_number; ?>
											            <br>Mobile No :- <?php echo $mobile_number; ?>
											            <br>In Time :- <?php echo date('d/m/Y h:i A',$vehicle_in_date_time); ?>
											            <br>Status :- <?php echo $vehicle_status; ?>		
											            <br><br><br>
											            <strong>Vendor Details :- </strong>
											            <br>Vendor Name :-&nbsp; <?php echo $vendor_name; ?>
											            <br>Vendor Mobile :-&nbsp; <?php echo $vendor_mobile; ?>
											            <br>Vendor Email :-&nbsp; <?php echo $vendor_email; ?>
											            <br>Vendor Address :-&nbsp; <?php echo $vendor_address; ?>
											            <table width="100%" cellpadding="0" cellspacing="0" style="word-break:normal;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
											               <tbody>
											                  <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
											                     <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:0px 0px 20px">
											                        <div><br></div>
											                        <div>Thanks,<br></div>
											                        <div>Team The Digital Parking<br></div>
											                     </td>
											                  </tr>
											               </tbody>
											            </table>
											         </td>
											      </tr>
											   </tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
			    		</td>
			    	</tr>
			    </table>
			</body>
			</html>
			<?php 
			$message = ob_get_contents();
			ob_end_clean();
			$to = "arjuntvnews@gmail.com";
			$subject = $vehicle_number.' Missing Vechile Found';
			SendEmailNotification($to,$subject,$message);
		}
	}
}

function GenrateVechileQRcodes($con,$ref_id,$ref_type){
	$PNG_TEMP_DIR = '../customer/qrcodes/';
	if (!file_exists($PNG_TEMP_DIR)){
	   mkdir($PNG_TEMP_DIR,0777, true); 
	}
	$qr_code = substr( str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15 );
	$qrcode_file = $qr_code.'.png';

	$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where ref_id=".$ref_id." AND ref_type='".$ref_type."'"); 
	$numrows_qr = $select_qr->num_rows;
	if($numrows_qr==0){
		//include "../phpqrcode/qrlib.php";
		$errorCorrectionLevel = 'S';
		$matrixPointSize = 10;
		$qrcodeData = $qr_code;
		$qrcodeno = $qr_code.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
		$qrcodegenratedata = $qrcodeData.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
		QRcode::png($qrcodeData, $PNG_TEMP_DIR.$qrcode_file, $errorCorrectionLevel, $matrixPointSize, 2);
		$con->query("INSERT INTO vehicle_qr_codes(ref_id,ref_type,qr_code) VALUES('$ref_id','$ref_type','$qr_code')");
	} else {
		$qr_code_row = $select_qr->fetch_assoc();
		$qr_code = $qr_code_row['qr_code'];
	}
	return $qr_code; 
}

function GenrateVechileQRcodesNew($con,$qrid){
	$PNG_TEMP_DIR = CUSTOMER_TEMP_DIR;
	if (!file_exists($PNG_TEMP_DIR)){
	   mkdir($PNG_TEMP_DIR,0777, true); 
	}
	$qr_code = substr( str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15 );
	$qrcode_file = $qr_code.'.png';

	//include "../phpqrcode/qrlib.php";
	$errorCorrectionLevel = 'S';
	$matrixPointSize = 10;
	$qrcodeData = $qr_code;
	$qrcodeno = $qr_code.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
	$qrcodegenratedata = $qrcodeData.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
	QRcode::png($qrcodeData, $PNG_TEMP_DIR.$qrcode_file, $errorCorrectionLevel, $matrixPointSize, 2);
	$con->query("update `vehicle_qr_codes_new1` SET qr_code = '".$qr_code."' where id = ".$qrid);
	return $qr_code; 
}

function GenrateVechileNumberQRcodes($con,$vehicle_number,$ref_type){
	$PNG_TEMP_DIR = CUSTOMER_QR_DIR;
	if (!file_exists($PNG_TEMP_DIR)){
	   mkdir($PNG_TEMP_DIR,0777, true); 
	}
	$qr_code = substr( str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15 );
	$qrcode_file = $qr_code.'.png';

	$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where vehicle_number='".$vehicle_number."'"); 
	$numrows_qr = $select_qr->num_rows;
	if($numrows_qr==0){
		$errorCorrectionLevel = 'S';
		$matrixPointSize = 10;
		$qrcodeData = $qr_code;
		$qrcodeno = $qr_code.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
		$qrcodegenratedata = $qrcodeData.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
		QRcode::png($qrcodeData, $PNG_TEMP_DIR.$qrcode_file, $errorCorrectionLevel, $matrixPointSize, 2);
		$con->query("INSERT INTO vehicle_qr_codes(vehicle_number,ref_type,qr_code) VALUES('$vehicle_number','$ref_type','$qr_code')");
	} else {
		$qr_code_row = $select_qr->fetch_assoc();
		$qr_code = $qr_code_row['qr_code'];
	}
	return $qr_code; 
}


function getParkingCapacity($con,$vendor_id){
	$select_capacity = $con->query("SELECT parking_capacity, online_booking_capacity FROM `pa_users` Where id='".$vendor_id."' AND user_role='vandor'"); 
	$capacity_row = $select_capacity->fetch_assoc();
	$total_parking_capacity = $capacity_row['parking_capacity'];
	$total_online_capacity = $capacity_row['online_booking_capacity'];
	$total_offline_capacity = $total_parking_capacity - $total_online_capacity;
	$select_in_vehicle = $con->query("SELECT * FROM `vehicle_booking` where vendor_id = '".$vendor_id."' AND vehicle_status='In'");
	$total_in_vehicles = $select_in_vehicle->num_rows;
	$Total_offline_parking_remaining = $total_offline_capacity - $total_in_vehicles;
	$select_pre_book_vehicle = $con->query("SELECT * FROM `vehicle_pre_booking` where vendor_id = '".$vendor_id."' AND status='Booked'");
	$total_pre_book_vehicles = $select_pre_book_vehicle->num_rows;
	$Total_online_parking_remaining = $total_online_capacity - $total_pre_book_vehicles;
	$arrayCapacity = array('offline_capacity' => $Total_offline_parking_remaining, 'online_capacity' => $Total_online_parking_remaining);
	return $arrayCapacity; 
}

function OutPreBookingVechile($con,$vendor_id,$vehicle_number){
	$con->query("update `vehicle_pre_booking` SET status = 'Out' where vendor_id = ".$vendor_id." AND vehicle_number = ".$vehicle_number." AND status = 'In'");
}

function getgeoLocate($address) {
  try {
    $lat = 0;
    $lng = 0;
    $data_location = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyBQBtfnDTojmSNeI3kVXQVHAMIWNCwNuYI&address=".str_replace(" ", "+", $address)."&sensor=false";
    $data = file_get_contents($data_location);
    usleep(200000);
    $data = json_decode($data);
    if ($data->status=="OK") {
      $lat = $data->results[0]->geometry->location->lat;
      $lng = $data->results[0]->geometry->location->lng;
      if($lat && $lng) {
        return array(
          'status' => true,
          'lat' => $lat, 
          'long' => $lng, 
          'google_place_id' => $data->results[0]->place_id
        );
      }
    } else if($data->status == 'OVER_QUERY_LIMIT') {
      return array(
        'status' => false, 
        'message' => 'Google Amp API OVER_QUERY_LIMIT, Please update your google map api key or try tomorrow'
      );
    } else {
      return array(
        'status' => false, 
        'message' => $data->error_message
      );
    }
  } catch (Exception $e) {
    return array('lat' => null, 'long' => null, 'status' => false);
  }
}


function SendSMSNotification($mobileNumber, $message){
    
    /*echo "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121424&variables_values=".urlencode($message)."=&flash=0&numbers=".$mobileNumber;
    die("Hello");*/
  
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121424&variables_values=".urlencode($message)."=&flash=0&numbers=".$mobileNumber,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    return $response;
   /* if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }*/
}

function SendSMSNotificationotp($mobileNumber, $message){
    
    /*echo "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121424&variables_values=".urlencode($message)."=&flash=0&numbers=".$mobileNumber;
    die("Hello");*/
  
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121426&variables_values=".urlencode($message)."=&flash=0&numbers=".$mobileNumber,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    return $response;
   /* if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }*/
}


function SendSMSNotificationActive($mobileNumber, $message)
{
   
  $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_PORT => "8080",
    //CURLOPT_URL => "http://sms.thedigitalparking.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=0997587a2a679a8204fdca6c3435c0&message=".$message."&senderId=PREKIN&routeId=8&mobileNos=".$mobileNumber."&smsContentType=english",

   //https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121425&variables_values=&flash=0&numbers=
   


    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121428&variables_values=".urlencode($message)."&flash=0&numbers=".$mobileNumber,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  /*if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }*/

  return $response;
}



function SendSMSNotificationExpired($mobileNumber, $message)
{
   
  $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_PORT => "8080",
    //CURLOPT_URL => "http://sms.thedigitalparking.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=0997587a2a679a8204fdca6c3435c0&message=".$message."&senderId=PREKIN&routeId=8&mobileNos=".$mobileNumber."&smsContentType=english",

   //https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121425&variables_values=&flash=0&numbers=
   
   
    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=4bEMwD52ysRlSvPtW8X1zUKdJVN7IurmeFoaOkjcxT9AL0qQhflaq9Ef08WUCncQ7KOwTM1pb6HxPVsN&route=dlt&sender_id=PREKIN&message=121425&variables_values=".urlencode($message)."&flash=0&numbers=".$mobileNumber,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  /*if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }*/

  return $response;
}


function SendEmailNotification($to,$subject,$message){
	$to = $to;
	$subject = $subject;
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <support@thedigitalparking.com>' . "\r\n";
	mail($to,$subject,$message,$headers);
}
function sent_otp($con,$mobile_number) {
    $otplength = 6;
    $otpchars = "0123456789";
    $otp_code = substr( str_shuffle( $otpchars ), 0, $otplength );
    $sendmessage =$otp_code;
    $message = urlencode($sendmessage);
    SendSMSNotificationotp($mobile_number, $message);
    $con->query("update `pa_users` SET otp = '" . $otp_code . "' where mobile_number = '" . $mobile_number . "'");
    return $otp_code;
}
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return  md5($u_agent);
   
}
function check_vender_bowser($con,$vender){
    
    $bowser = getBrowser();
    $select_query = $con->query("SELECT * FROM `check_vender_login` where vender_id='".$vender."' AND bowser = '".$bowser."'");
     $numrows_qr = $select_query->num_rows;
    if ($numrows_qr >0) {
        return 2;
    }else{

        $con->query("Insert into `check_vender_login` SET bowser = '" . $bowser . "', vender_id = '" . $vender."'"); 
        return 1;
    }
}
function whatsAppMessage($mobile,$paramter){
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://live-server-748.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91".$mobile,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($paramter),
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJiYTA1NjdkOS05ZThmLTRmMGYtODA3Zi1mNTc3MTExYzhmNjciLCJ1bmlxdWVfbmFtZSI6ImFiaGF5c2luZ2g3Mjk1QGdtYWlsLmNvbSIsIm5hbWVpZCI6ImFiaGF5c2luZ2g3Mjk1QGdtYWlsLmNvbSIsImVtYWlsIjoiYWJoYXlzaW5naDcyOTVAZ21haWwuY29tIiwiYXV0aF90aW1lIjoiMDcvMTIvMjAyMSAwNTo0NzozMSIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6WyJURU1QTEFURV9NQU5BR0VSIiwiQlJPQURDQVNUX01BTkFHRVIiLCJERVZFTE9QRVIiXSwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.rqqt6Im9xPqHwO5XjxB9c0HbogWyF150Xc2x81tu5qs",
   "Content-Type: application/json-patch+json"  
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
}
}

/*function SendEmailNotification($to,$subject,$message){
	require 'emails/src/Exception.php';
	require 'emails/src/PHPMailer.php';
	require 'emails/src/SMTP.php';
	//$emailFrom = 'support@thedigitalparking.com';
	$emailFrom = 'support@thedigitalparking.com';
	$emailFromName = 'The Digital Parking';
	$emailToName = '';
	$emailTo = $to;
	//$emailTo = 'manoj@thedigitalparking.com';
	//$emailTo = 'manoj@snehlaxmi.com';

	$mail = new PHPMailer;
	$mail->isSMTP(); 
	$mail->SMTPDebug = 1; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
	//$mail->Host = "smtp.zoho.in"; // use $mail->Host = gethostbyname('smtp.zoho.in'); // if your network does not support SMTP over IPv6
	$mail->Host = "smtp.zoho.in"; // use $mail->Host = gethostbyname('smtp.zoho.in'); // if your network does not support SMTP over IPv6
	$mail->Port = 465; // TLS only
	$mail->SMTPSecure = 'tls'; // ssl is depracated
	$mail->SMTPAuth = true;
	$mail->Username = 'support@thedigitalparking.com';
	//$mail->Username = 'support@thedigitalparking.com';
	//$mail->Password = 'Manoj@tdp1990';
	$mail->Password = 'Manoj@tdp1990';
	$mail->setFrom($emailFrom, $emailFromName);
	$mail->addAddress($emailTo, $emailToName);
	$mail->Subject = $subject;
	$mail->msgHTML($message); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
	$mail->AltBody = 'HTML messaging not supported';
	// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
	$mail->send();
	if(!$mail->send()){
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    exit();
	}else{
	    echo "Message sent!";
	}
}

*/