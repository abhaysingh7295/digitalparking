<?php include 'header.php'; 

if(isset($_POST['submit'])){
  $_SESSION['subscription_plan'] = '';
  $_SESSION['add_wallet'] = $_POST;
  header('location:subscription-payment.php'); exit();
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
                    <label for="amount" class="control-label col-lg-2">Amount </label>
                    <div class="col-lg-10">
                      <input class="form-control" id="amount" name="amount" type="number" required/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-offset-2 col-lg-10">
                      <input type="hidden" name="vendor_id" value="<?php echo $current_user_id; ?>">
                      <button class="btn btn-danger" type="submit" name="submit">Add</button>
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


 
<?php include 'footer.php'; ?>