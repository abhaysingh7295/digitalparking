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

                                    <div style="width: 100%; float: left; padding: 0px 15px; box-sizing: border-box;">
                                      
                                      
<!-- for staff wise starts here -->
                                        <div style="width:100%; float: left; box-sizing: border-box; padding: 0px 0px; text-align: center;">
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Vehicle Type Wise Report
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                                   <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                                <thead>
                                <tr>
                                <tr>
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
                                </tr>
                                </thead>
                                <tbody>
                                   <?php 
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
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $i; ?></td> 
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $Vehicledata['vehicle_type']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $Vehicledata['booking_type']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $Vehicledata['total_vehicles']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $Vehicledata['total_in']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $Vehicledata['total_out']; ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($booking_amount,2); ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($gstAmount,2); ?></td>
                                        <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo number_format($total_booking_amount,2); ?></td>
                                      </tr>
                                      <?php $i++; } ?>
                                      <tfoot>
                                        <?php $TotalBookingAmount = array_sum(array_column($VehicleArray, 'total_booking_amount'));
                                          $BookingGSTAmount = $TotalBookingAmount * 18 / 100;
                                          $BookingAmount = $TotalBookingAmount - $BookingGSTAmount;  ?>
                                        <tr>
                                          <td colspan="3" style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> Total Amount Received</td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo array_sum(array_column($VehicleArray, 'total_vehicles')); ?></td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo array_sum(array_column($VehicleArray, 'total_in')); ?></td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo array_sum(array_column($VehicleArray, 'total_out')); ?></td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo number_format($BookingAmount,2); ?></td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo number_format($BookingGSTAmount,2); ?></td>
                                          <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"> <?php echo number_format($TotalBookingAmount,2); ?></td>
                                        </tr >
                                      </tfoot>
                                     <?php  } ?>
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

