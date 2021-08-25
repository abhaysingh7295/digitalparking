<?php include 'header.php'; 

  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, u.mobile_number FROM `monthly_pass_pre_payment` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id ORDER BY m.id DESC ");

 ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Digital Card Pre Payment</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Digital Card Pre Payment</li>
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
                                      <th>S.No</th>
                                      <th style="display: none;">ID</th>
                                      <th>Customer </th>
                                      <th>Payment Date</th>
                                      <th>Amount</th>
                                      <th>Payment Type</th>
                                      <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$select_query->fetch_assoc())
                                  { ?>
                                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                      <td><?php echo $i; ?></td>
                                      <td style="display: none;"><?php echo $row['id']; ?></td>
                                       <td><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                                      <td><?php echo date('d-m-Y h:i A',$row['date_time']); ?></td>
                                      <td><?php echo $row['amount']; ?></td>
                                      <td><?php echo $row['payment_type']; ?></td>
                                      <td><a class="" title="Customer Vehicle" href="customer-vehicle.php?user_id=<?php echo $row['customer_id']; ?>" id="<?php echo $row['customer_id']; ?>"><i class="fas fa-car-alt"></i> </a></td>
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
<?php include 'datatablescript.php'; ?>
 
  <!--main content end-->
  <?php include 'footer.php' ?>