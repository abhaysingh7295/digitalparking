<?php include 'header.php'; 
$id = $_GET["id"];
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vehicle Payment History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vehicle Payment History</li>
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
                                  <th>Amount (Rs.)</th>
                                  <th style="display: none;">ID</th>
                                  <th>Payment Type</th>
                                  <th>Transaction ID</th>
                                  <th>Payment Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $vehicle_book_query = $con->query("SELECT * FROM `payment_history` where booking_id = '".$id."' ORDER BY id DESC");
                                   while($row=$vehicle_book_query->fetch_assoc())
                                  { ?>
                                    <tr class="gradeX">
                                    <td><?php echo $row['amount']; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['payment_type']; ?></td>
                                    <td><?php echo $row['transaction_id']; ?></td>
                                    <td><?php echo date('d-m-Y h:i A',$row['payment_date_time']); ?></td>
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
<?php include 'datatablescript.php'; ?>
  <!--main content end-->
  <?php include 'footer.php' ?>