<?php include('header.php'); 

$first_day_this_month = date('Y-m-01');
$last_day_this_month  = date('Y-m-t');  

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
                                <?php  $select_all_vendor = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor'"); ?>
                                <h5 class="font-16">Total Vendors</h5>
                            </div>
                            <h3 class="mt-4"><?php $total_all_vendor = $select_all_vendor->num_rows; 
                            echo $total_all_vendor; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                            </div>
                            <div> <?php $select_all_customer = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'customer'");  ?>
                                <h5 class="font-16">Total Customers</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_all_customer->num_rows; ?></h3>
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
                            <div> <?php  $select_month_vendor = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor' AND STR_TO_DATE(register_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(register_date, '%Y-%m-%d') <= '".$last_day_this_month."'"); ?>
                                <h5 class="font-16"><?php echo date('F'); ?> Vendors</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_month_vendor->num_rows; ?></h3>
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
                            <div> <?php 
                                    $select_month_customer = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'customer' AND STR_TO_DATE(register_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(register_date, '%Y-%m-%d') <= '".$last_day_this_month."'");  ?>
                                <h5 class="font-16"><?php echo date('F'); ?> Customers</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_month_customer->num_rows; ?></h3>
                            <!-- <div class="progress mt-4" style="height: 4px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">82%</span></p> -->
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
                            </div>
                            <div>
                                <?php  $select_active_vendor = $con->query("SELECT id FROM `vendor_subscriptions` WHERE status = 1"); 
                                $total_active_vendor = $select_active_vendor->num_rows; ?>
                                <h5 class="font-16">Total Active Vendors</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_active_vendor; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                            </div>
                            <div> 
                                <h5 class="font-16">Total Deactive Vendors</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_all_vendor - $total_active_vendor; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                            </div>
                            <div> <?php  $select_active_staffs = $con->query("SELECT staff_id FROM `staff_details` where login_status = 1"); ?>
                                <h5 class="font-16">Total Active Staffs</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_active_staffs->num_rows; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-danger text-white"></i>
                            </div>
                            <div> <?php 
                                    $select_month_expire = $con->query("SELECT id FROM `vendor_subscriptions` WHERE (FROM_UNIXTIME(subscription_end_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(subscription_end_date, '%Y-%m-%d') <= '".$last_day_this_month."') AND status = 1");  ?>
                                <h5 class="font-16"><?php echo date('F'); ?> Vendor Expire</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_month_expire->num_rows; ?></h3>
                        </div>
                    </div>
                </div>


            </div>



            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
                            </div>
                            <div>
                                <?php  $select_all_active_pass = $con->query("SELECT count(id) as total_active_pass FROM `monthly_pass` WHERE status = 1"); 
                                $total_active_pass=$select_all_active_pass->fetch_assoc()
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
                            <div> <?php  $select_all_active_month = $con->query("SELECT count(id) as total_active_pass FROM `monthly_pass` WHERE status = 1 AND (STR_TO_DATE(start_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(start_date, '%Y-%m-%d') <= '".$last_day_this_month."' OR STR_TO_DATE(end_date, '%Y-%m-%d') >= '".$first_day_this_month."' AND STR_TO_DATE(end_date, '%Y-%m-%d') <= '".$last_day_this_month."')"); 
                                $total_active_month_pass=$select_all_active_month->fetch_assoc()
                                ?>
                                <h5 class="font-16">Active Pass in <?php echo date('F'); ?></h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_active_month_pass['total_active_pass']; ?></h3>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                            </div>
                            <div> <?php  $select_pre_bookings = $con->query("SELECT count(id) as total_pre_bookings FROM `vehicle_pre_booking` WHERE status = 'Booked'"); 
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
                            <div> <?php  $select_pre_bookings_month = $con->query("SELECT count(id) as total_pre_bookings FROM `vehicle_pre_booking` WHERE status = 'Booked' AND (FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') >= '".$first_day_this_month."' AND FROM_UNIXTIME(booking_date_time, '%Y-%m-%d') <= '".$last_day_this_month."')"); 
                                $total_pre_bookings_month=$select_pre_bookings_month->fetch_assoc()
                                ?>
                                <h5 class="font-16">Online Bookings in <?php echo date('F'); ?></h5>
                            </div>
                            <h3 class="mt-4"><?php echo $total_pre_bookings_month['total_pre_bookings']; ?></h3>
                        </div>
                    </div>
                </div>
                 <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-danger text-white"></i>
                            </div>
                            <div> <?php $select_out_vehicle = $con->query("SELECT * FROM `sensitive_vehicle` WHERE `status` = '0' ORDER BY `id` DESC");  ?>
                                <h5 class="font-16">Total Sensitive Vehicle In</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_out_vehicle->num_rows; ?></h3>
                        </div>
                    </div>
                </div>
                   <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-danger text-white"></i>
                            </div>
                            <div> <?php $select_out_vehicle = $con->query("SELECT * FROM `sensitive_vehicle` WHERE `status` = '1' ORDER BY `id` DESC");  ?>
                                <h5 class="font-16">Total Sensitive Vehicle Out</h5>
                            </div>
                            <h3 class="mt-4"><?php echo $select_out_vehicle->num_rows; ?></h3>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Parking Payments</h4>
                            <canvas id="lineChartmy"></canvas>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <?php

                            $select_recent_parking = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name FROM `vehicle_booking` as vb JOIN `pa_users` AS v ON vb.vendor_id = v.id JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_status='In' ORDER BY vb.id DESC LIMIT 0, 5");

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
                            <h4 class="mt-0 header-title mb-4">Total Park In - Out</h4>
                            <canvas id="piemy" height="260"></canvas>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Sales Analytics</h4>
                            <div id="morris-line-example" class="morris-chart" style="height: 360px"></div>

                        </div>
                    </div>

                </div> -->

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <?php

                            $select_recent_parking = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name FROM `vehicle_booking` as vb JOIN `pa_users` AS v ON vb.vendor_id = v.id JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_status='Out' ORDER BY vb.id DESC LIMIT 0, 5");

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

            	<?php $select_recent_wallet = $con->query("SELECT wh.*, CONCAT_WS(' ', u.first_name, u.last_name) as full_name, u.mobile_number FROM wallet_history as wh JOIN `pa_users` AS u ON wh.user_id = u.id WHERE wh.amount_type = 'Cr' ORDER BY wh.id DESC LIMIT 10 "); ?>
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Recent Wallet added</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Transaction Type</th>
                                            <th scope="col" colspan="2">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    	 <?php while($recent_wallet_row=$select_recent_wallet->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $recent_wallet_row['full_name']; ?></td>
                                            <td><?php echo $recent_wallet_row['mobile_number']; ?></td>
                                            <td><?php echo $recent_wallet_row['amount']; ?></td>
                                            <td><?php echo $recent_wallet_row['transaction_type']; ?></td>
                                            <td><?php echo date('d-m-Y h:i A', strtotime($recent_wallet_row['wallet_date'])); ?></td>
                                            <td>
                                                <div>
                                                    <a href="wallet-history.php?user_id=<?php echo $recent_wallet_row['user_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
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
        url:'ajax-report.php',
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
        url:'ajax-report.php',
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
            url:'ajax-report.php',
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