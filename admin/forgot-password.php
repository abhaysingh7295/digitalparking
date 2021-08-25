<?php 
session_start();
include 'config.php'; 


if(isset($_POST['submit'])){
	 $email = mysqli_real_escape_string($con,$_POST['username']);
	
	 $select_query = $con->query("SET NAMES utf8");
	 $select_query = $con->query("SELECT * FROM `login` where Email='".$email."'");
	 if($row = $select_query->fetch_assoc())
 { 
$key = $row['Password'];
$user = $row['Id'];
$username = $row['display_name'];

$to = $email;
$subject = "Forget Passowrd";

$message = '
Dear '.$username.', <br/>
<br/>
If You Forget your password then you can change your to click below Link : <br/><br/>
<a href="'.$site_settings_row['site_url'].'/admin/change-password.php?user='.$user.'&userkey='.$key.'">Click here</a><br/><br/>

Thank You<br/>
Rental Supporter Team<br/>
';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <'.$site_settings_row['contact_email'].'>' . "\r\n";

mail($to,$subject,$message,$headers);

$_SESSION['forget_time'] = time();
$_SESSION['forget_successfully'] = 'A Link Send you on your email address now can Change your password to use your secrete link.';
$_SESSION['forget_alert'] = 'alert-success';

echo "<script>
		  window.location.href = 'forgot-password.php'; 
		</script>";
		


 } else{
	$_SESSION['forget_time'] = time();
$_SESSION['forget_successfully'] = 'Oops! The details you entered were incorrect.';
$_SESSION['forget_alert'] = 'alert-danger';
echo "<script>
		  window.location.href = 'forgot-password.php'; 
		</script>";

	 }
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img/favicon.png">
<title>Forgot Password | <?php echo $site_settings_row['site_name'];  ?></title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet" />
<?php if($site_settings_row['favicon_logo']!=''){ ?>
  <link rel="shortcut icon" type="image/png" href="<?php echo $site_settings_row['favicon_logo']; ?>"/>
  <?php } ?>
</head>
<body class="login-body">
<div class="container">
<div class="text-center admin-site-logo">
<?php
			if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';	
} else {
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
}
echo $site_logo;
			 ?></div>
  <form id="forgot-password-frm" class="form-signin" action="" method="post">
    <?php if(isset($_SESSION['forget_time'])) { ?>
    <div class="alert <?php echo $_SESSION['forget_alert']; ?>">
              <ul class="fa-ul">
                <li> <?php echo $_SESSION['forget_successfully']; ?></li>
              </ul>
            </div>
            <?php }?>
    <h2 class="form-signin-heading">Forgot Password</h2>
    <div class="login-wrap">
      <input type="email" class="form-control" name="username" placeholder="Email" autofocus>
       <label class="checkbox">
         	<span class="pull-right"> <a href="login.php"> Sign in</a> </span> </label>
      <button class="btn btn-lg btn-login btn-block" type="submit" name="submit">Forgot Now</button>
    </div>
  </form>
</div>

<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

<?php if (time() - $_SESSION['forget_time'] < 2) { // 5 seconds 
// session start

} else {
   unset($_SESSION['forget_time']); 
  unset($_SESSION['forget_successfully']); 
  unset($_SESSION['forget_alert']); 
}
?>

</body>
</html>