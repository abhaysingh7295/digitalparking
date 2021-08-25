<?php
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
error_reporting(1);
date_default_timezone_set("Asia/Calcutta");
ob_start(); 
$db_host            = 'localhost';   //MySql hostname or IP
$db_username        = 'thedigit_new_user';        //MySql database username
##$db_username        = 'thedigit_admin';        //MySql database username
$db_password        = '8h[?O&%KY_jO';            //MySql dataabse password
##$db_password        = 'Password@123';            //MySql dataabse password
$db_name            = 'thedigit_new';        //MySql database name
$con = mysqli_connect($db_host,$db_username,$db_password, $db_name);

define('DIR', __DIR__);
define('SITE_URL', 'https://www.thedigitalparking.com/digital-parking/');
define('UPLOAD_URL', SITE_URL.'uploads/');
define('ADMIN_URL', SITE_URL.'administration/');
define('VENDOR_URL', SITE_URL.'vendor/');
define('STAFF_URL', SITE_URL.'staff/');
define('STAFF_UPLOAD', STAFF_URL.'uploads/');
define('CUSTOMER_QR_DIR', DIR.'/customer/qrcodes/');
define('CUSTOMER_QR_URL', SITE_URL.'customer/qrcodes/');
define('MONTHLY_PASS_URL', VENDOR_URL.'monthlypass/');
define('CUSTOMER_TEMP_DIR', DIR.'/customer/temp/');


//define('PMODE', 'OFF');
define('PMODE', 'ON');
define('MERCHANTID', '2Ks2W7sANcvaW9');
define('CHANNEL', 'WEB');

if(PMODE=='OFF'){
	define('FREECHARGEURL', 'https://checkout-sandbox.freecharge.in/api/v1/co/pay/init');
	define('MERCHANTKEY', '0e36b6ed-218a-42e7-b890-af9a7f9228c5');
} else {
	define('FREECHARGEURL', 'https://checkout.freecharge.in/api/v1/co/pay/init');
	define('MERCHANTKEY', '7802b408-c314-4a09-9f60-2710cbd9831c');
}

include "phpqrcode/qrlib.php";
