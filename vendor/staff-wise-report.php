<?php include 'header.php'; 

 
  $currentdate = date('Y-m-d');


  $vendor_id = $current_user_id;

  /*if($active_plans_row['report_export_capacity'] > 0){
    $start_date = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $end_date = $currentdate;
  } else */ if($_GET['start_date'] && $_GET['end_date']){
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
  }  else {
    $start_date = $currentdate;
    $end_date = $currentdate;
  }


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Staff Wise Report</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Staff Wise Report</li>
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
                                  <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo $start_date; ?>" />
                                  <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" value="<?php echo $end_date; ?>"/>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
								  
								   <button style="margin-left:10px;" type="button" name="submit" id="searchreceipt" value="submit" class="btn btn-danger"><i class="fa fa-pdf"></i> Export PDF</button>
                                </div>
                            </div>
                            </div>
                          </form>
                          <?php } ?>
                           
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                              <th>S.No.</th> 
                              <th>Staff Name</th>
                              <th>Booking Type</th>
                              <th>Total Vehicle</th>
                              <th>In</th>
                              <th>Out</th>
                              <th>In Amount</th>
                              <th>Out Amount</th>
                              <th>Final Amount</th>
                               </tr>
                                </thead>
                                <tbody>
                                   <?php //echo "SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout, count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id, staff_id) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id"; 

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
                                        <td><?php echo $in; ?></td> 
                                        <td><?php echo $row_staff['staff_name']; ?></td>
                                        <td><?php echo $row_staff['parking_type']; ?></td>
                                        <td><?php echo $row_staff['total_vehicles']; ?></td>
                                        <td><?php echo $row_staff['vin']; ?></td>
                                        <td><?php echo $row_staff['vout']; ?></td>
                                        <td>
                                          <?php $select_staff_advance_amount = $con->query("SELECT SUM(ph.amount) as advance_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_in_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_in = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."'  AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                          if ($select_staff_advance_amount->num_rows > 0) {
                                            $row_staff_advance_amount = $select_staff_advance_amount->fetch_assoc();
                                            $advance_amount = $row_staff_advance_amount['advance_amount'];
                                          } else {
                                            $advance_amount = 0;
                                          }

                                          echo number_format($advance_amount,2);
                                          ?></td>
                                        <td><?php  

                                          $select_staff_out_amount = $con->query("SELECT SUM(ph.amount) as out_amount, vb.staff_in, ph.staff_id, vb.parking_type FROM vehicle_booking as vb JOIN payment_history as ph ON vb.id = ph.booking_id AND vb.vehicle_out_date_time = ph.payment_date_time WHERE vb.vendor_id = ".$vendor_id." AND vb.staff_out = ".$row_staff['staff_id']." AND vb.parking_type = '".$row_staff['parking_type']."' AND(FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY ph.staff_id, vb.parking_type"); 
                                          if ($select_staff_out_amount->num_rows > 0) {
                                            $row_staff_out_amount = $select_staff_out_amount->fetch_assoc();
                                            $out_amount = $row_staff_out_amount['out_amount'];
                                          } else {
                                            $out_amount = 0;
                                          }

                                         echo number_format($out_amount,2); ?></td>
                                        <td><?php echo number_format($row_staff['total_booking_amount'],2); ?></td>
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
                                        <td colspan="3">Total Payment</td>
                                        <td><?php echo $total_vehicles; ?></td>
                                        <td><?php echo $total_in_vehicles; ?></td>
                                        <td><?php echo $total_out_vehicles; ?></td>
                                        <td><?php echo number_format($total_advance_amount,2); ?></td>
                                        <td><?php echo number_format($total_collect_amount,2); ?></td>
                                        <td><?php echo number_format($total_final_amount,2); ?></td>
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
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
  <!--main content end-->
  <?php //include '../administration/datatablescript.php'; ?>

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
<script type="text/javascript">
    function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title>Report</title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write(data);
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
    $(document).on('click', '#searchreceipt', function () {
        var vendor_id = '<?php echo $vendor_id ;?>';
		var startDate= $('#start_date').val();
         var   endDate=$('#end_date').val();
        $.ajax({
            url: 'staff-wise-report-pdf.php',
            type: 'get',
            data: {'vendor_id': vendor_id,startDate:startDate,endDate:endDate},
            success: function (response) {
                Popup(response);
            }
        });
    });

</script>

  <?php include 'footer.php' ?>