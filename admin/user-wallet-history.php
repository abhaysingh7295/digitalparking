<?php include 'header.php';

$user_id = $_GET['user_id']; 

$userselect_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
  $rowuser=$userselect_query->fetch_assoc(); 
?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> <strong><?php echo $rowuser['first_name'].' '.$rowuser['last_name']; ?></strong> Wallet History  </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">


                <?php 
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
//$select_query = $con->query("SELECT * FROM wallet_history where wallet_date between date('".$getstart."') AND date('".$getend."') AND user_id = '".$user_id."' ORDER BY id DESC");

$select_query = $con->query("SELECT * FROM wallet_history where STR_TO_DATE(wallet_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(wallet_date, '%Y-%m-%d') <= '".$getend."' AND user_id = '".$user_id."' ORDER BY id DESC"); 

 
} else {
  $getstart = '';
  $getend = '';

  $select_query = $con->query("SELECT * FROM wallet_history where user_id = '".$user_id."' ORDER BY id DESC");
}

?>


 <form action="" method="get"> 
   <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
 <div class="col-lg-2">
  <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo $getstart; ?>" placeholder="Start Date" required="required">
 </div>

<div class="col-lg-2">
 <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo $getend; ?>" placeholder="End Date" required="required">
</div>

<div class="col-lg-2">
 <input type="submit" name="submit" value="Search" class="btn btn-danger">
 </div>
</form>


		      <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers" data-page-length="100">
                  <thead>
                    <tr>
                      <th>Transaction Date</th>
                       <th>Transaction ID</th>
                       <th>Transaction Type</th>
                      <th>Transaction Remarks</th>
                      <th>Withdrawal Amount (INR)</th>
                       <th>Deposit Amount (INR)</th>
                 
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php
//"SELECT * FROM wallet_history as wh INNER JOIN pa_users as u ON wh.user_id=u.id ORDER BY u.id DESC"

$totalAmountCredit = 0;
$totalAmountDebit = 0;
while($row=$select_query->fetch_assoc())
{

$amount_type = $row['amount_type'];
 
  if($amount_type=='Dr'){
    $debitAmount = $row['amount'];
    $creditAmount = '';
  } else {
    $debitAmount = '';
    $creditAmount = $row['amount'];
  }  
?>

                    <tr class="gradeX">
                      <td><?php echo $row['wallet_date']; ?></td>
                      <td><?php echo $row['transaction_id']; ?></td>
                      <td><?php echo $row['transaction_type']; ?></td>
                      <td><?php echo $row['transaction_remarks']; ?></td>
                      <td><?php echo $creditAmount; ?></td>
                       <td><?php echo $debitAmount; ?></td>
                       
                    </tr>
                    <?php 

$totalAmountCredit = $creditAmount + $totalAmountCredit;
$totalAmountDebit =  $debitAmount + $totalAmountDebit;

                  } ?>
                  </tbody>
                  <tfoot>
                   <tr>
                      <th colspan="4">Total Amount</th>
                       
                      <th><?php echo $totalAmountCredit; ?></th>
                       <th><?php echo $totalAmountDebit; ?></th>
                 
                    </tr>
                  </tfoot>
                </table>
           </div>
 


              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end--> 
    </section>
  </section>
  
 

  <!--main content end-->
  <?php include 'footer.php' ?>