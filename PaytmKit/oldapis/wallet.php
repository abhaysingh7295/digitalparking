<?php 
include 'config.php';
//include 'admin/common-functions.php';
$currentTime = time();


$select_query = $con->query("SELECT * FROM wallet_history as wh INNER JOIN pa_users as u ON wh.user_id=u.id WHERE wh.transaction_type='Trial' and wh.amount_type='Dr' GROUP BY wh.user_id ORDER BY u.id DESC");
while($row=$select_query->fetch_assoc())
{
 
	$then = strtotime($row['register_date']);
	$now = time();
	$difference = $now - $then;
	$days_diffrance = ceil($difference / (60*60*24) );

	if($days_diffrance >= 15) {
		$id = $row['transaction_id'];
		$user_id = $row['user_id'];
		if($row['wallet_amount'] > 0){
			$amount = $row['wallet_amount'];
			$num0 = (rand(10,100));
			$num1 = date("Ymd");
			$num2 = (rand(100,1000));
			$transaction_id = $num0 . $num1 . $num2;
			$transaction_type = 'Auto Detect';
			$transaction_remarks = 'Trial Amount Auto Detect by '.$amount.'Rs / Ref. '. $transaction_id;
			$wallet_date = date('Y-m-d H:i:s');
			$amount_type = 'Cr';
				$con->query("update `wallet_history` SET transaction_type = 'Trial Cash' where transaction_id = ".$id." AND user_id = ".$user_id);
				$con->query("INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')");
				$con->query("update `pa_users` SET wallet_amount = '".$amount."' where id = ".$user_id);
		}	
	}	
}