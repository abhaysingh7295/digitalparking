<?php include '../config.php'; 
ob_start(); session_start();
if($_SESSION['subscription_plan']){
	$subscription_plan = $_SESSION['subscription_plan'];
	$vendor_id = $subscription_plan['vendor_id'];
	$amount = $subscription_plan['subscription_amount'];

	$merchantTxnId = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15);
	$txnId = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 20);
	  

	$select_current_user_query = $con->query("SELECT * FROM `pa_users` where id = ".$vendor_id."");
	$admin_login_row = $select_current_user_query->fetch_assoc(); 
	extract($admin_login_row);

	if($mobile_number && $user_email && $first_name && $last_name && $adhar_image && $pan_card_image && $parking_name && $address && $state && $open_time && $close_time && $parking_capacity && $online_booking_capacity){ ?>

		<!doctype html>
	<html>
	<head>
		<title>Subscription Payment</title>
	</head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
		     $("#processfrm").submit();
		});
	</script>
	<body>
		<form action="subscription-response.php" id="processfrm" method="post">
			 <input id="status" value="COMPLETED" name="status" type="hidden">
			 <input id="txnId" value="<?php echo $txnId; ?>" name="txnId" type="hidden">
			 <input id="merchantTxnId" value="<?php echo $merchantTxnId; ?>" name="merchantTxnId" type="hidden">
			<button style="display: none;" id="checkout" class="btn btn-lg btn-block signin">Checkout</button>
			<h1 style="color: #018001; text-align: center;">Please wait to process Payment...</h1>
		</form>
	</body>
</html>

<?php } else { ?>
	<p>Please complete your profile first. <a href="profile.php">Click here</a></p>
<?php }

} else {
	header('location:subscriptions.php'); exit();
}