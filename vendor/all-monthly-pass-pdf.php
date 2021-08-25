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
                                            <h2 style="background-color:hsl(113deg 95% 32%); color: #FFF;border:1px solid hsl(112deg 93% 11%); width: 100%; padding: 10px 0px; font-family: georgia, serif; font-size:18px; ">Monthly Pass Report
                                            </h2>
                                        </div>

                                        <div  style="border:1px solid #093502; width: 100%; display: inline-block;">
                                                   <table style="border:1px solid #093502;  border-collapse: collapse; width: 100%;text-align: center;">
                                <thead>
                                <tr>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">S.No.</th>
                                  
                                  
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Vehicle No</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Customer Name</th> 
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Company</th>    
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Start / End Date</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Issuing Date</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Grace Date</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Amount</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Payment Type</th>
                                  <th style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;">Status</th>
                                
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$vendor_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$end_date."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$end_date."') ORDER BY id DESC");
                                  $i = 1;
                                  $total_amount = 0;
                                  while($row=$select_query->fetch_assoc())
                                  { 
                                    $start_date = '';
                                    $end_date = '';
                                    if($row['start_date']){
                                     
                                       $start_date = date('d-m-Y', strtotime($row['start_date']));
                                    }
                                    if($row['end_date']){
                                      
                                       $end_date = date('d-m-Y', strtotime($row['end_date']));
                                    }


                                    $select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where ref_id=".$row['id']." AND ref_type='monthly_pass'");
                                    $qr_code_row = $select_qr->fetch_assoc();
                                    $qr_code = $qr_code_row['qr_code'].'.png';

                                    $MONTHLY_TEMP_DIR = 'monthlypass/'.$row['vendor_id'].'/';?>
                                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $i; ?></td>
                                      
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['vehicle_number'].'<br/>('.$row['vehicle_type'].')'; ?></td>
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['company_name']; ?></td>
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo 'Start : '.$start_date.'<br/> To : '.$end_date; ?></td>
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo date('d-m-Y',$row['pass_issued_date']); ?></td>
                                       <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php  echo $row['grace_date']; ?></td>
                                      
                                       <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['amount']; ?></td>
                                      <td style="padding: 10px; text-align: center; font-family: georgia, serif; font-size: 16px; border:1px solid #093502;"><?php echo $row['payment_type']; ?></td>
                                      <?php
                                       $today=date("Y-m-d");
                                         $curdate=strtotime($today);
                                          $edate=strtotime($end_date);
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

