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
                        <h4 class="page-title">Vehicle Type Wise Report</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vehicle Type Wise Report</li>
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
                               <button style="margin-left:10px;" type="button" name="submit" id="searchreceipt" value="submit" class="btn btn-danger">Export PDF</button>
<br>

                                </div>
                            </div>
                            </div>
                          </form>
                          <?php } ?>
                           
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                <tr>
                                  <th>S.No.</th> 
                                  <th>Vehicle Type</th>
                                  <th>Booking Type</th>
                                  <th>Total Vehicles</th>
                                  <th>In</th>
                                  <th>Out</th>
                                  <th>Amount</th>
                                  <th>GST (18%)</th>
                                  <th>Total Amount</th>
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
                                        <td><?php echo $i; ?></td> 
                                        <td><?php echo $Vehicledata['vehicle_type']; ?></td>
                                        <td><?php echo $Vehicledata['booking_type']; ?></td>
                                        <td><?php echo $Vehicledata['total_vehicles']; ?></td>
                                        <td><?php echo $Vehicledata['total_in']; ?></td>
                                        <td><?php echo $Vehicledata['total_out']; ?></td>
                                        <td><?php echo number_format($booking_amount,2); ?></td>
                                        <td><?php echo number_format($gstAmount,2); ?></td>
                                        <td><?php echo number_format($total_booking_amount,2); ?></td>
                                      </tr>
                                      <?php $i++; } ?>
                                      <tfoot>
                                        <?php $TotalBookingAmount = array_sum(array_column($VehicleArray, 'total_booking_amount'));
                                          $BookingGSTAmount = $TotalBookingAmount * 18 / 100;
                                          $BookingAmount = $TotalBookingAmount - $BookingGSTAmount;  ?>
                                        <tr>
                                          <td colspan="3"> Total Amount Received</td>
                                          <td> <?php echo array_sum(array_column($VehicleArray, 'total_vehicles')); ?></td>
                                          <td> <?php echo array_sum(array_column($VehicleArray, 'total_in')); ?></td>
                                          <td> <?php echo array_sum(array_column($VehicleArray, 'total_out')); ?></td>
                                          <td> <?php echo number_format($BookingAmount,2); ?></td>
                                          <td> <?php echo number_format($BookingGSTAmount,2); ?></td>
                                          <td> <?php echo number_format($TotalBookingAmount,2); ?></td>
                                        </tr>
                                      </tfoot>
                                     <?php  } ?>
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
            url: 'vehicle-type-wise-report-pdf.php',
            type: 'get',
            data: {'vendor_id': vendor_id,startDate:startDate,endDate:endDate},
            success: function (response) {
                Popup(response);
            }
        });
    });

</script>

  <?php include 'footer.php' ?>