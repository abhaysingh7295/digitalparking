<?php include 'header.php'; 

 $currentdate = date('Y-m-d');


$user_id = $_SESSION["current_user_ID"];
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

  $vehicle_book_query = $con->query("SELECT b.*, u.first_name, u.mobile_number, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address, FROM `vehicle_pre_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id where (FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");

} else {
  $vehicle_book_query = $con->query("SELECT b.*, u.first_name, u.mobile_number, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address FROM `vehicle_pre_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN pa_users as v ON b.vendor_id = v.id ORDER BY b.id DESC");
}


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Pre Booking History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Pre Booking History</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                           <form action="" method="get" class="filterform"> 
                            <div class="form-group">
                              <div>
                                <div class="input-daterange input-group" id="vdate-range">
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
                                   <th>Vehicle</th>
                                   <th>Parking</th>
                                   <th>Address</th>
                                  <th>Customer</th>
                                  <th>Arriving Time</th>
                                  <th>Leaving Time</th>
                                  <th>Booked On</th>
                                  <th>Amount</th>
                                  <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  $total_vendor_amount = 0;
                                  while($row=$vehicle_book_query->fetch_assoc())
                                  { 
                                  $id = $row['id'];   ?>
                                  <tr class="gradeX">
                                  <td><?php echo $i; ?></td>
                                  
                                  <td style="display: none;"><?php echo $row['id']; ?></td>
                                   <td><?php echo $row['id']; ?></td>
                                  <td><?php echo $row['vehicle_number'].' ('.$row['vehicle_type'].')'; ?></td>
                                  <td><?php echo wordwrap($row['parking_name'],15,"<br>\n"); ?></td>
                                  <td><?php echo wordwrap($row['parking_address'],20,"<br>\n"); ?></td>
                                  <td><?php echo $row['first_name'].'<br/> ('.$row['mobile_number'].')'; ?></td>
                                   <td><?php echo date('d-m-Y',$row['arriving_time']).' <br/>'.date('h:i A',$row['arriving_time']); ?></td>
                                    <td><?php echo date('d-m-Y',$row['leaving_time']).' <br/>'.date('h:i A',$row['leaving_time']); ?></td>
                                    <td><?php echo date('d-m-Y',$row['booking_date_time']).' <br/>'.date('h:i A',$row['booking_date_time']); ?></td>
                                  <td><?php echo $row['amount']; ?></td>
                                   
                                  <td><?php echo $row['status']; ?></td>
                                   
                                  </tr>
                                  <?php $i++; }  ?>
                                </tbody>
                                <!-- <tfoot>
                                  <tr>
                                    <td colspan="7">Total Amount </td>
                                    <td><i class="fas fa-rupee-sign"></i> <?php echo $total_vendor_amount; ?></td>
                                    <td colspan="3"></td>
                                  </tr>
                                </tfoot> -->
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
  <!--main content end-->

  <?php include 'datatablescript.php'; ?>
 <?php include 'formscript.php'; ?>

 


<?php include 'footer.php' ?>