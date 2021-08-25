<?php 
session_start();
include '../config.php';
include 'functions.php';

/*if(!isset($_SESSION['admin_lock']))
{
	header('location:lock.php');
}*/

if(isset($_POST['submit'])){

    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = $password;
    $select_query = $con->query("SET NAMES utf8");

    $select_query = $con->query("SELECT * FROM `login` where User_name='".$username."' AND Password='".$password."'");
    if($row = $select_query->fetch_assoc())
    { 
        if($row['user_status']==1){
            $_SESSION["sess_user"]= $password;
            $_SESSION["current_user_ID"] = $row['Id'];
            $_SESSION["current_user_Role"] = $row['Role'];
            $_SESSION["current_cities"] = $row['cities'];
            $_SESSION["state"] = $row['state'];
             $_SESSION["mobileno"] = $row['mobileno'];
            $_SESSION["current_user_Name"] = $row['display_name'];
            if($row['Role']=='subadmin'){
                header('location:profile.php');
            } else {
                header('location:index.php');
            }
            
        } else {
            $_SESSION['login_time'] = time();
            $_SESSION['login_successfully'] = 'Oops! Your Account deactivated by Administration.';
            $_SESSION['login_alert'] = 'alert-danger';
        }
        
    } else{
        $_SESSION['login_time'] = time();
        $_SESSION['login_successfully'] = 'Oops! The details you entered were incorrect.';
        $_SESSION['login_alert'] = 'alert-danger';
    }
}


$site_settings_row = getAdminSettings($con);
 if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';    
} else {
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
}
 
         
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Administration Login | <?php echo $site_settings_row['site_name'];  ?></title>
        <?php if($site_settings_row['favicon_logo']!=''){ ?>
          <link rel="shortcut icon" type="image/png" href="<?php echo $site_settings_row['favicon_logo']; ?>"/>
       <?php } ?>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
       <!--  <div class="home-btn d-none d-sm-block">
                <a href="index.html" class="text-white"><i class="fas fa-home h2"></i></a>
            </div> -->
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="index.php" class="logo logo-admin"><?php echo $site_logo; ?></a>
                        </div>
                        <h5 class="font-18 text-center">Sign in to continue to <?php echo $site_settings_row['site_name'];  ?>.</h5>
    
                        <form class="form-horizontal m-t-30" action="" method="post">

                            <?php if(isset($_SESSION['login_time'])) { ?>
                            <div class="alert <?php echo $_SESSION['login_alert']; ?>">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $_SESSION['login_successfully']; ?>
                                    </div>
                             <?php } ?>
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Username</label>
                                    <input class="form-control" type="text" required="" name="username" placeholder="Username">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Password</label>
                                    <input class="form-control" type="password" required="" name="password" placeholder="Password">
                                </div>
                            </div>
     
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="submit" type="submit">Log In</button>
                                </div>
                            </div>
    
                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-7">
                                    <a href="forgot-password.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <!-- <a href="pages-register.html" class="text-muted">Create an account</a> -->
                                </div>
                            </div>
                        </form>
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
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