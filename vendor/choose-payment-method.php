<?php include('header.php'); 

$subscription_plan = $_SESSION['subscription_plan'];
$vendor_id = $subscription_plan['vendor_id'];
$plan_id = $subscription_plan['plan_id'];
$amount = $subscription_plan['subscription_amount'];


$select_wallet_query = $con->query("SELECT wallet_amount FROM `pa_users` where id = ".$current_user_id."");
$row_wallet = $select_wallet_query->fetch_assoc();
$wallet_amount = $row_wallet['wallet_amount'];

if(isset($_POST['submit']))
{
    $_SESSION['add_wallet'] = '';
    if($_POST['payment_method']=='Wallet'){
    	if($wallet_amount >= $_POST['subscription_amount']){
    		$_SESSION['subscription_plan'] = $_POST;
    		echo "<script> if(confirm('Are you sure to buy Subscription with wallet !')){ window.location.href = 'subscription-wallet-payment.php'; } </script>"; 
    	} else {
    		 echo "<script> alert('Your Wallet Amount is less for buying Subscription'); window.location.href = 'choose-payment-method.php'; </script>"; exit();
    	}
    } else {
    	$_SESSION['subscription_plan'] = $_POST;
    	header('location:subscription-payment.php'); exit();
    }
}

?>
<style type="text/css">
.dlk-radio input[type="radio"] {
    margin-left: -99999px;
    display: none;
}
.dlk-radio input[type="radio"] + .fa {
    opacity: 0.15;
}
.dlk-radio input[type="radio"]:checked + .fa {
    opacity: 1;
}
.dlk-radio label{padding: 30px; font-size: 20px;}
</style>
	<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <!-- <div class="col-sm-6">
                        <h4 class="page-title">Choose Payment Method</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Choose Payment Method</li>
                        </ol>
                    </div> -->
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                       
                     <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">

                     	<div class="well well-sm text-center">
						    <h3>Select Payment Method</h3>
					      <div class="dlk-radio btn-group">
						    <label class="btn btn-success">
						        <input name="payment_method" class="form-control" type="radio" value="Freecharge" checked="checked">
						        <i class="fa fa-check glyphicon glyphicon-ok"></i> Freecharge
						   </label>
						    
						   <label class="btn btn-info">
						       <input name="payment_method" class="form-control" type="radio" value="Wallet">
						       <i class="fa fa-check glyphicon glyphicon-ok"></i> Wallet (<i class="fas fa-rupee-sign"></i> <?php echo $wallet_amount; ?>)
					       </label>
						   
					    </div>
					    <input type="hidden" name="vendor_id" value="<?php echo $current_user_id; ?>">
								<input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
								<input type="hidden" name="subscription_amount" value="<?php echo $amount; ?>">          
		                      <button class="btn btn-danger" type="submit" name="submit" style="padding:15px; font-size:20px; width: 225px;">Next</button>
						</div>
 
		                  <div class="form-group row">
		                    <div class="col-lg-offset-2 col-lg-10">
								
		                    </div>
		                  </div>
		                </form>
                       
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php 

include('footer.php');