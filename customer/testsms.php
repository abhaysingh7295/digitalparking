<?php  require_once '../config.php';

include 'function.php';

$mobileNumber = '9782303930';


$otplength = 6;
 $otpchars = "0123456789";
 $otp_code = substr( str_shuffle( $otpchars ), 0, $otplength );

$sendmessage = 'Hello Deepak Sharma,
your vehicle RJ14 DC 2154 2W has been parked at Manoj
on 2020-6-6 09:25 PM 50 Rs.

For Any Query contact us on +91-7410906906.or visit <App link>';
$message = urlencode($sendmessage);



 $rsp = SendSMS($mobileNumber, $message);

 print_r($rsp);
