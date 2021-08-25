<?php  require_once '../config.php';

//$regi =  json_decode('{"customer_id":"165"}');

$request = $_REQUEST['request'];
$regi =  json_decode($request);

if($regi){
	$customer_id  = $regi->customer_id; 
	$select_query = $con->query("SELECT * FROM wallet_history where user_id = '".$customer_id."' ORDER BY id DESC");
	$numrows_wallet = $select_query->num_rows;
	if($numrows_wallet > 0){
		while($row=$select_query->fetch_assoc())
		{
			$row_array = array();
			$row_array['amount'] = $row['amount'];
			$row_array['amount_type'] = $row['amount_type'];
			$row_array['transaction_id'] = $row['transaction_id'];
			$row_array['transaction_type'] = $row['transaction_type'];
			$row_array['wallet_date'] = $row['wallet_date'];
			$row_array['transaction_remarks'] = $row['transaction_remarks'];

			$NewRow_array[] = $row_array;
		}

		$array['error_code'] = 200;
		$array['message'] = 'Wallet History';
		$array['result'] = $NewRow_array;

	} else {
		$array['error_code'] = 400;
		$array['message'] = 'Wallet History is Empty';
	}

} else {
	$array['error_code'] = 400;
	$array['message'] = 'Please provide request parameter';
}
$finalarray['response'] = $array;
//echo '<pre>'; print_r($finalarray);

echo json_encode($finalarray);