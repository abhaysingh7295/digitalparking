<?php include 'header.php';

$num0 = (rand(10,100));
$num1 = date("Ymd");
$num2 = (rand(100,1000));

$transaction_id = $num0 . $num1 . $num2;

     ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Add Vendor Wallet Amount </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="save-vendor-wallet.php" enctype="multipart/form-data">


                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Select Vendor</label>
                    <div class="col-lg-10">
                     
                      <select name="user_id"  class="form-control" required="required">
                      <option>Select Vendor</option>
                       <?php
                       $select_query = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor' ORDER BY id DESC");
                        while($row_user=$select_query->fetch_assoc())
                        { ?>
                       <option value="<?php echo $row_user['id']; ?>"><?php echo $row_user['first_name'].' '.$row_user['last_name'].' ('.$row_user['user_email'].')'; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>


                  <div class="form-group ">
                    <label for="amount" class="control-label col-lg-2">Amount </label>
                    <div class="col-lg-10">
                      <input class="form-control" id="amount" name="amount" type="number" required/>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="transaction_id" class="control-label col-lg-2">Transaction ID </label>
                    <div class="col-lg-10">
                      <input class="form-control" id="transaction_id" name="transaction_id" type="number" value="<?php echo $transaction_id; ?>" readonly="readonly" />
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="transaction_type" class="control-label col-lg-2">Transaction Type </label>
                    <div class="col-lg-10">
                      <select id="transaction_type" name="transaction_type" class="form-control">
<option value="">Select Transaction Type</option>
<option value="Cheque">By Cheque</option>
<option value="Direct Bank Transfer">By Direct Bank Transfer</option>
<option value="Cash">By Cash</option>
<option value="Paytm">By Paytm</option>
<option value="PhonePay">By PhonePay</option>
</select>

                  
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="transaction_remarks" class="control-label col-lg-2">Transaction Remarks</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" id="transaction_remarks" name="transaction_remarks" required></textarea> 
                    </div>
                  </div>
                    
                 
                   
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </section>
  <!--main content end-->
  <?php include 'footer.php' ?>