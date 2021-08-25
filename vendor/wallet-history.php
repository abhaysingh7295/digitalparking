<?php include 'header.php'; 

$user_id = $_SESSION["current_user_ID"];
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
  $select_query = $con->query("SELECT * FROM wallet_history where STR_TO_DATE(wallet_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(wallet_date, '%Y-%m-%d') <= '".$getend."' AND user_id = '".$user_id."' ORDER BY id DESC"); 
} else {
  $getstart = '';
  $getend = '';

  $select_query = $con->query("SELECT * FROM wallet_history where user_id = '".$user_id."' ORDER BY id DESC");
}

?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Wallet History</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Wallet History</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                           <form class="filterform" action="" method="get"> 
                            <div class="form-group">
                              <div>
                                <div class="input-daterange input-group" id="date-range">
                                  <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                  <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                            </div>
                          </form>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>Transaction Date</th>
                                  <th style="display: none;">ID</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Type</th>
                                    <th>Withdrawal Amount (INR)</th>
                                    <th>Deposit Amount (INR)</th>
                                    <th>Transaction Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $totalAmountCredit = 0;
                                       $totalAmountDebit = 0;
                                while($row=$select_query->fetch_assoc())
                                {  $amount_type = $row['amount_type'];
                                  if($amount_type=='Dr'){
                                    $debitAmount = $row['amount'];
                                    $creditAmount = '';
                                  } else {
                                    $debitAmount = '';
                                    $creditAmount = $row['amount'];
                                  }  ?>
                                  <tr class="gradeX" >                                   
                                    <td><?php echo date('d-m-Y h:i A', strtotime($row['wallet_date'])); ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['transaction_id']; ?></td>
                                    <td><?php echo $row['transaction_type']; ?></td>                                   
                                    <td><?php echo $debitAmount; ?></td>
                                    <td><?php echo $creditAmount; ?></td>
                                     <td><?php echo $row['transaction_remarks']; ?></td>
                                </tr>
                                <?php $totalAmountCredit = $creditAmount + $totalAmountCredit;
                                      $totalAmountDebit =  $debitAmount + $totalAmountDebit;
                                } ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th colspan="4">Total Amount</th>
                                    <th><?php echo $totalAmountDebit; ?></th>
                                    <th><?php echo $totalAmountCredit; ?></th>
                                    <th></th>
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



<?php include 'footer.php' ?>