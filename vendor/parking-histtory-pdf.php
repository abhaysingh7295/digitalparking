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
        $user_id = $row['id'];
        
        $query_string = "";
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    
    $getstart = $_GET['startDate'];
    $getend = $_GET['endDate'];
  
   echo $vs = "SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '" . $getend . "' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '" . $getend . "') AND b.vendor_id = '" . $user_id . "' ORDER BY b.serial_number DESC"; die;

    $vehicle_book_query = $con->query($vs);
 
} else if ($_GET['vehicle_number']) {
    $vehicle_number = $_GET['vehicle_number'];
    $query_string = "&vehicle_number=$vehicle_number";
    $vs = "SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as vendor_name, u.user_email, u.mobile_number as vendor_mobile, u.address, u.city, u.state, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where b.vendor_id = '" . $user_id . "' AND b.vehicle_number LIKE '%" . $vehicle_number . "%' ORDER BY b.serial_number DESC";
    $vehicle_book_query = $con->query($vs);
} else {
    if ($active_plans_row['report_export_capacity'] > 0) {
        $getstart = date('Y-m-d', strtotime('-' . $active_plans_row['report_export_capacity'] . ' months'));
        $getend = $currentdate;
    } else {
        $getstart = $currentdate;
        $getend = $currentdate;
    }
    $query_string = "&start_date=$getstart&end_date=$getend";
    $vs = "SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where FROM_UNIXTIME(`vehicle_in_date_time`, '%Y-%m-%d') = (DATE_FORMAT(NOW(),'%Y-%m-%d')) AND b.vendor_id = '" . $user_id . "' ORDER BY b.serial_number DESC";

    $vehicle_book_query = $con->query($vs);
    $vendor_details = $con->query("SELECT CONCAT_WS(' ', u.first_name,u.last_name) as vendor_name, u.user_email, u.mobile_number as vendor_mobile, u.address, u.city, u.state from pa_users as u where u.id = '" . $user_id . "'");
}
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
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Parking History
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                              <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                            <thead>
                                <tr>
                                    <th class="t1">S.No.</th>
                                    <th style="display: none;">ID</th>
                                    <th class="t1">Booking ID</th>
                                    <th class="t1">Vehicle Number</th>
                                    <th class="t1">Customer</th> 
                                    <th class="t1">In</th>
                                    <th class="t1">Out</th>
                                    <th class="t1">Duration</th>
                                    <th class="t1">Amount</th>
                                    <th class="t1">Staffs</th>
                                    <th class="t1">Book Type</th>
                                    <th class="t1">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								echo "<pre>";print_r($row = $vehicle_book_query->fetch_assoc());
                                $i = 1;
                                $total_vendor_amount = 0;
                                if ($vehicle_book_query->num_rows > 0) {
                                    while ($row = $vehicle_book_query->fetch_assoc()) {
                                        $id = $row['id'];
                                        $vehicle_status = $row['vehicle_status'];
                                        ?>
                                        <tr class="gradeX">
                                            <td><?php echo $row['serial_number']; ?></td>
                                            <td style="display: none;"><?php echo $id; ?></td>
                                            <td><?php echo $id; ?></td>
                                            <td><?php
                                                echo $row['vehicle_number'] . '<br/> (' . $row['vehicle_type'] . ')';
                                                if ($row['staff_vehicle_type'] == 'yes') {
                                                    echo ' (Staff)';
                                                }
                                                ?></td>
                                            <td><?php echo $row['first_name'] . '<br>' . $row['mobile_number']; ?></td>

                                            <td><?php echo date('d-m-Y', $row['vehicle_in_date_time']) . ' <br/>' . date('h:i A', $row['vehicle_in_date_time']); ?></td>
                                            <td><?php echo date('d-m-Y', $row['vehicle_out_date_time']) . ' <br/>' . date('h:i A', $row['vehicle_out_date_time']); ?></td>
                                            <td><?php
                                                if ($vehicle_status == 'In') {
                                                    $currentTime = time();
                                                    $diff = abs($currentTime - $row['vehicle_in_date_time']);
                                                } else {
                                                    $diff = abs($row['vehicle_out_date_time'] - $row['vehicle_in_date_time']);
                                                }

                                                $fullDays = floor($diff / (60 * 60 * 24));
                                                $fullHours = floor(($diff - ($fullDays * 60 * 60 * 24)) / (60 * 60));
                                                $fullMinutes = floor(($diff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60)) / 60);
                                                $totalDuration = '';
                                                if ($fullDays > 0) {
                                                    $totalDuration .= $fullDays . ' Day ';
                                                }
                                                if ($fullHours > 0) {
                                                    $totalDuration .= $fullHours . ' Hrs ';
                                                }
                                                //if($fullMinutes > 0){
                                                $totalDuration .= $fullMinutes . ' Mins';
                                                //}

                                                echo $totalDuration;
                                                ?></td>
                                            <td><?php
                                                $vehicle_book_payment = $con->query("SELECT IF(SUM(amount) > 0, SUM(amount), 0) as total_amount FROM `payment_history` where booking_id = '" . $id . "'");
                                                $row_payment = $vehicle_book_payment->fetch_assoc();
                                                $total_amount = $row_payment['total_amount'];
                                                echo $total_amount;
                                                $total_vendor_amount = $total_amount + $total_vendor_amount;
                                                ?></td>
                                            <td><?php
                                                if ($row['in_staff_name']) {
                                                    echo '<strong>In : </strong>' . $row['in_staff_name'] . '<br/>';
                                                } if ($row['out_staff_name']) {
                                                    echo '<strong>Out : </strong>' . $row['out_staff_name'];
                                                }
                                                ?></td>
                                            <td><?php
                                                echo $row['parking_type'];
                                                if ($row['qr_type'] == 'monthly_pass') {
                                                    echo '<br/> (Pass)';
                                                }
                                                ?></td>
                                            <td><?php echo $row['vehicle_status']; ?></td>
                                            <td><a href="payment-history.php?id=<?php echo $row['id']; ?>" title="View Payment History"> <i class="fas fa-history"></i> </a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total Amount </td>
                                    <td><i class="fas fa-rupee-sign"></i> <?php echo $total_vendor_amount; ?></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
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