<?php
/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("PaytmChecksum.php");


$request = $_REQUEST['request'];
$regi =  json_decode($request);

$cust_id = $regi->cust_id;
$order_id = $regi->order_id;
$amount = $regi->amount;

if($cust_id && $order_id && $amount){
    
   
    $paytmParams = array();
    
    $paytmParams["body"] = array(
        "requestType"   => "Payment",
        "mid"           => "SZkcXm24032373123909",
        "websiteName"   => "WEBSTAGING",
        "orderId"       => $order_id,
        //"callbackUrl"   => "",
        "txnAmount"     => array(
            "value"     => $amount,
            "currency"  => "INR",
        ),
        "userInfo"      => array(
            "custId"    => $cust_id,
        ),
    );
    
    /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
    */
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "%zjTVWFW0umBo37r");
    
    $paytmParams["head"] = array(
        "signature"    => $checksum
    );
    
    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
    
    /* for Staging */
    $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=SZkcXm24032373123909&orderId=$order_id";
    
    /* for Production */
    // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
    
    $response = curl_exec($ch);
    
     
    $result = json_decode($response, TRUE);
    
    
    $array['error_code'] = 200;
    $array['message'] = "success";
    $array['txnToken'] = $result['body']['txnToken'];
}
else{
 
 $array['error_code'] = 400;
 $array['message'] = 'Please enter required data';   
    
}

$finalarray['response'] = $array;
echo json_encode($finalarray);

?>