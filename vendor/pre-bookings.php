<?php include 'header.php'; 

 $currentdate = date('Y-m-d');


$user_id = $_SESSION["current_user_ID"];
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

  $vehicle_book_query = $con->query("SELECT b.*, u.first_name, u.mobile_number FROM `vehicle_pre_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id where b.vendor_id = '".$user_id."' AND (FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");

} else {

  if($active_plans_row['report_export_capacity'] > 0){
    $getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $getend = $currentdate;
  } else {
    $getstart = $currentdate;
    $getend = $currentdate;
  }
 
  $vehicle_book_query = $con->query("SELECT b.*, u.first_name, u.mobile_number FROM `vehicle_pre_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id where FROM_UNIXTIME(`booking_date_time`, '%Y-%m-%d') = (DATE_FORMAT(NOW(),'%Y-%m-%d')) AND  b.vendor_id = '".$user_id."' AND (FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(b.booking_date_time, '%Y-%m-%d') <= '".$getend."') ORDER BY b.id DESC");
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
                          <?php if($active_plans_row['report_export_capacity'] > 0){ ?>
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
                          <?php } ?>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No.</th>
                                 
                                   <th style="display: none;">ID</th>
                                    <th>Vehicle</th>
                                  <th>Mobile Number</th>
                                  <th>Booked By</th>
                                  
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
                                  <td><?php echo $row['vehicle_number'].' ('.$row['vehicle_type'].')'; ?></td>
                                  <td><?php echo $row['mobile_number']; ?></td>
                                  <td><?php echo $row['first_name']; ?></td>
                                  <td><?php echo date('d-m-Y h:i A',$row['arriving_time']); ?></td>
                                  <td><?php echo date('d-m-Y h:i A',$row['leaving_time']); ?></td>
                                  <td><?php echo date('d-m-Y h:i A',$row['booking_date_time']); ?></td>
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

  <?php include '../administration/datatablescript.php'; ?>
 <?php include '../administration/formscript.php'; ?>

 <?php if($active_plans_row['report_export_capacity'] > 0){
    $calstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $calend = $currentdate;
  } else {
    $calstart = $currentdate;
    $calend = $currentdate;
  } ?>
<script type="text/javascript">
  $(document).ready(function(){
      $('#vdate-range').datepicker({
            format: 'yyyy-mm-dd',
            toggleActive: true,
            startDate: new Date('<?php echo $calstart; ?>'),
            endDate: new Date('<?php echo $calend; ?>')
      });
  })
</script>


<?php include 'footer.php' ?>