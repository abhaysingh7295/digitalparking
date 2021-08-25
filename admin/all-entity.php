<?php include 'header.php';
?>
<!--main content start-->

<section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">All Parking History </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
 
 
 <?php 
 if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
 
  if($_GET['vendor_id']) {
    $vendor_id = $_GET['vendor_id'];
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name FROM `vehicle_booking` as b JOIN pa_users as u ON b.customer_id = u.id JOIN pa_users as v ON b.vendor_id = v.id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') AND b.vendor_id = ".$vendor_id." ORDER BY b.id DESC");

  } else {
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name FROM `vehicle_booking` as b JOIN pa_users as u ON b.customer_id = u.id JOIN pa_users as v ON b.vendor_id = v.id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");
  }



} else {
  $getstart = '';
  $getend = '';

  if($_GET['vendor_id']) {
    $vendor_id = $_GET['vendor_id'];
    $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name FROM `vehicle_booking` as b JOIN pa_users as u ON b.customer_id = u.id JOIN pa_users as v ON b.vendor_id = v.id WHERE b.vendor_id = ".$vendor_id." ORDER BY b.id DESC");
  } else {
   $vehicle_book_query = $con->query("SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name FROM `vehicle_booking` as b JOIN pa_users as u ON b.customer_id = u.id JOIN pa_users as v ON b.vendor_id = v.id ORDER BY b.id DESC"); 
  }
  
}


?>


 <form action="" method="get"> 
  <?php if($_GET['vendor_id']) { ?>
     <input type="hidden" class="form-control" name="vendor_id" value="<?php echo $_GET['vendor_id']; ?>">
  <?php } ?>
 <div class="col-lg-2">
  <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo $getstart; ?>" placeholder="Start Date" required="required">
 </div>

<div class="col-lg-2">
 <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo $getend; ?>" placeholder="End Date" required="required">
</div>

<div class="col-lg-2">
 <input type="submit" name="submit" value="Search" class="btn btn-danger">
 </div>
</form>

    <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers" data-page-length="50">
                  <thead>
                    <tr>
                       <th style="display: none;">ID</th>
                      <th>Vehicle Number</th>
                      <th>Mobile Number</th>
                     
                      <th>Booked By</th>
                      <th>Vendor</th>
                      <th>Vehicle Type</th>
                      <th>Latitude</th>
                      <th>Longitude</th>
                      <th>In Time</th>
                      <th>Out</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php  $total_vendor_amount = 0;
                    while($row=$vehicle_book_query->fetch_assoc()) {  
                       $id = $row['id']; 
                     ?>
                    <tr class="gradeX">
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['vehicle_number']; ?></td>
                      <td><?php echo $row['mobile_number']; ?></td>
                      <td><?php echo $row['customer_name']; ?></td>
                      <td><?php echo $row['vendor_name']; ?></td>
                      <td><?php echo $row['vehicle_type']; ?></td>
                      <td><?php echo $row['latitude']; ?></td>
                      <td><?php echo $row['longitude']; ?></td>
                      <td><?php echo date('Y-m-d h:i A',$row['vehicle_in_date_time']); ?></td>
                      <td><?php echo date('Y-m-d h:i A',$row['vehicle_out_date_time']); ?></td>
                      <td><?php $vehicle_book_payment = $con->query("SELECT IF(SUM(amount) > 0, SUM(amount), 0) as total_amount FROM `payment_history` where booking_id = '".$id."'");
                      $row_payment=$vehicle_book_payment->fetch_assoc();
                      $total_amount = $row_payment['total_amount'];
                      echo $total_amount; 
                      $total_vendor_amount = $total_amount + $total_vendor_amount;
                       ?></td>
                      <td><?php echo $row['vehicle_status']; ?></td>
                      <td align="center"><a href="vehicle-payment-history.php?id=<?php echo $row['id']; ?>" title="View Payment History"><i class="fa fa-history" aria-hidden="true"></i></a></td>
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>
           </div>

           <div class="row" style="margin-right: 66px; float: right;">
           <div class="col-lg-12">
           <h4 style="color: green;">Total Amount : <?php echo $total_vendor_amount; ?> Rs. </h4>
           </div>
          </div>
 <!-- Modal -->
 

              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end--> 
    </section>
  </section>
  
 
<!--main content end-->
<?php include 'footer.php' ?>