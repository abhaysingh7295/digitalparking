<?php include 'header.php'; 

$user_id = $_SESSION["current_user_ID"];

$my_subscriptions = $con->query("select vs.*, sp.plan_name, vs.status as mystatus from `vendor_subscriptions` as vs JOIN subscriptions_plans AS sp on vs.subscription_plan_id = sp.id where vs.vendor_id = ".$user_id." ORDER BY vs.id DESC");
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">My Subscriptions</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">My Subscriptions</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No.</th>
                                  <th style="display: none;">ID</th>
                                  <th>Plan Name</th>
                                  <th>Amount</th>
                                  <th>Staff Capacity</th>
                                  <th>Export Capacity</th>
                                  <th>Subscription Start Date</th>
                                  <th>Subscription End Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($rows=$my_subscriptions->fetch_assoc())
                                  {  
                                    $status = $rows['mystatus']; ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $rows['id']; ?></td>
                                    <td><?php echo $rows['plan_name']; ?></td>
                                    <td><?php echo $rows['subscription_amount']; ?></td>
                                    <td><?php echo $rows['staff_capacity']; ?></td>
                                    <td><?php echo $rows['report_export_capacity']; ?> Months</td>
                                    <td><?php echo date('d-m-Y h:i A',$rows['subscription_start_date']); ?></td>
                                     <td><?php echo date('d-m-Y h:i A',$rows['subscription_end_date']); ?></td>
                                     <td><?php
                                        $t = time();
                                        $today = date('d-m-Y',$t);
                                        $plan_end =  date('d-m-Y',$rows['subscription_end_date']);

                                        if($t < $rows['subscription_end_date']){ echo 'Active'; } else { echo 'Expired'; } ?>
                                     </td>
                                     <td> <a style="font-size: 18px;" href="invoice.php?id=<?php echo $rows['id']; ?>" title="View Invoice"><i class="fas fa-file-invoice-dollar"></i></a>
                                     
                                          <?php if ($t > $rows['subscription_end_date']): ?>
                                        <a style="font-size: 18px;" href="subscriptions.php" title="Upgrade Now"><i class="fa fa-paper-plane"></i></a>
                                        
                                      <?php endif ?>
                                     </td>
                                     
                                  </tr>
                                  <?php $i++; } ?>
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

  <?php include '../administration/datatablescript.php'; ?>



<?php include 'footer.php' ?>