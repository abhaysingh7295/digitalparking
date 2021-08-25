<?php 
include 'config.php';

if(isset($_POST['submit'])){
$user_id = $_POST['user_id'];
$amount = $_POST['amount'];
$transaction_id = $_POST['transaction_id'];
$transaction_type = $_POST['transaction_type'];
$transaction_remarks = $_POST['transaction_remarks'];
$wallet_date = date('Y-m-d H:i:s');
$amount_type = 'Dr';

$select_query = $con->query("SELECT * FROM wallet_history WHERE transaction_type='Trial' and amount_type='Dr' and user_id = ".$user_id." ORDER BY id DESC");
if($row = $select_query->fetch_assoc()) {
	$id = $row['transaction_id'];
	$con->query("update `wallet_history` SET transaction_type = 'Trial Cash' where transaction_id = ".$id." AND user_id = ".$user_id);
}

$insert_query = "INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')";

	if ($con->query($insert_query) === TRUE) {
		$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
		$row=$select_query->fetch_assoc() ; 
		$oldwallet = $row['wallet_amount'];
		$totalWallet = $oldwallet + $amount;
		$con->query("update `pa_users` SET wallet_amount = '".$totalWallet."' where id = ".$user_id);
	    header('location:all-wallets.php');
	} 
}