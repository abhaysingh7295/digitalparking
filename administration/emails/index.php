<?php

/*header('location:../index.php');
    exit();*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$emailFrom = 'support@thedigitalparking.com';
$emailFromName = 'TDP';

$emailToName = 'The Digital Parking';
$emailTo = 'support@thedigitalparking.com';


$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "smtp-relay.zoho.in"; // use $mail->Host = gethostbyname('smtp.zoho.in'); // if your network does not support SMTP over IPv6
$mail->Port = 465; // TLS only
$mail->SMTPSecure = 'tls'; // ssl is depracated
$mail->SMTPAuth = true;
$mail->Username = 'support@thedigitalparking.com';
$mail->Password = 'Manoj@tdp1990';
$mail->setFrom($emailFrom, $emailFromName);
$mail->addAddress($emailTo, $emailToName);
$mail->Subject = 'PHPMailer GMail SMTP test';
$mail->msgHTML("test body"); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = 'HTML messaging not supported';
// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
$mail->send();
/*if(!$mail->send()){
    echo "Mailer Error: " . $mail->ErrorInfo;
}else{
    echo "Message sent!";
}*/