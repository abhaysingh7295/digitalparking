<?php
error_reporting(1);
date_default_timezone_set("Asia/Calcutta");
ob_start(); 
$db_host            = 'localhost';   //MySql hostname or IP
$db_username        = 'thedigit_parking';        //MySql database username
$db_password        = '=%.rWQB]!Zot';            //MySql dataabse password
$db_name            = 'thedigit_parking';        //MySql database name
$con = mysqli_connect($db_host,$db_username,$db_password, $db_name);

include 'common-functions.php';

