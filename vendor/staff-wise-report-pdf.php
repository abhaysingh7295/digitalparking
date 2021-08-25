<?php
include '../config.php';
if(isset($_GET['vendor_id'])){
    $select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state, v.profile_image,v.parking_name from pa_users as v where  v.user_status=1 and v.user_role='vandor' and id='".$_GET['vendor_id']."'");
}else{
$select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state, v.profile_image from pa_users as v where  v.user_status=1 and v.user_role='vandor'");
}
$array = array();
if ($select_query->num_rows > 0) {
    while ($row = $select_query->fetch_assoc()) {
        
        $currentdate = date('Y-m-d');      
        $start_date = $_GET['startDate']; //uncomment this for yesterday's date
        $end_date = $_GET['endDate'];

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
<!--                                    <div style="width: 33.33%; float: none; margin:0px auto;  padding: 0px 15px; box-sizing: border-box;">
                                        <div style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); display: inline-block; width: 100%; padding: 10px; border-radius: 0px 0px 4px 4px; text-align: center; background-image:url(<?php echo ADMIN_URL; ?>assets/images/worn_dots.png) no-repeat;">
                                            <h4 style="margin: 0px 0px 0px 0px; font-size: 18px; font-weight: bold; font-family: georgia, serif;">Daily Report</h4>
                                        </div>
                                    </div>-->
                                    <div style="width: 100%; float: left; padding: 0px 15px; box-sizing: border-box;">
                                      
                                      
<!-- for staff wise starts here -->
                                        <div style="width:100%; float: left; box-sizing: border-box; padding: 0px 0px; text-align: center;">
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Staff Wise Report
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                              <table id="datatable" style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                                <thead>
                                <tr>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">S.No.</th> 
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Staff Name</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Booking Type</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Total Vehicle</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">In</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Out</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">In Amount</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Out Amount</th>
                              <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Final Amount</th>
                               </tr>
                                </thead>
                                <tbody>
                                   <?php

                                   $select_staff_vehicle = $con->query("SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout, count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id, staff_id) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id");
                                      
                                     if ($select_staff_vehicle->num_rows > 0) {
                                         
                                     $in = 1; 
                                     $total_vehicles = 0;
                                     $total_in_vehicles = 0;
                                     $total_out_vehicles = 0;
                                     $total_collect_amount = 0;
                                     $total_final_amount = 0;
                                     $total_advance_amount = 0;
                                      while($row_staff=$select_staff_vehicle->fetch_assoc())
                                      { ?>
                                      <tr>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $in; ?></td> 
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row_staff['staff_name']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row_staff['parking_type']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row_staff['total_vehicles']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row_staff['vin']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row_staff['vout']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">
                                          <?php $select_staff_advance_amount = $con->query("SELECT SUM(ph.amount) as advance_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_in_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_in = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."'  AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                          if ($select_staff_advance_amount->num_rows > 0) {
                                            $row_staff_advance_amount = $select_staff_advance_amount->fetch_assoc();
                                            $advance_amount = $row_staff_advance_amount['advance_amount'];
                                          } else {
                                            $advance_amount = 0;
                                          }

                                          echo number_format($advance_amount,2);
                                          ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php  

                                          $select_staff_out_amount = $con->query("SELECT SUM(ph.amount) as out_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_out_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_out = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."' AND(FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                          if ($select_staff_out_amount->num_rows > 0) {
                                            $row_staff_out_amount = $select_staff_out_amount->fetch_assoc();
                                            $out_amount = $row_staff_out_amount['out_amount'];
                                          } else {
                                            $out_amount = 0;
                                          }

                                         echo number_format($out_amount,2); ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($row_staff['total_booking_amount'],2); ?></td>
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
                                        <td colspan="3" tyle="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Total Payment</td>
                                        <td tyle="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $total_vehicles; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $total_in_vehicles; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $total_out_vehicles; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($total_advance_amount,2); ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($total_collect_amount,2); ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($total_final_amount,2); ?></td>
                                        </tr>
                                      </tfoot>
                                     <?php  } else { ?>
                                      <tr>
                                        <td colspan="9" align="center"> No Recods Found this Date please select another Start and End Date</td>
                                      </tr>
                                    <?php } ?>
                                </tbody>
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
                               
                        </div>
                        </body>
                        </html>

                        <?php
                    }
                }

                ?>