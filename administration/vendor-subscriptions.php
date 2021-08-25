<?php include 'header.php'; 

$my_subscriptions = $con->query("select vs.*, vs.id as vsid, sp.plan_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.city,v.state) as parking_address from `vendor_subscriptions` as vs JOIN subscriptions_plans AS sp on vs.subscription_plan_id = sp.id JOIN pa_users as v ON vs.vendor_id = v.id ORDER BY vs.id DESC");
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vendor Subscriptions</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vendor Subscriptions</li>
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
                                  <th>Name</th>
                                  <th>Parking Name</th>
                                  <th>Parking Address</th>
                                  <th>Staff</th>
                                  <th>Export</th>
                                  <th>Start Date</th>
                                  <th>End Date</th>
                                  <th>Activate Date</th>
                                  <th>Status</th>
                                  <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$my_subscriptions->fetch_assoc())
                                  { $status = $row['status']; ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['vsid']; ?></td>
                                    <td><?php echo $row['plan_name']; ?></td>
                                    <td><?php echo $row['subscription_amount']; ?></td>
                                    <td><?php echo $row['vendor_name'].'<br/>('.$row['vendor_mobile'].')'; ?></td>
                                    <td><?php echo wordwrap($row['parking_name'],15,"<br>\n"); ?></td>
                                    <td><?php echo wordwrap($row['parking_address'],20,"<br>\n"); ?></td>
                                    <td><?php echo $row['staff_capacity']; ?></td>
                                    <td><?php echo $row['report_export_capacity']; ?> Months</td>
                                    <td><?php echo date('d-m-Y',$row['subscription_start_date']); ?></td>
                                    <td><?php echo date('d-m-Y',$row['subscription_end_date']); ?></td>
                                    <td><?php echo date('d-m-Y',$row['date_time']); ?></td>
                                    <td><?php if($status==1){ echo 'Active'; } else { echo 'Expired'; } ?></td>
                                    <td><a href="edit-vendor-subscription.php?id=<?php echo $row['vsid']; ?>"><i class="fas fa-user-edit"></i></a></td>
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