<?php include '../../config.php'; 

include '../../administration/functions.php';

$activate_subscriptions_plans = $con->query("select vs.vendor_id, v.user_email, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as vendor_address from `vendor_subscriptions` as vs JOIN pa_users as v on vs.vendor_id = v.id where vs.status = 1 AND vs.daily_report = 1 AND v.user_role = 'vandor'");

while($active_plans_row=$activate_subscriptions_plans->fetch_assoc())
{
	$vendor_id = $active_plans_row['vendor_id'];
	$vendor_name = $active_plans_row['vendor_name'];
	$vendor_email = $active_plans_row['user_email'];
	$parking_name = $active_plans_row['parking_name'];
	$vendor_address = $active_plans_row['vendor_address'];

	//$start_date = '2020-07-01';
	//$start_date = date('Y-m-d');
	$start_date =  date('Y-m-d',strtotime("-1 days"));
	$end_date = date('Y-m-d',strtotime("-1 days"));

	$select_vehicle = $con->query("SELECT sum(case when vb.vehicle_status='In' then 1 else 0 end) as vin, sum(case when vb.vehicle_status='Out' then 1 else 0 end) as vout, count(vb.vehicle_type) as total_vehicles, vb.parking_type, vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id) as ph ON ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY vb.vehicle_type, vb.parking_type");
	$VehicleArray = array();
	$numrows_vehicle = $select_vehicle->num_rows;
	$finalArray = array();
	if ($numrows_vehicle > 0) {
		while($row=$select_vehicle->fetch_assoc())
		{
			$total_vehicles_in = $row['vin'];
			$total_vehicles_out = $row['vout'];
			$total_vehicles = $row['total_vehicles'];
			$vehicle_type = $row['vehicle_type'];
			$total_booking_amount = $row['total_booking_amount'];
			$parking_type = $row['parking_type'];
			$array = array();
			$array['vehicle_type'] = $vehicle_type;
			$array['booking_type'] = $parking_type;
			$array['total_in'] = $total_vehicles_in;
			$array['total_out'] = $total_vehicles_out;
			$array['total_vehicles'] = $total_vehicles;
			$array['total_booking_amount'] = $total_booking_amount;
			$VehicleArray[] = $array;
		}

	ob_start();

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <title>A Simple Responsive HTML Email</title>
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
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;width:280.677px" colspan="2">TDP Logo <img src="http://thedigitalparking.com/digital-parking/administration/upload/logo.png"><br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;width:161.51px;font-weight:bold" colspan="6">The Digital Parking Daily Report<br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;width:18.1771px" colspan="2">Client Logo<br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="10">&nbsp;<br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;font-weight:bold" colspan="10"><?php echo $parking_name; ?><br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="10"><?php echo $vendor_address; ?><br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="10">&nbsp;<br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="10">Date Range<br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="3">&nbsp;<br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;font-weight:bold">From<br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px"><?php echo $start_date; ?><br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;font-weight:bold">To<br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px"><?php echo $end_date; ?><br></td>
					         <td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px" colspan="3">&nbsp;<br></td>
					      </tr>
					      <tr style="border-collapse:collapse">
					         <td style="border-collapse:collapse;border:1px solid lightgrey" colspan="10">
					            <div>
					               <div>Payment Summary Report:-&nbsp;<br></div>
					            </div>
					            &nbsp;<br>
					         </td>
					      </tr>
					   </tbody>
					</table>
		    		</td>
		    	</tr>
		        <tr>
		            <td>
		            	<br/><br/>
		                <table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">

	                    <?php if($VehicleArray) { ?>
		                    <tr>
		                        <td>
		                          <strong>Dear Sir, Please find the below URL Link. Your today Parking Report is ready please see in blow :</strong>  <br/><br/>	
		                        </td>
		                    </tr>

		                    <tr>
		                        <td>
									<table width="100%" border="1">
										<thead>
											<tr>
												<th>S.No.</th> 
												<th>Vehicle Type</th>
												<th>Booking Type</th>
												<th>Total Vehicles</th>
												<th>In</th>
												<th>Out</th>
												<th>Amount</th>
												<th>GST (18%)</th>
												<th>Total Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1;
											$BookingAmount = 0;
											$BookingGSTAmount = 0;
											$TotalBookingAmount = 0;
											foreach($VehicleArray as $Vehicledata){ 
												$total_booking_amount = $Vehicledata['total_booking_amount'];
												//$gstAmount = $total_booking_amount * 18 / 100;
												//$booking_amount = $total_booking_amount - $gstAmount;
												$booking_amount = $total_booking_amount * 100 / 118;
												$gstAmount = $total_booking_amount - $booking_amount;

												?>
											<tr>
												<td><?php echo $i; ?></td> 
												<td><?php echo $Vehicledata['vehicle_type']; ?></td>
												<td><?php echo $Vehicledata['booking_type']; ?></td>
												<td><?php echo $Vehicledata['total_vehicles']; ?></td>
												<td><?php echo $Vehicledata['total_in']; ?></td>
												<td><?php echo $Vehicledata['total_out']; ?></td>
												<td><?php echo number_format($booking_amount,2); ?></td>
												<td><?php echo number_format($gstAmount,2); ?></td>
												<td><?php echo number_format($total_booking_amount,2); ?></td>
											</tr>
											<?php $i++; } ?>
											<tfoot>
												<?php $TotalBookingAmount = array_sum(array_column($VehicleArray, 'total_booking_amount'));
													//$BookingGSTAmount = $TotalBookingAmount * 18 / 100;
													//$BookingAmount = $TotalBookingAmount - $BookingGSTAmount;

													$BookingAmount = $TotalBookingAmount * 100 / 118;
													$BookingGSTAmount = $TotalBookingAmount  - $BookingAmount;

													?>
												<tr>
													<td colspan="3"> Total Amount Received</td>
													<td> <?php echo array_sum(array_column($VehicleArray, 'total_vehicles')); ?></td>
													<td> <?php echo array_sum(array_column($VehicleArray, 'total_in')); ?></td>
													<td> <?php echo array_sum(array_column($VehicleArray, 'total_out')); ?></td>
													<td> <?php echo number_format($BookingAmount,2); ?></td>
													<td> <?php echo number_format($BookingGSTAmount,2); ?></td>
													<td> <?php echo number_format($TotalBookingAmount,2); ?></td>
												</tr>
											</tfoot>
										</tbody>
									</table>
	                        	</td>	
                    		</tr>
		                 <?php } else { ?>
		                	<tr>
		                        <td>
		                           Today No Vechile In and Out in your parking 
		                        </td>
		                    </tr>
		                <?php } ?>

		                </table>
		            </td>
		        </tr>
		   
		   	<?php /*  ?>
		        <tr>
		        	<td>
		        	 <br/><br/>
		        		<table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
		        			<tr>
		                        <td>
		                        	<?php 

		                        	$select_staff_vehicle = $con->query("SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout, count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id, staff_id) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND ph.staff_id IS NOT NULL GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id");

		                        	if ($select_staff_vehicle > 0) { ?>
			                    		<tr>
					                        <td>
					                            
					                        </td>
					                    </tr>

					                    <tr>
					                        <td>
												<table width="100%" border="1">
													<thead>
														<tr>
															<th>S.No.</th> 
															<th>Staff Name</th>
															<th>Booking Type</th>
															<th>Total Vehicle</th>
															<th>In</th>
															<th>Out</th>
															<th>Advance Amount</th>
															<th>Collection Amount</th>
															<th>Final Amount</th>
														</tr>
													</thead>
													<tbody>
														<?php $in = 1; 
														while($row_staff=$select_staff_vehicle->fetch_assoc())
														{ ?>
														<tr>
															<td><?php echo $in; ?></td> 
															<td><?php echo $row_staff['staff_name']; ?></td>
															<td><?php echo $row_staff['parking_type']; ?></td>
															<td><?php echo $row_staff['total_vehicles']; ?></td>
															<td><?php echo $row_staff['vin']; ?></td>
															<td><?php echo $row_staff['vout']; ?></td>
															<td>0.00</td>
															<td><?php echo number_format($row_staff['total_booking_amount'],2); ?></td>
															<td><?php echo number_format($row_staff['total_booking_amount'],2); ?></td>
														</tr>
														<?php $in++; }  ?>
							                        </tbody>
												</table>
					                        </td>
			                    		</tr>
			                    	<?php } ?>
	                        	</td>
		                    </tr>
		        		</table>
		        		<?php ?>
		        	</td>
		        </tr>
		        <?php */ ?>
		    </table>
		</body>
	</html>

	<?php $message = ob_get_contents();
		ob_end_clean();
		$to = $vendor_email;
		$subject = $start_date.' Parking Report';
		#SendEmailNotification($to,$subject,$message);
	}
}


// for daily report
$query=$con->query('SELECT DISTINCT(vendor_id) FROM vendor_subscriptions WHERE subscription_plan_id=4');
$currentdate = date('Y-m-d');      
$start_date = date('Y-m-d',strtotime("-1 days")); //uncomment this for yesterday's date
#$start_date = '2021-03-02';
if ($query->num_rows>0) {
	while ($result=$query->fetch_assoc()) {
		$select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state,v.parking_name from pa_users as v where  v.user_status=1 and v.user_role='vandor' and id='".$result['vendor_id']."'");
		if ($select_query->num_rows > 0) {
			while ($row = $select_query->fetch_assoc()) {
                $mobile_number=$row['vendor_mobile'];
                $address=$row['address'];
                $name=$row['parking_name'];
            }
			$a = "SELECT  count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount,ph.payment_type,vb.vehicle_type FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount,payment_type from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') = '" . $start_date . "'  GROUP BY booking_id, staff_id,payment_type) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=" . $result['vendor_id'] . " AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') = '" . $start_date . "'  OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') = '" . $start_date . "') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id";
            $select_vehicle = $con->query($a);
            $numrows_vehicle = $select_vehicle->num_rows;
            
            $b = "SELECT  count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount,ph.payment_type,vb.vehicle_type FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount,payment_type from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') = '" . $start_date . "' GROUP BY booking_id, staff_id,payment_type) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=" . $result['vendor_id'] . " AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') = '" . $start_date . "'  OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') = '" . $start_date . "') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id";
            $select_staff_vehicle = $con->query($b);

            if ($select_staff_vehicle->num_rows < 0) {
                        
            	$b = "SELECT  count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount,ph.payment_type,vb.vehicle_type FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount,payment_type from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') = '" . $start_date . "' GROUP BY booking_id, staff_id,payment_type) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=" . $result['vendor_id'] . " AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') = '" . $start_date . "' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') = '" . $start_date . "') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id";
                $select_staff_vehicle = $con->query($b);
            }
            if ($numrows_vehicle > 0 || $select_staff_vehicle->num_rows > 0){
            	$today = date("d/m/Y h:i A", strtotime($start_date));
            	echo '<a href="'.SITE_URL.'vendor/dailyvehiclereport.php?vendor_id='.$result['vendor_id'].'" target="blank">'.SITE_URL.'vendor/dailyvehiclereport.php?vendor_id='.$result['vendor_id'].'</a>'.'||'.$today.'<br>';

            	$link=SITE_URL.'/vendor/dailyvehiclereport.php?vendor_id='.$result['vendor_id'];            	$datas['parameters']=array(array('name'=>'parking_name','value'=>$name),array('name'=>'address','value'=>$address),array('name'=>'date','value'=>$today),array('name'=>'date','value'=>$today),array('name'=>'invoice_url','value'=>' '.$link));
                $datas['template_name']='parking_report';
                 $datas['broadcast_name']='parking report';
                 #whatsAppMessage($mobile_number, $datas);
                 whatsAppMessage('9993927805', $datas);
                 whatsAppMessage('9694449191', $datas);                 
            }
		}
	}
}