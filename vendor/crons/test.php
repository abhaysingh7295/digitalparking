<?php include '../../config.php'; 

error_reporting(-1);
include '../../administration/functions.php';

echo "test";

$message = "This is the testing email";
		$to = 'manoj@snehlaxmi.com';
		$subject = 'Test Parking Report -'. time();
		SendEmailNotification($to,$subject,$message);
