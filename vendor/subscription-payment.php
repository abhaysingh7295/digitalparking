<?php include '../config.php'; 
ob_start(); session_start();

if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}

if($_SESSION['subscription_plan']){
	$subscription_plan = $_SESSION['subscription_plan'];
	$vendor_id = $subscription_plan['vendor_id'];
	$amount = $subscription_plan['subscription_amount'];

} else if($_SESSION['add_wallet']){
	$add_wallet = $_SESSION['add_wallet'];
	$vendor_id = $add_wallet['vendor_id'];
	$amount = $add_wallet['amount'];
}

$merchantId = MERCHANTID;
$merchantTxnId = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15);
$select_current_user_query = $con->query("SELECT * FROM `pa_users` where id = ".$vendor_id."");
$admin_login_row = $select_current_user_query->fetch_assoc(); 
extract($admin_login_row);

$success_url = VENDOR_URL.'subscription-response.php?action=success';
$failure_url = VENDOR_URL.'subscription-response.php?action=failure';

if($mobile_number && $user_email && $first_name && $last_name && $adhar_image && $pan_card_image && $parking_name && $address && $state && $open_time && $close_time && $parking_capacity && $online_booking_capacity){

$checksumEncrypt = '{"amount":"'.$amount.'","channel":"'.CHANNEL.'","currency":"INR","customerName":"'.$first_name.'","email":"'.$user_email.'","furl":"'.$failure_url.'","merchantId":"'.$merchantId.'","merchantTxnId":"'.$merchantTxnId.'","mobile":"'.$mobile_number.'","os":"ubuntu-14.04","productInfo":"auth","surl":"'.$success_url.'"}'.MERCHANTKEY;

$CHECKSUM = hash('sha256', $checksumEncrypt);
?>

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
		<form enctype='application/json' action="<?php echo FREECHARGEURL; ?>" id="processfrm" method="post">
			 <input id="amount" value="<?php echo $amount; ?>" name="amount" type="hidden">
			 <input id="channel" name="channel" type="hidden" value="<?php echo CHANNEL; ?>">
			 <input id="currency" name="currency" type="hidden" value="INR" required>
			 <input id="customerName" value="<?php echo $first_name; ?>" name="customerName" type="hidden" >
			 <input id="email" value="<?php echo $user_email; ?>" name="email" type="hidden">
			 <input id="furl" name="furl" type="hidden" value="<?php echo $failure_url; ?>">
			 <input id="merchantId" value="<?php echo $merchantId; ?>" name="merchantId" type="hidden">
			 <input id="merchantTxnId" value="<?php echo $merchantTxnId; ?>" name="merchantTxnId" type="hidden">
			 <input id="mobile" name="mobile" type="hidden" value="<?php echo $mobile_number; ?>">
			 <input id="os" name="os" type="hidden" value="ubuntu-14.04"">
			 <input id="productInfo" name="productInfo" type="hidden" value="auth">
			 <input id="surl" name="surl" type="hidden" value="<?php echo $success_url; ?>">
			 <input id="checksum" name="checksum" type="hidden" value="<?php echo $CHECKSUM; ?>">
			<button style="display: none;" id="checkout" class="btn btn-lg btn-block signin">Checkout</button>
			<h1 style="color: #018001; text-align: center;">Please wait to process Payment...</h1>
		</form>
	</body>
</html>
<?php } else { ?>
	<p>Please complete your profile first. <a href="profile.php">Click here</a></p>
<?php } ?>