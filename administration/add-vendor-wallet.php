<?php include 'header.php'; 

$id = '';
$plan_name = '';
$subscription_amount = '';
$plan_content = '';
$staff_capacity = '';
$report_export_capacity = '';


if(isset($_POST['submit'])){
	$user_id = $_POST['user_id'];
	$amount = $_POST['amount'];
	$transaction_id = $_POST['transaction_id'];
	$transaction_type = $_POST['transaction_type'];
	$transaction_remarks = $_POST['transaction_remarks'];
	$wallet_date = date('Y-m-d H:i:s');
	$amount_type = $_POST['amount_type'];;

	/*$select_query = $con->query("SELECT * FROM wallet_history WHERE transaction_type='Trial' and amount_type='Dr' and user_id = ".$user_id." ORDER BY id DESC");
	if($row = $select_query->fetch_assoc()) {
		$id = $row['transaction_id'];
		$con->query("update `wallet_history` SET transaction_type = 'Trial Cash' where transaction_id = ".$id." AND user_id = ".$user_id);
	}*/

	$insert_query = "INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')";

		if ($con->query($insert_query) === TRUE) {
			$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
			$row=$select_query->fetch_assoc() ; 
			$oldwallet = $row['wallet_amount'];
      if($amount_type=='Cr'){
        $totalWallet = $oldwallet + $amount;
      } else {
        $totalWallet = $oldwallet - $amount;
      }
			
			$con->query("update `pa_users` SET wallet_amount = '".$totalWallet."' where id = ".$user_id);
		    header('location:vendor-wallet-history.php');
		} 
	}



?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Add Vendor Wallet</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Add Vendor Wallet</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
 						 <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">


                  <div class="form-group row">
                    <label for="title" class="control-label col-lg-2">Select Parking</label>
                    <div class="col-lg-10">
                     
                      <select name="user_id"  class="form-control" required="required">
                      <option value="">Select Parking</option>
                       <?php
                       $select_query = $con->query("SELECT id, CONCAT_WS(' ', first_name,last_name) as vendor_name, parking_name, CONCAT_WS(' ', address,city,state) as parking_address FROM `pa_users` WHERE user_role = 'vandor' ORDER BY parking_name ASC");
                        while($row_user=$select_query->fetch_assoc())
                        { ?>
                       <option value="<?php echo $row_user['id']; ?>"><?php echo $row_user['parking_name'].' ('.$row_user['parking_address'].')'; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="amount" class="control-label col-lg-2">Amount </label>
                    <div class="col-lg-10">
                      <input class="form-control" id="amount" name="amount" type="number" required/>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="title" class="control-label col-lg-2">Amount Type</label>
                    <div class="col-lg-10">
                      <select name="amount_type" class="form-control" required="required">
                      <option value="">Select Type</option>
                      <option value="Dr">Debit</option> 
                      <option value="Cr">Credit</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="transaction_id" class="control-label col-lg-2">Transaction ID </label>
                    <div class="col-lg-10">
                      <input class="form-control" id="transaction_id" name="transaction_id" type="text" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="transaction_type" class="control-label col-lg-2">Transaction Type </label>
                    <div class="col-lg-10">
                      <select id="transaction_type" name="transaction_type" class="form-control" required>
        							<option value="">Select Transaction Type</option>
        							<option value="Cheque">By Cheque</option>
        							<option value="Direct Bank Transfer">By Direct Bank Transfer</option>
        							<option value="Cash">By Cash</option>
        							<option value="Paytm">By Paytm</option>
        							<option value="PhonePay">By PhonePay</option>
                      <option value="Wallet">By Wallet</option>
        						</select>
                  
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="transaction_remarks" class="control-label col-lg-2">Transaction Remarks</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" id="transaction_remarks" name="transaction_remarks" required></textarea> 
                    </div>
                  </div>
                    
                 
                   
                  <div class="form-group row">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit">Submit</button>
                    </div>
                  </div>
                </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>


     
<?php include 'formscript.php'; ?>

<script>
 $(document).ready(function() {
 $('#subscription_start_date,#subscription_end_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script>


<?php include 'footer.php'; ?>