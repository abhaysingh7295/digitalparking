<?php include 'header.php'; 

$user_id = $_SESSION["current_user_ID"];
$id = $_GET["id"];

$currentdate = date('Y-m-d');

if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
  if($id){
    $vehicle_book_query = $con->query("SELECT ph.*, vb.vehicle_number,vb.vehicle_type,staff.staff_name FROM `payment_history` as ph JOIN vehicle_booking as vb ON ph.booking_id = vb.id LEFT JOIN staff_details as staff ON ph.staff_id = staff.staff_id where (FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') <= '".$getend."') AND ph.booking_id = '".$id."' AND vb.vendor_id = ".$user_id." ORDER BY ph.id DESC");
  } else {
    $vehicle_book_query = $con->query("SELECT ph.*, vb.vehicle_number,vb.vehicle_type,staff.staff_name FROM `payment_history` as ph JOIN vehicle_booking as vb ON ph.booking_id = vb.id LEFT JOIN staff_details as staff ON ph.staff_id = staff.staff_id where (FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') <= '".$getend."') AND vb.vendor_id = ".$user_id." ORDER BY ph.id DESC");
  }
} else {
  
  if($active_plans_row['report_export_capacity'] > 0){
    $getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $getend = $currentdate;
  } else {
    $getstart = $currentdate;
    $getend = $currentdate;
  }


  if($id){
    $vehicle_book_query = $con->query("SELECT ph.*, vb.vehicle_number,vb.vehicle_type,staff.staff_name FROM `payment_history` as ph JOIN vehicle_booking as vb ON ph.booking_id = vb.id LEFT JOIN staff_details as staff ON ph.staff_id = staff.staff_id WHERE (FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') <= '".$getend."') AND vb.vendor_id = ".$user_id." AND ph.booking_id = '".$id."' ORDER BY ph.id DESC");
  } else {
     $vehicle_book_query = $con->query("SELECT ph.*, vb.vehicle_number,vb.vehicle_type,staff.staff_name FROM `payment_history` as ph JOIN vehicle_booking as vb ON ph.booking_id = vb.id LEFT JOIN staff_details as staff ON ph.staff_id = staff.staff_id WHERE FROM_UNIXTIME(`payment_date_time`, '%Y-%m-%d') = (DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(ph.payment_date_time, '%Y-%m-%d') <= '".$getend."') AND vb.vendor_id = ".$user_id." ORDER BY ph.id DESC");
  }
}


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Payment History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Payment History</li>
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
                                  <th>S.No.sdffd</th>
                                  <th style="display: none;">ID</th>
                                   <th>Vehicle Number</th>
                                  <th>Vehicle Type</th>
                                  <th>Amount Received</th>
                                  <th>Payment Type</th>
                                  <th>Transaction ID</th>
                                  <th>Staff</th>
                                  <th>Payment Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  $total_vendor_amount = 0;
                                  while($row=$vehicle_book_query->fetch_assoc())
                                  {  
                                    $amount = $row['amount'];
                                    ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['vehicle_number']; ?></td>
                                    <td><?php echo $row['vehicle_type']; ?></td>
                                    <td><?php echo $amount; ?></td>
                                    <td><?php echo $row['payment_type']; ?></td>
                                    <td><?php echo $row['transaction_id']; ?></td>
                                    <td><?php echo $row['staff_name']  ?? 'Self'; ?></td>
                                    <td><?php echo date('d-m-Y h:i A',$row['payment_date_time']); ?></td>
                                  </tr>
                                  <?php
                                   $total_vendor_amount = $total_vendor_amount + $amount;
                               $i++; } ?>
                                </tbody>

                                <tfoot>
                                  <tr>
                                    <th colspan="4"> Total Amount Received</th>
                                    <th><i class="fas fa-rupee-sign"></i> <?php echo $total_vendor_amount; ?></th>
                                    <th colspan="4"></th>
                                    
                                  </tr>
                                </tfoot>
                                 
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