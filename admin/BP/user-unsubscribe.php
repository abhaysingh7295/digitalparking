<?php 
session_start();
include 'config.php';

$userid = $_REQUEST['userid'];

$subscription = $_REQUEST['subscription'];

/*
$base64_userid = base64_encode($userid);

echo $base64_userid; echo '<br/>';


$base64_subscription = base64_encode($subscription);

echo $base64_subscription; echo '<br/>';


$base64_decode = base64_decode($base64_userid);

echo $base64_decode; echo '<br/>';

$base64_decode_subscription = base64_decode($base64_subscription);

echo $base64_decode_subscription; echo '<br/>';

die; */



if(isset($_REQUEST['subscription'])){
	
$select_user = $con->query("SELECT * FROM `user` where user_id = '".$userid."' AND notification_subscription=1");

if($select_user->num_rows > 0) {
$row_users=$select_user->fetch_assoc();

$sql1 = "UPDATE `user` set notification_subscription ='".$subscription."' WHERE user_id='".$userid."'";

if ($con->query($sql1) === TRUE) {
 
$_SESSION['update_time'] = time();
$_SESSION['update_successfully'] = 'Your Subscription Unsubscribe Now.';
$_SESSION['update_alert'] = 'alert-success';

$to = $site_settings_row['contact_email'];
$subject = "Notification Unsubscribe by ".$row_users['name'];
$txt = "Notification Unsubscribe by ".$row_users['name'];

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers = "From: ".$row_users['email'];

mail($to,$subject,$txt,$headers);


}

} else {

$_SESSION['update_time'] = time();
$_SESSION['update_successfully'] = 'Your Subscription Already Unsubscribe.';
$_SESSION['update_alert'] = 'alert-danger';

}
  
header('location:user-unsubscribe.php');
	
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img/favicon.png">
<title>User Unsubscribe | <?php echo $site_settings_row['site_name'];  ?></title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet" />
</head>
<body class="login-body">
<div class="container">
<div class="text-center admin-site-logo">
<?php
			if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';	
} else {
$site_logo = '<img alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
}
echo $site_logo;
			 ?></div>
   
    <?php if(isset($_SESSION['update_time'])) { ?>
    <div class="alert <?php echo $_SESSION['update_alert']; ?>">
              <ul class="fa-ul">
                <li> <?php echo $_SESSION['update_successfully']; ?></li>
              </ul>
            </div>
     <?php }?>
  
</div>
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

<?php if (time() - $_SESSION['update_time'] < 2) { // 5 seconds 
// session start

} else {
   unset($_SESSION['update_time']); 
  unset($_SESSION['update_successfully']); 
  unset($_SESSION['update_alert']); 
}
?>

</body>
</html>