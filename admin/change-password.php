<?php 
session_start();
include 'config.php';

$user_id = $_REQUEST['user'] ;
$key = $_REQUEST['userkey'];

$select_query = $con->query("SET NAMES utf8");
//echo "SELECT * FROM `login` where Id='".$user_id."' and Password='".$key."'"; 
$select_query = $con->query("SELECT * FROM `login` where Id='".$user_id."' and Password='".$key."'");
//echo $select_query->num_rows;
if($select_query->num_rows==0) {
$_SESSION['login_time'] = time();
$_SESSION['login_successfully'] = 'User Not Exists .';
$_SESSION['login_alert'] = 'alert-danger';
echo "<script>
window.location.href = 'login.php';
</script>";
}

$row = $select_query->fetch_assoc();


if(isset($_POST['submit'])){
	 $password = mysqli_real_escape_string($con,$_POST['password']);
         $cfpassword = mysqli_real_escape_string($con,$_POST['cfpassword']);

if($password==$cfpassword) {	
	 
$newpassword = md5($password);
$con->query("UPDATE `login` set Password='".$newpassword."' where Id='".$user_id."'");

$_SESSION['login_time'] = time();
$_SESSION['login_successfully'] = 'Your Password has been Change.';
$_SESSION['login_alert'] = 'alert-success';

echo "<script>
		  window.location.href = 'login.php'; 
		</script>";
		
} else {
$_SESSION['forget_time'] = time();
$_SESSION['forget_successfully'] = 'Password does not Match Please try again.';
$_SESSION['forget_alert'] = 'alert-danger';
echo "<script>
		  window.location.href = 'change-password.php?user='.$user_id.'&userkey='.$key; 
		</script>";
}

  
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img/favicon.png">
<title>Change Password | <?php echo $site_settings_row['site_name'];  ?></title>
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
$site_logo = '<img alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
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
    <h2 class="form-signin-heading">Change Your Password</h2>
    <div class="login-wrap">
      <input type="password" class="form-control" name="password" placeholder="New Password" autofocus>
       <input type="password" class="form-control" name="cfpassword" placeholder="Confirm Password" autofocus>
       <label class="checkbox">
         	<span class="pull-right"> <a href="login.php"> Sign in</a> </span> </label>
      <button class="btn btn-lg btn-login btn-block" type="submit" name="submit">Change Now</button>
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