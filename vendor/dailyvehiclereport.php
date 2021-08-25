<?php

namespace Dompdf;

include '../config.php';
// require_once '../dompdf/autoload.inc.php';
// $dompdf = new Dompdf();
//require_once 'alloverreportfunction.php';
if(isset($_GET['vendor_id'])){
    $select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state, v.profile_image,v.parking_name from pa_users as v where  v.user_status=1 and v.user_role='vandor' and id='".$_GET['vendor_id']."'");
}else{
$select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state, v.profile_image from pa_users as v where  v.user_status=1 and v.user_role='vandor'");
}
$array = array();
if ($select_query->num_rows > 0) {
    while ($row = $select_query->fetch_assoc()) {
        $currentdate = date('Y-m-d');      
        $start_date = date('Y-m-d',strtotime("-1 days")); //uncomment this for yesterday's date
         $end_date = $start_date;

        $vendor_id = $row['id'];
        ?>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title> www.vehiclepe.com</title>
            </head>
            <body style="margin: 0px; padding: 0px; background:url<?php echo ADMIN_URL; ?>assets/images/denim.png) repeat scroll 0 0;">

                <div style="width: 970px; margin: 0px auto;">
                    <div style="background: #fff; display: inline-block; width: 100%; padding:10px 0 60px;">

                        <div style="position: relative;">
                            <div style="position: relative;width: 100%; float: left;padding: 10px 0px;vertical-align: middle; ">
                                <div style="width: 33.3%; float: left; padding: 0px 15px; box-sizing: border-box; vertical-align: middle;">
                                    
                                    <!-- echo ADMIN_URL; ?>assets/images/img/logo.jpg -->
                                    <img src="<?php echo ADMIN_URL; ?>assets/images/img/logo.jpg" style="  display: block;
                                         margin: 0 auto;
                                         width: 120px; float: left; z-index: 20;vertical-align: middle;">

                                </div>
                                <div style="width: 33.3%; float: left; padding: 0px 15px; box-sizing: border-box;">
                                    <h1 style=" font-size: 26px;
                                        font-weight: bold;
                                        line-height: 30px; font-family: georgia, serif;text-align:center;margin:0px;padding: 0px; ">
                                        <span class="en" style="color:#16a004;">The Digital Parking</span><br>
                                        <span class="ar" style="color:#093502;"><?php echo $row['parking_name']; ?></span>

                                    </h1>
                                    <p style="font-family: georgia, serif; color: #333; font-weight: bold;font-size: 14px; text-align: center;margin:0px;padding:3px 0px;  "><?php echo $row['address']; ?> </p>
                                    <p style="font-family: georgia, serif; color: #333; font-weight: bold;font-size: 14px; text-align: center;margin:0px;padding:3px 0px;  "> From <?php echo $start_date ?> To <?php echo $end_date ?></p>
                                </div>
                                <div style="width: 33.3%; float: left; padding: 0px 15px; box-sizing: border-box;vertical-align: middle;">
                                    <?php
                                    if(!file_exists($row['profile_image']) || $row['profile_image'] ==''){
                                        $profile_image = 'https://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';   
                                    } else {
                                        $profile_image = $row['profile_image'];
                                    }
                                    ?>
                                    <img src="<?php echo $profile_image; ?>" style="  display: block;
                                         margin: 0 auto;
                                         width: 120px; float: right; z-index: 20;vertical-align: middle;">

                                </div>
                            </div>
                            <div style="width: 100%; float: left; padding: 0px 15px; box-sizing: border-box;">

                                <div style="border:2px dashed #093502; padding: 15px 0px 10px 0px; width: 100%; display: inline-block; box-sizing: border-box;">
                                    <div style="width: 33.33%; float: none; margin:0px auto;  padding: 0px 15px; box-sizing: border-box;">
                                        <div style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); display: inline-block; width: 100%; padding: 10px; border-radius: 0px 0px 4px 4px; text-align: center; background-image:url(<?php echo ADMIN_URL; ?>assets/images/worn_dots.png) no-repeat;">
                                            <h4 style="margin: 0px 0px 0px 0px; font-size: 18px; font-weight: bold; font-family: georgia, serif;">Daily Report</h4>
                                        </div>
                                    </div>
                                    <div style="width: 100%; float: left; padding: 0px 15px; box-sizing: border-box;">
                                        <div style="width:100%; float: left; box-sizing: border-box; padding: 0px 0px; text-align: center;">
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Vehicle Wise Report
                                            </h2>
                                        </div>
                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                            <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%; text-align: center;">
                                                <tr >                                                    
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">S.No.</th> 
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Vehicle Type</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Booking Type</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Total Vehicles</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">In</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Out</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Amount</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">GST (18%)</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Total Amount</th>
                                                </tr>
                                    <?php 
                                    $select_vehicle = $con->query("SELECT sum(case when vb.vehicle_status='In' then 1 else 0 end) as vin, sum(case when vb.vehicle_status='Out' then 1 else 0 end) as vout, count(vb.vehicle_type) as total_vehicles, vb.parking_type, vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$start_date."' GROUP BY booking_id) as ph ON ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$start_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$start_date."') GROUP BY vb.vehicle_type, vb.parking_type");
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

                                      $i = 1;
                                      $BookingAmount = 0;
                                      $BookingGSTAmount = 0;
                                      $TotalBookingAmount = 0;
                                      foreach($VehicleArray as $Vehicledata){ 
                                        $total_booking_amount = $Vehicledata['total_booking_amount'];
                                        $gstAmount = $total_booking_amount * 18 / 100;
                                        $booking_amount = $total_booking_amount - $gstAmount;

                                        ?>
                                        <tr>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $i; ?></td> 
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;">
                                            <?php if($Vehicledata['vehicle_type']=='2W'){
                                            echo '<img src="'.ADMIN_URL.'assets/images/img/bike.png" width="65px">';}
                                            elseif($Vehicledata['vehicle_type']=='4W'){echo '<img src="'.ADMIN_URL.'assets/images/img/car.png" width="65px">';}
                                            elseif($Vehicledata['vehicle_type']=='3W'){echo '<img src="'.ADMIN_URL.'assets/images/img/3W.png" width="65px">';}
                                            elseif(strtolower($Vehicledata['vehicle_type'])=='truck'){echo '<img src="'.ADMIN_URL.'assets/images/img/truck.png" width="65px">';}
                                            elseif(strtolower($Vehicledata['vehicle_type'])=='tractor'){echo '<img src="'.ADMIN_URL.'assets/images/img/tracktor.png" width="65px">';}
                                            elseif($Vehicledata['vehicle_type']=='STAFF'){echo '<img src="'.ADMIN_URL.'assets/images/img/staff.png" width="65px">';}
                                            elseif(strtolower($Vehicledata['vehicle_type'])=='bus'){echo '<img src="'.ADMIN_URL.'assets/images/img/bus.png" width="65px">';}
                                            else{
                                                echo $Vehicledata['vehicle_type'];
                                            }?>
                                        </td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $Vehicledata['booking_type']; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $Vehicledata['total_vehicles']; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $Vehicledata['total_in']; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $Vehicledata['total_out']; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($booking_amount,2); ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($gstAmount,2); ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($total_booking_amount,2); ?></td>
                                      </tr>
                                      <?php $i++; } ?>
                                      <tfoot>
                                        <?php $TotalBookingAmount = array_sum(array_column($VehicleArray, 'total_booking_amount'));
                                          $BookingGSTAmount = $TotalBookingAmount * 18 / 100;
                                          $BookingAmount = $TotalBookingAmount - $BookingGSTAmount;  ?>
                                        <tr>
                                          <td colspan="3" style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> Total Amount</td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo array_sum(array_column($VehicleArray, 'total_vehicles')); ?></td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo array_sum(array_column($VehicleArray, 'total_in')); ?></td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo array_sum(array_column($VehicleArray, 'total_out')); ?></td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo number_format($BookingAmount,2); ?></td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo number_format($BookingGSTAmount,2); ?></td>
                                          <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"> <?php echo number_format($TotalBookingAmount,2); ?></td>
                                        </tr>
                                      </tfoot><?php
                                                } else { ?>
                                                    <tr><td colspan="6" align="center">No Data Found</td></tr>
                                                <?php } ?>
                                            </table>
                                        </div>
<!-- for staff wise starts here -->
                                        <div style="width:100%; float: left; box-sizing: border-box; padding: 0px 0px; text-align: center;">
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Staff Wise Report
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                            <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                                                <tr >
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Sr. No.</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Staff Name</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Booking Type</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Vehicle Type</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Total Vehicle</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">In</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Out</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">In Amount</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Out Amount</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Final Amount</th>
                                                </tr>
                                                <?php
                                                $select_staff_vehicle = $con->query("SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout, count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type,vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$start_date."' GROUP BY booking_id, staff_id) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$start_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$start_date."') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id");
                                                #$select_staff_vehicle = $con->query($select_staff_vehicle);

                                                if ($select_staff_vehicle->num_rows > 0) {

                                                     $in = 1; 
                                                     $total_vehicles = 0;
                                                     $total_in_vehicles = 0;
                                                     $total_out_vehicles = 0;
                                                     $total_collect_amount = 0;
                                                     $total_final_amount = 0;
                                                     $total_advance_amount = 0;
                                                
                                                    while ($row_staff = $select_staff_vehicle->fetch_assoc()) {
                                                        ?>                                                    
                                                    <tr>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $in; ?></td> 
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $row_staff['staff_name']; ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $row_staff['parking_type']; ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;">
                                                            <?php if($row_staff['vehicle_type']=='2W'){
                                                                echo '<img src="'.ADMIN_URL.'assets/images/img/bike.png" width="65px">';}
                                                                elseif($row_staff['vehicle_type']=='4W'){echo '<img src="'.ADMIN_URL.'assets/images/img/car.png" width="65px">';}
                                                                elseif($row_staff['vehicle_type']=='3W'){echo '<img src="'.ADMIN_URL.'assets/images/img/3W.png" width="65px">';}
                                                                elseif(strtolower($row_staff['vehicle_type'])=='truck'){echo '<img src="'.ADMIN_URL.'assets/images/img/truck.png" width="65px">';}
                                                                elseif(strtolower($row_staff['vehicle_type'])=='tracktor'){echo '<img src="'.ADMIN_URL.'assets/images/img/tracktor.png" width="65px">';}
                                                                elseif($row_staff['vehicle_type']=='STAFF'){echo '<img src="'.ADMIN_URL.'assets/images/img/staff.png" width="65px">';}
                                                                elseif(strtolower($row_staff['vehicle_type'])=='bus'){echo '<img src="'.ADMIN_URL.'assets/images/img/bus.png" width="65px">';}
                                                                else{
                                                                    echo $row_staff['vehicle_type'];
                                                                }?>
                                                        </td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $row_staff['total_vehicles']; ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $row_staff['vin']; ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $row_staff['vout']; ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;">
                                                          <?php $select_staff_advance_amount = $con->query("SELECT SUM(ph.amount) as advance_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_in_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_in = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."'  AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$start_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                                          if ($select_staff_advance_amount->num_rows > 0) {
                                                            $row_staff_advance_amount = $select_staff_advance_amount->fetch_assoc();
                                                            $advance_amount = $row_staff_advance_amount['advance_amount'];
                                                          } else {
                                                            $advance_amount = 0;
                                                          }
                                                          echo number_format($advance_amount,2);
                                                          ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php
                                                        
                                                          $select_staff_out_amount = $con->query("SELECT SUM(ph.amount) as out_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_out_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_in = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."' AND(FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                                          if ($select_staff_out_amount->num_rows > 0) {
                                                            $row_staff_out_amount = $select_staff_out_amount->fetch_assoc();
                                                            $out_amount = $row_staff_out_amount['out_amount'];
                                                          } else {
                                                            $out_amount = 0;
                                                          }
                                                         echo number_format($out_amount,2); ?></td>
                                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($row_staff['total_booking_amount'],2); ?></td>
                                                      </tr>
                                      <?php $total_vehicles = $total_vehicles + $row_staff['total_vehicles'];
                                      $total_in_vehicles = $total_in_vehicles + $row_staff['vin'];
                                      $total_out_vehicles = $total_out_vehicles + $row_staff['vout'];
                                      $total_collect_amount = $total_collect_amount + $out_amount;
                                      $total_final_amount = $total_final_amount + $row_staff['total_booking_amount'];

                                      $total_advance_amount = $total_advance_amount + $advance_amount;

                                       $in++; }  ?> 
                                      <tfoot>
                                        <tr>
                                        <td colspan="4" style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;">Total Payment</td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $total_vehicles; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $total_in_vehicles; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo $total_out_vehicles; ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($total_advance_amount,2); ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($total_collect_amount,2); ?></td>
                                        <td style="border:1px solid #093502; font-family: georgia, serif; padding: 10px;"><?php echo number_format($total_final_amount,2); ?></td>
                                        </tr>
                                      </tfoot>
                                     <?php  } else { ?>
                                      <tr>
                                        <td colspan="9" align="center"> No Recods Found this Date please select another Start and End Date</td>
                                      </tr>
                                    <?php } ?>
                                            </table>
                                        </div>

                                        <div style="width:100%; float: left; box-sizing: border-box; padding: 0px 0px; text-align: center;">
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Vehicle Pass
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                            <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                                                <tr >
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">S.No.</th>
                                  
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Vehicle Type</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Customer Name</th> 
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Company</th>    
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Start/End Date</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Issuing Date</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Grace Date</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Amount</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Payment Type</th>
                                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Status</th>
                                                </tr>

                                                 <?php
                                                 $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$vendor_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$start_date."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$start_date."') ORDER BY id DESC");
                                                if ($select_query->num_rows > 0) {
                                                $i = 1;
                                                $total_amount = 0;
                                                    while ($row = $select_query->fetch_assoc()) {
                                                        
                                                $start_date = '';
                                                    $end_date = '';
                                                    if($row['start_date']){
                                                       //$explode_start_date = explode('-',$row['start_date']);
                                                      // $start_date = $explode_start_date[2].'-'.$explode_start_date[1].'-'.$explode_start_date[0];
                                                       $s_date = date('d-m-Y', strtotime($row['start_date']));
                                                    }
                                                    if($row['end_date']){
                                                       //$explode_end_date = explode('-',$row['end_date']);
                                                       //$end_date = $explode_end_date[2].'-'.$explode_end_date[1].'-'.$explode_end_date[0];
                                                       $e_date = date('d-m-Y', strtotime($row['end_date']));
                                                    }


                                                    $select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where ref_id=".$row['id']." AND ref_type='monthly_pass'");
                                                    $qr_code_row = $select_qr->fetch_assoc();
                                                    $qr_code = $qr_code_row['qr_code'].'.png';

                                                    ?>
                                                    <tr>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $i; ?></td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">
                                                          <?php if($row['vehicle_type']=='2W'){
                                                                echo '<img src="'.ADMIN_URL.'assets/images/img/bike.png" width="65px">';}
                                                                elseif($row['vehicle_type']=='4W'){echo '<img src="'.ADMIN_URL.'assets/images/img/car.png" width="65px">';}
                                                                elseif($row['vehicle_type']=='3W'){echo '<img src="'.ADMIN_URL.'assets/images/img/3W.png" width="65px">';}
                                                                elseif(strtolower($row['vehicle_type'])=='truck'){echo '<img src="'.ADMIN_URL.'assets/images/img/truck.png" width="65px">';}
                                                                elseif(strtolower($row['vehicle_type'])=='tracktor'){echo '<img src="'.ADMIN_URL.'assets/images/img/tracktor.png" width="65px">';}
                                                                elseif($row['vehicle_type']=='STAFF'){echo '<img src="'.ADMIN_URL.'assets/images/img/staff.png" width="65px">';}
                                                                elseif(strtolower($row['vehicle_type'])=='bus'){echo '<img src="'.ADMIN_URL.'assets/images/img/bus.png" width="65px">';}
                                                                else{
                                                                    echo $row['vehicle_type'];
                                                                }?>
                                                      </td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['company_name']; ?></td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo 'Start : '.$s_date.'<br/> To : '.$e_date; ?></td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo date('d-m-Y',$row['pass_issued_date']); ?></td>
                                                       <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php  echo $row['grace_date']; ?></td>
                                                      
                                                       <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['amount']; ?></td>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['payment_type']; ?></td>
                                                      <?php
                                                       $today=date("Y-m-d");
                                                         $curdate=strtotime($today);
                                                          $edate=strtotime($e_date);
                                                        ?>
                                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php  if($row['status']==1 || $edate>$curdate){ echo 'Active'; } else if($row['status']==2){ echo 'Applied'; } else if($row['status']==4){ echo 'Grace'; } else {  echo 'Expire'; } ?></td>
                                                      
                                                    </tr>
                                                  <?php $total_amount = $total_amount + $row['amount'];
                                                  $i++; } ?>
                                                </tbody>

                                                <tfoot>
                                                  <tr>
                                                    <th colspan="7" style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> Total Amount</th>
                                                    <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><i class="fas fa-rupee-sign"></i> <?php echo $total_amount; ?></th>
                                                    <th colspan="8" style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"></th>
                                                    
                                                  </tr>
                                                </tfoot>
                                               <?php } else { ?> 
                                                    <tr><td colspan="6" align="center">No Data Found</td></tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div style="width: 33.3%; float: left; padding: 0px 0px; box-sizing: border-box; margin-top: 20px;">
                                    <h4 style="font-family: georgia, serif; font-size: 10px; display: block;"><span style="float: left;">The Digital Parking Support <br> Tel: +91 74109-06906 - Email: admin@cbskuwait.com </span></h4>
                                    <h4 style="font-family: georgia, serif; font-size: 10px;"><span style="float: left;">                           </span> </h4>
                                </div> 
                                <div style="width: 46.3%; float: left; text-align: center; padding: 0px 0px; box-sizing: border-box; margin-top: 20px;">
                                    <h4 style="font-family: georgia, serif; font-size: 10px; display: block;"><span style="float: left; text-align: center;">This is a computer generated slip and does not require signature.</span></h4>
                                    <h4 style="font-family: georgia, serif; font-size: 10px;"><span style="float: left;">                           </span> </h4>
                                </div> 
                                <div style="width: 20.3%; float: right; text-align: right; padding: 0px 0px; box-sizing: border-box;">
                                    <a href="#" style="background: hsl(112deg 93% 11%) none repeat scroll 0 0; color: #fff; padding: 10px; text-align: center; text-decoration: none; margin-top: 20px; display: inline-block;"> www.vehiclepe.com </a>
                                </div>
                                <?php if(isset($_GET['vendor_id'])){ ?>
                                <div class="d-print-none mo-mt-4">
                                                <div class="float-right">
                                                
                                                    <a href="javascript:;" onClick="window.print()" style="background: hsl(112deg 93% 11%) none repeat scroll 0 0; color: #fff; padding: 10px; text-align: center; text-decoration: none; margin-top: 20px; display: inline-block;">Print</a>
                                                </div>
                            </div>
                                <?php } ?>
                        </div>
                        </body>
                        </html>

                        <?php
                    }
                }


//
//                $dompdf->loadHtml($html);
//                $dompdf->render();
//                $dompdf->stream("", array("Attachment" => false));
//                $dompdf->stream("sample.pdf");
                ?>