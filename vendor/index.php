<?php include('header.php'); 

$first_day_this_month = date('Y-m-01');
$last_day_this_month  = date('Y-m-t');  

$today_date  = date('Y-m-d'); 


if($active_plans_row['report_export_capacity'] > 0){
    $getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $getend = $today_date;
} else {
    $getstart = $today_date;
    $getend = $today_date;
}


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
                            </div>
                            <div>
                                <?php  $select_in_vehicle = $con->query("SELECT * FROM `vehicle_booking` where vendor_id = '".$current_user_id."' AND (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."')"); ?>
                                <h5 class="font-16">Total Parking Vehicles</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_in_vehicle->num_rows; ?></h3>
                           <!--  <div class="progress mt-4" style="height: 4px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p> -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                            </div>
                            <div> <?php $select_out_vehicle = $con->query("SELECT * FROM `vehicle_booking` where vendor_id = '".$current_user_id."' AND (FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."')");  ?>
                                <h5 class="font-16">Total Park Out Vehicles</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_out_vehicle->num_rows; ?></h3>
                            <!-- <div class="progress mt-4" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">88%</span></p> -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                            </div>
                            <div> <?php  $today_in_vehicle = $con->query("SELECT * FROM vehicle_booking WHERE (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$today_date."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$today_date."') AND vendor_id = '".$current_user_id."'");  ?>
                                <h5 class="font-16">Today Parking</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $today_in_vehicle->num_rows; ?></h3>
                            <!-- <div class="progress mt-4" style="height: 4px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">68%</span></p> -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-danger text-white"></i>
                            </div>
                            <div> <?php $select_month_booking = $con->query("SELECT id FROM `vehicle_booking` where (FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_in_date_time, '%Y-%m-%d') <= '".$last_day_this_month."' OR FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(vehicle_out_date_time, '%Y-%m-%d') <= '".$last_day_this_month."') AND vendor_id = ".$current_user_id." ORDER BY id DESC");
                                    ?>
                                <h5 class="font-16"><?php echo date('F'); ?> Parking</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_month_booking->num_rows; ?></h3>
                            <!-- <div class="progress mt-4" style="height: 4px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">82%</span></p> -->
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <?php if($active_plans_row['monthly_pass']==1){ ?>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
                            </div>
                            <div>
                                <?php  $select_all_active_pass = $con->query("SELECT count(id) as total_active_pass FROM `monthly_pass` WHERE status = 1 AND (STR_TO_DATE(start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(end_date, '%Y-%m-%d') <= '".$getend."') AND vendor_id = ".$current_user_id.""); 
                                $total_active_pass=$select_all_active_pass->fetch_assoc();
                                
                              //  echo "SELECT count(id) as total_active_pass FROM `monthly_pass` WHERE status = 1 AND (STR_TO_DATE(start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(end_date, '%Y-%m-%d') <= '".$getend."') AND vendor_id = ".$current_user_id;
                                ?>
                                <h5 class="font-16">Total Active Pass</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_active_pass['total_active_pass']; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                            </div>
                            <div> <?php  $select_all_active_month = $con->query("SELECT count(id) as total_active_pass FROM `monthly_pass` WHERE status = 1 AND (STR_TO_DATE(start_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(start_date, '%Y-%m-%d') <= '".$last_day_this_month."' OR STR_TO_DATE(end_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(end_date, '%Y-%m-%d') <= '".$last_day_this_month."') AND vendor_id = ".$current_user_id.""); 
                                $total_active_month_pass=$select_all_active_month->fetch_assoc()
                                ?>
                                <h5 class="font-16">Active Pass in <?php echo date('F'); ?></h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_active_month_pass['total_active_pass']; ?></h3>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if($active_plans_row['pre_booking']==1){ ?>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                            </div>
                            <div> <?php  $select_pre_bookings = $con->query("SELECT count(id) as total_pre_bookings FROM `vehicle_pre_booking` WHERE status = 'Booked' AND (FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') <= '".$getend."') AND vendor_id = ".$current_user_id.""); 
                                $total_pre_bookings=$select_pre_bookings->fetch_assoc()
                                ?>
                                <h5 class="font-16">Total Online Bookings</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_pre_bookings['total_pre_bookings']; ?></h3>
                        </div>
                    </div>
                </div>
                
                 <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-danger text-white"></i>
                            </div>
                            <div> <?php  $select_pre_bookings_month = $con->query("SELECT count(id) as total_pre_bookings FROM `vehicle_pre_booking` WHERE status = 'Booked' AND (FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') <= '".$last_day_this_month."') AND vendor_id = ".$current_user_id.""); 
                                $total_pre_bookings_month=$select_pre_bookings_month->fetch_assoc()
                                ?>
                                <h5 class="font-16">Online Bookings in <?php echo date('F'); ?></h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_pre_bookings_month['total_pre_bookings']; ?></h3>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
            </div>

            <div class="row">

                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Parking Payments</h4>
                            <canvas id="lineChartmy"></canvas>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <?php

                            $select_recent_parking = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name FROM `vehicle_booking` as vb LEFT JOIN `pa_users` AS v ON vb.vendor_id = v.id LEFT JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_status='In' AND vb.vendor_id = '".$current_user_id."' ORDER BY vb.id DESC LIMIT 0, 5");

                             ?>
                            <h4 class="mt-0 header-title mb-4">Recent Park In Vehicles</h4>
                            <ol class="activity-feed mb-0">

                                <?php while($recent_parking_row=$select_recent_parking->fetch_assoc()) { ?>
                                <li class="feed-item">
                                    <div class="feed-item-list">
                                        <p class="text-muted mb-1"><?php echo date('d-m-Y h:i A',$recent_parking_row['vehicle_in_date_time']); ?></p>
                                        <p class="font-15 mt-0 mb-0"><?php echo $recent_parking_row['parking_name']; ?>: <br/><b class="text-primary"><?php echo $recent_parking_row['customer_name'].' ('.$recent_parking_row['vehicle_number'].')'; ?></b></p>
                                    </div>
                                </li>

                            <?php } ?>
                            </ol>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4"><?php echo date('F'); ?> Month Park In - Out</h4>
                            <canvas id="piemy" height="260"></canvas>

                            <!-- <div id="morris-donut-exampleds" class="morris-charts morris-chart-height"></div> -->

                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <?php

                            $select_recent_parking = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name FROM `vehicle_booking` as vb LEFT JOIN `pa_users` AS v ON vb.vendor_id = v.id LEFT JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_status='Out' AND vb.vendor_id = '".$current_user_id."' ORDER BY vb.id DESC LIMIT 0, 5");

                             ?>
                            <h4 class="mt-0 header-title mb-4">Recent Park Out Vehicles</h4>
                            <ol class="activity-feed mb-0">

                                <?php while($recent_parking_row=$select_recent_parking->fetch_assoc()) { ?>
                                <li class="feed-item">
                                    <div class="feed-item-list">
                                        <p class="text-muted mb-1"><?php echo date('d-m-Y h:i A',$recent_parking_row['vehicle_out_date_time']); ?></p>
                                        <p class="font-15 mt-0 mb-0"><?php echo $recent_parking_row['parking_name']; ?>: <br/><b class="text-primary"><?php echo $recent_parking_row['customer_name'].' ('.$recent_parking_row['vehicle_number'].')'; ?></b></p>
                                    </div>
                                </li>

                            <?php } ?>
                            </ol>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
          <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body" style="height: 430px;">

                            <?php $first_day_of_the_week = 'Monday';
                                $start_of_the_week = strtotime("Last $first_day_of_the_week");
                                if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
                                {
                                    $start_of_the_week = strtotime('today');
                                }
                                $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
                                $date_format =  'd-m-Y'; ?>

                            <h4 class="mt-0 header-title">Weekly Park In - Out (<?php echo date($date_format, $start_of_the_week).' TO - '.date($date_format, $end_of_the_week); ?>)</h4>
                            
                          <div id="simple-line-chartmy" class="ct-chart ct-golden-section"></div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

            <!-- START ROW -->
            <div class="row">

            	<?php $select_recent_payment = $con->query("SELECT ph.*, vb.*,CONCAT_WS(' ', c.first_name,c.last_name) as customer_name, c.mobile_number FROM `payment_history` as ph LEFT JOIN vehicle_booking as vb ON vb.id = ph.booking_id LEFT JOIN pa_users as c ON vb.customer_id = c.id WHERE vb.vendor_id = ".$current_user_id." ORDER BY ph.id DESC LIMIT 10 "); ?>
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Recent Payment Receive</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Vehicle Number</th>
                                            <th scope="col">Vehicle Type</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Transaction Type</th>
                                            <th scope="col" colspan="2">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    	 <?php while($recent_payment_row=$select_recent_payment->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $recent_payment_row['customer_name']; ?></td>
                                            <td><?php echo $recent_payment_row['mobile_number']; ?></td>
                                            <td><?php echo $recent_payment_row['vehicle_number']; ?></td>
                                            <td><?php echo $recent_payment_row['vehicle_type']; ?></td>
                                            <td><?php echo $recent_payment_row['amount']; ?></td>
                                            <td><?php echo $recent_payment_row['payment_type']; ?></td>
                                            <td><?php echo date('d-m-Y h:i A',$recent_payment_row['payment_date_time']); ?></td>
                                            <td>
                                                <div>
                                                    <a href="payment-history.php?id=<?php echo $recent_payment_row['booking_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- END ROW -->

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->


<!-- chartjs js -->
    <script src="<?php echo ADMIN_URL; ?>plugins/chartjs/chart.min.js"></script>
    <script src="<?php echo ADMIN_URL; ?>assets/pages/chartjs.init.js"></script>  

    <script type="text/javascript">
       $(document).ready(function(){
        $.ajax({
        url:'<?php echo VENDOR_URL; ?>ajax-report.php',
        type:'POST',
        data:{action:'monthly_parking'},
        success:function(data){
            var obj = $.parseJSON(data);

            var pieChart = {
            labels: obj.labels,
            datasets: [
                {
                    data: obj.values,
                    backgroundColor: [
                        "#30419b",
                        "#02c58d"
                    ],
                    hoverBackgroundColor: [
                        "#30419b",
                        "#02c58d"
                    ],
                    hoverBorderColor: "#fff"
                }]
        };
        $.ChartJs.respChart($("#piemy"),'Pie',pieChart);

        }
    })


    $.ajax({
        url:'<?php echo VENDOR_URL; ?>ajax-report.php',
        type:'POST',
        data:{action:'monthly_payment_received'},
        success:function(data){ 
            var obj = $.parseJSON(data);
            var lineChart = {
            labels: obj.labels,
            datasets: [
                {
                    label: "Monthly Payment Receive",
                    fill: true,
                    lineTension: 0.5,
                    backgroundColor: "rgba(48, 65, 155, 0.2)",
                    borderColor: "#30419b",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#30419b",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#30419b",
                    pointHoverBorderColor: "#30419b",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: obj.values
                }, 
            ]
        };

        var lineOpts = {
            scales: {
                yAxes: [{
                    ticks: {
                        //max: 100,
                       // min: 20,
                       // stepSize: 10
                    }
                }]
            }
        };
        $.ChartJs.respChart($("#lineChartmy"),'Line',lineChart, lineOpts); 
        }

      });


       

        })
    </script>

 <!--Chartist Chart-->
   <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>plugins/chartist/css/chartist.min.css">
    <script src="<?php echo ADMIN_URL; ?>plugins/chartist/js/chartist.min.js"></script>
    <script src="<?php echo ADMIN_URL; ?>plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo ADMIN_URL; ?>assets/pages/chartist.init.js"></script>  

    <script type="text/javascript">
        
        $(document).ready(function(){
        $.ajax({
            url:'<?php echo VENDOR_URL; ?>ajax-report.php',
            type:'POST',
            data:{action:'weekly_parking'},
            success:function(data){
                console.log(data);
                var obj = $.parseJSON(data);

                new Chartist.Line('#simple-line-chartmy', {
                    labels: obj.labels,
                    series: obj.week_data
                }, {
                    fullWidth: true,
                    chartPadding: {
                        right: 40
                    },
                    plugins: [
                        Chartist.plugins.tooltip()
                    ]
                });
            }
    })
            //Simple line chart

        })

    </script>

<?php include('footer.php'); ?>