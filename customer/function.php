<?php

function SendSMSOLD($mobileNumber, $message){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_PORT => "8080",
    CURLOPT_URL => "http://sms.thedigitalparking.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=0997587a2a679a8204fdca6c3435c0&message=".$message."&senderId=PREKIN&routeId=8&mobileNos=".$mobileNumber."&smsContentType=english",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  /*if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }*/

  return $response;
}


function SendSMS($mobileNumber, $message){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_PORT => "8080",
    //CURLOPT_URL => "http://sms.thedigitalparking.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=0997587a2a679a8204fdca6c3435c0&message=".$message."&senderId=PREKIN&routeId=8&mobileNos=".$mobileNumber."&smsContentType=english",
   // CURLOPT_URL => "http://webmsg.smsbharti.com/app/smsapi/index.php?key=25EE104B6291EC&campaign=0&routeid=9&type=text&contacts=".$mobileNumber."&%20senderid=SOFTEC&msg=".$message,
     CURLOPT_URL => "http://webmsg.smsbharti.com/app/smsapi/index.php?key=25EE104B6291EC&campaign=0&routeid=9&type=text&contacts=".$mobileNumber."&%20senderid=PREKIN&msg=".$message,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  /*if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }*/

  return $response;
}


function AddAmountWallet($con,$user_id, $wallet_amount, $transaction_id, $transaction_remarks, $amount_type, $transaction_type, $order_id){
    $wallet_date = date('Y-m-d H:i:s');
    $select_customer_wallet = $con->query("SELECT wallet_amount FROM pa_users  Where id=".$user_id.""); 
    $customer_wallet_row = $select_customer_wallet->fetch_assoc();  
    if($amount_type=='Cr'){
        $Total_customer_wallet = $customer_wallet_row['wallet_amount'] + $wallet_amount;
      } else {
      $Total_customer_wallet = $customer_wallet_row['wallet_amount'] - $wallet_amount;
    }
    $con->query("update `pa_users` SET wallet_amount = '".$Total_customer_wallet."' where id = ".$user_id);
    $con->query("INSERT INTO `wallet_history` (user_id,order_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$order_id','$wallet_amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')");
}


function WalletTransaction($con,$user_id, $wallet_amount,$transaction_id,$transaction_remarks,$amount_type,$transaction_type,$order_id){
  $wallet_date = date('Y-m-d H:i:s');

  if($transaction_type=='Wallet'){
    $select_customer_wallet = $con->query("SELECT wallet_amount FROM pa_users  Where id=".$user_id.""); 
      $customer_wallet_row = $select_customer_wallet->fetch_assoc();
     if($amount_type=='Cr'){
        $Total_customer_wallet = $customer_wallet_row['wallet_amount'] + $wallet_amount;
      } else {
      $Total_customer_wallet = $customer_wallet_row['wallet_amount'] - $wallet_amount;
    }

    $con->query("update `pa_users` SET wallet_amount = '".$Total_customer_wallet."' where id = ".$user_id);
  }

  $con->query("INSERT INTO `wallet_history` (user_id,order_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$order_id','$wallet_amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')");
  
}
