<?php include('header.php');

if($_POST){
	 $status = $_POST['status'];

	if($status =='COMPLETED'){
		$merchantTxnId = $_POST['merchantTxnId'];
		$txnId = $_POST['txnId'];
        if($_SESSION['subscription_plan']){
    		$subscription_plan = $_SESSION['subscription_plan'];
    		$subscription_plan_id = $subscription_plan['plan_id'];
    		$subscriptions_plans = $con->query("select * from `subscriptions_plans` where id = '".$subscription_plan_id."'");
    	    $plans_row = $subscriptions_plans->fetch_assoc();
    	    extract($plans_row);
    	    $staff_capacity = $staff_capacity;
    	    $report_export_capacity = $report_export_capacity;
    	    $subscription_amount = $plan_amount;
    	    $total_subscription_amount = $subscription_plan['subscription_amount'];
    	    $vendor_id = $subscription_plan['vendor_id'];
    	    $subscription_start_date = time();
    	    $subscription_end_date = strtotime(date('Y-m-d',strtotime('+'.$duration.' months',$subscription_start_date)));
    	    $status = 1;
    	    $payment_type = $subscription_plan['payment_method'];
    	    if($active_plan_id==$subscription_plan_id){
            	$con->query("update `vendor_subscriptions` SET status = 1, subscription_end_date = '".$subscription_end_date."' where id = ".$active_plan_id."");
    	    } else {
            	$con->query("update `vendor_subscriptions` SET status = 0, subscription_end_date = '".$subscription_start_date."' where vendor_id = ".$vendor_id."");
             	$con->query("INSERT INTO vendor_subscriptions(subscription_plan_id,vendor_id,staff_capacity, report_export_capacity, duration,self_parking,monthly_pass,pre_booking,sms_notification,auto_email,daily_report,monthly_report,wanted_notification,block_vehicle, wallet, vendor_logo,fare_info, subscription_amount, subscription_start_date,subscription_end_date,status,merchantTxnId,txnId,date_time,payment_type) VALUES('$subscription_plan_id','$vendor_id','$staff_capacity', '$report_export_capacity', '$duration', '$self_parking', '$monthly_pass', '$pre_booking', '$sms_notification', '$auto_email', '$daily_report', '$monthly_report', '$wanted_notification', '$block_vehicle', '$wallet', '$vendor_logo', '$fare_info', '$total_subscription_amount','$subscription_start_date','$subscription_end_date','$status','$merchantTxnId','$txnId','$subscription_start_date','$payment_type')"); 
    	    }

            if($payment_type=='Wallet'){
                $transaction_remarks = $plan_name.' Subscription Buy';
                $wallet_date = date('Y-m-d H:i:s');
                $amount_type = 'Dr';
                $transaction_type = $payment_type;
                $insert_query = "INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$vendor_id','$total_subscription_amount','$amount_type','$txnId','$transaction_type','$wallet_date','$transaction_remarks')";

                if ($con->query($insert_query) === TRUE) {
                    $select_query = $con->query("SELECT * FROM `pa_users` where id = ".$vendor_id."");
                    $row = $select_query->fetch_assoc();
                    $oldwallet = $row['wallet_amount'];
                    $totalWallet = $oldwallet - $total_subscription_amount;
                    $con->query("update `pa_users` SET wallet_amount = '".$totalWallet."' where id = ".$vendor_id);
                }
            }
    	   $responseMessage = '<div class="alert alert-success" role="alert"> <strong>Thank You !</strong> Your subscription active now. You can Use your subscription. </div>';
        } else if($_SESSION['add_wallet']){
            $add_wallet = $_SESSION['add_wallet'];
            $vendor_id = $add_wallet['vendor_id'];
            $amount = $add_wallet['amount'];
            $transaction_id = $txnId;
            $transaction_type = 'Freecharge';
            $transaction_remarks = 'Add to wallet from Freecharge';
            $wallet_date = date('Y-m-d H:i:s');
            $amount_type = 'Cr';

            $insert_query = "INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$vendor_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')";
            if ($con->query($insert_query) === TRUE) {
                $select_query = $con->query("SELECT * FROM `pa_users` where id = ".$vendor_id."");
                $row = $select_query->fetch_assoc();
                $oldwallet = $row['wallet_amount'];
                $totalWallet = $oldwallet + $amount;
                $con->query("update `pa_users` SET wallet_amount = '".$totalWallet."' where id = ".$vendor_id);
            }
            $responseMessage = '<div class="alert alert-success" role="alert"> <strong>Thank You !</strong> Add wallet amount successfully. </div>';
        }
	} else {
		$responseMessage = '<div class="alert alert-danger" role="alert"> <strong>Error !</strong> '.$_POST['errorMessage'].' try subscription again. </div>';
	}

	$_SESSION['subscription_plan'] = '';
	$_SESSION['add_wallet'] = '';
?>
	<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Thank You</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Thank You</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                       
                       <?php echo $responseMessage;  ?>
                       
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php 
} else { ?>

	<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Error!</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Error!</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                       
                       <div class="alert alert-danger" role="alert"> <strong>Error !</strong> Somthing wents to wrong with Freecharge! Please contact with admin </div>
                       
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php }

include('footer.php');