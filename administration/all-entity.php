<?php include 'header.php'; 
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
 
  if($_GET['vendor_id']) {
    $vendor_id = $_GET['vendor_id'];
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') AND b.vendor_id = ".$vendor_id." ORDER BY b.id DESC");

  } else {
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");
  }



} else if($_GET['vehicle_number']) {

    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id WHERE b.vehicle_number = '".$_GET['vehicle_number']."'  ORDER BY b.id DESC"); 

 } else {
  $getstart = '';
  $getend = '';

  if($_GET['vendor_id']) {
    $vendor_id = $_GET['vendor_id'];
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id WHERE b.vendor_id = ".$vendor_id." ORDER BY b.id DESC");
  } else {
   //$vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id ORDER BY b.id DESC"); 
   $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id WHERE (DATE_FORMAT(b.vehicle_in_date_time ,'%Y-%m-%d')) = (DATE_FORMAT(NOW(),'%Y-%m-%d')) ORDER BY b.id DESC"); 
   //echo "SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id WHERE (DATE_FORMAT(b.vehicle_in_date_time ,'%Y-%m-%d')) = (DATE_FORMAT(NOW(),'%Y-%m-%d')) ORDER BY b.id DESC";
  }
  
}
 ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Parking History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Parking History</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <form action="" method="get" style="width: 30%;"> 
                             <?php if($_GET['vendor_id']) { ?>
                                  <input type="hidden" class="form-control" name="vendor_id" value="<?php echo $_GET['vendor_id']; ?>">
                              <?php } ?>
                            <div class="form-group">
                              <div>
                                <div class="input-daterange input-group" id="date-range">
                                  <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                  <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                            </div>
                          </form>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No.</th>
                                  <th style="display: none;">ID</th>
                                  <th>Booking ID</th>
                                  <th>Vehicle Number</th>
                                  <th>Customer</th>
                                  
                                  <th>Vendor</th>
                                  <th>Parking Name</th>
                                  <th>Parking Address</th>
                                  <th>Latitude</th>
                                  <th>Longitude</th>
                                  <th>In Time</th>
                                  <th>Out</th>
                                  <th>Duration</th>
                                  <th>Amount</th>

                                  <th>Book Type</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php  $i = 1;
                                  $total_vendor_amount = 0;
                                  while($row=$vehicle_book_query->fetch_assoc()) {  
                                  $id = $row['id'];
                                  $vehicle_status = $row['vehicle_status']; ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $id; ?></td>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $row['vehicle_number'].'<br/>('.$row['vehicle_type'].')'; if($row['staff_vehicle_type']=='yes'){ echo ' (Staff)'; } ?></td>
                                    <td><?php echo $row['customer_name'].'<br/>'.$row['mobile_number']; ?></td>
                                    <td><?php echo $row['vendor_name']; ?></td>
                                    <td><?php echo wordwrap($row['parking_name'],15,"<br>\n"); ?></td>
                                    <td><?php echo wordwrap($row['parking_address'],20,"<br>\n"); ?></td>
                                    <td><?php echo $row['latitude']; ?></td>
                                    <td><?php echo $row['longitude']; ?></td>
                                    <td><?php echo date('d-m-Y',$row['vehicle_in_date_time']).' <br/>'.date('h:i A',$row['vehicle_in_date_time']); ?></td>
                                    <td><?php echo date('d-m-Y',$row['vehicle_out_date_time']).' <br/>'.date('h:i A',$row['vehicle_out_date_time']); ?></td>
                                    <td><?php  
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

                                    echo $totalDuration;
                                  ?></td>

                                    <td><?php $vehicle_book_payment = $con->query("SELECT IF(SUM(amount) > 0, SUM(amount), 0) as total_amount FROM `payment_history` where booking_id = '".$id."'");
                                    $row_payment=$vehicle_book_payment->fetch_assoc();
                                    $total_amount = $row_payment['total_amount'];
                                    echo $total_amount; 
                                    $total_vendor_amount = $total_amount + $total_vendor_amount;
                                    ?></td>
                                     <td><?php echo $row['parking_type']; if($row['qr_type']=='monthly_pass'){ echo '<br/> (Pass)'; } ?></td>
                                    <td><?php echo $row['vehicle_status']; ?></td>
                                    <td align="center"><a href="vehicle-payment-history.php?id=<?php echo $row['id']; ?>" title="View Payment History"><i class="fas fa-history" aria-hidden="true"></i></a> &nbsp;&nbsp;

                                    <?php $vehicle_photo = $con->query("SELECT vehicle_photo FROM `customer_vehicle` where vehicle_number  = '".$row['vehicle_number']."'"); 
                                     $row_vehicle_photo=$vehicle_photo->fetch_assoc();
                                      if($row_vehicle_photo['vehicle_photo']){
                                        $vehicle_photo_DIR = '../uploads/'.$row_vehicle_photo['vehicle_photo'];
                                        if(file_exists($vehicle_photo_DIR)){ ?>
                                        <a href="<?php echo $vehicle_photo_DIR; ?>" target="_blank" title="View Vehicle Photo"><i class="fas fa-car-side"></i></a> &nbsp;&nbsp;
                                      <?php }
                                      } ?>

                                    </td>
                                  </tr>
                                  <?php $i++; } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            
            <div class="row" style="margin-right: 66px; float: right;">
           <div class="col-lg-12">
           <h4 style="color: green;">Total Amount : <?php echo $total_vendor_amount; ?> Rs. </h4>
           </div>
          </div>

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
<?php include 'datatablescript.php'; ?>


<?php include 'formscript.php'; ?>


  <!--main content end-->
  <?php include 'footer.php' ?>