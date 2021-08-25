<?php 
session_start();
include '../admin/config.php';


if(isset($_POST['submit'])){
	 
	 $username = mysqli_real_escape_string($con,$_POST['username']);
	 $password = mysqli_real_escape_string($con, $_POST['password']);
	 $select_query = $con->query("SET NAMES utf8");
	 
	 $select_query = $con->query("SELECT * FROM `pa_users` where user_email ='".$username."' AND user_pass='".$password."'");
	 if($row = $select_query->fetch_assoc())

 { 
  $_SESSION["sess_user"]= $password;
   $_SESSION["current_user_ID"] = $row['id'];
   $_SESSION["current_user_Role"] = $row['user_role'];
   $_SESSION["current_user_Name"] = $row['first_name'];
 header('location:dashboard.php');
 
 } else{
	  
	$_SESSION['login_time'] = time();
$_SESSION['login_successfully'] = 'Oops! The details you entered were incorrect.';
$_SESSION['login_alert'] = 'alert-danger';
	 }
 
 
	
	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img/favicon.png">
<title>Login | <?php echo $site_settings_row['site_name'];  ?></title>
<link href="../admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../admin/css/bootstrap-reset.css" rel="stylesheet">
<link href="../admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../admin/css/style.css" rel="stylesheet">
<link href="../admin/css/style-responsive.css" rel="stylesheet" />
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
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="../admin/'.$site_settings_row['dashboard_logo'].'" />';
}
echo $site_logo;
			 ?></div>
  <form class="form-signin" action="" method="post">
    <?php if(isset($_SESSION['login_time'])) { ?>
    <div class="alert <?php echo $_SESSION['login_alert']; ?>">
              <ul class="fa-ul">
                <li> <?php echo $_SESSION['login_successfully']; ?></li>
              </ul>
            </div>
     <?php }?>
    <h2 class="form-signin-heading">Vendor Login</h2>
    <div class="login-wrap">
      <input type="text" class="form-control" name="username" placeholder="User Name" autofocus>
      <input type="password" class="form-control" name="password" placeholder="Password">
      <label class="checkbox">
          <span class="pull-left"> <a href="registration.php">Sign Up</a> </span>
         	<span class="pull-right"> <a href="forgot-password.php"> Forgot Password?</a> </span> </label>
      <button class="btn btn-lg btn-login btn-block" type="submit" name="submit">Sign in</button>
    </div>
  </form>
</div>
<script src="../admin/js/jquery.js"></script> 
<script src="../admin/js/bootstrap.min.js"></script>

<?php if (time() - $_SESSION['forget_time'] < 2) { // 5 seconds 
// session start

} else {
   unset($_SESSION['login_time']); 
  unset($_SESSION['login_successfully']); 
  unset($_SESSION['login_alert']); 
}
?>

</body>
</html>