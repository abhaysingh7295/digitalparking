<?php 
//header("Access-Control-Allow-Origin: *");
session_start();
include '../config.php';
include '../administration/functions.php';

/*if(!isset($_SESSION['vendor_lock']))
{
	header('location:lock.php');
}*/

if(isset($_POST['submit'])){
    
    // reCAPTCHA validation
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

                // Google secret API
                $secretAPIkey = '6LexNcgaAAAAAFMEYPaw8LjmwxGie3iCmiK8jhGv';

                // reCAPTCHA response verification
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

    
   
   
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $select_query = $con->query("SET NAMES utf8");
    $select_query = $con->query("SELECT * FROM `pa_users` where user_email ='".$username."' AND user_pass='".$password."' AND user_role = 'vandor'");
     $select_query1 = $con->query("SELECT * FROM `staff_details` where staff_email ='".$username."' AND password='".$password."' AND login_type = 'web'");
  /**  echo "**".$select_query->num_rows;
     echo "##".$select_query1->num_rows;
     exit;**/
   
     if($row1 = $select_query1->fetch_assoc())
    { 
        if($row1['active_status']=='active'){
            $_SESSION["sess_user"]= $password;
         //   $_SESSION["current_user_ID"] = $row1['id'];
         $_SESSION["current_user_ID"] = $row1['vendor_id'];
            $_SESSION["current_user_Role"] = "staff";
             $_SESSION["current_user_Role1"] = "staff";
            $_SESSION["current_user_Name"] = $row1['staff_name'];
            $_SESSION['staff_id'] = $row1['staff_id'];

            $active_plans_row = GetVendorActivatedPlan($con,$row1['vendor_id']);
          if($active_plans_row){
                header('location:index.php');
            } else {
               header('location:subscriptions.php'); 
            }
        } else {
            $_SESSION['login_time'] = time();
            $_SESSION['login_successfully'] = 'Oops! You are not the Active Staff Please contact to Vendor.';
            $_SESSION['login_alert'] = 'alert-danger';
        }
    }
    else if($row = $select_query->fetch_assoc())
    { 
        if($row['user_status']==1){
           $_SESSION["current_user_ID"] = $row['id'];
            $browser = check_vender_bowser($con, $row['id']);
            if ($browser === 1) {
                sent_otp($con, $row['mobile_number']);
                header('location:enter_otp.php');
            } else {
                $_SESSION["sess_user"]= $password;
                $_SESSION["current_user_ID"] = $row['id'];
                $_SESSION["current_user_Role"] = $row['user_role'];
                $_SESSION["current_user_Role1"] = "vendor";
                $_SESSION["current_user_Name"] = $row['first_name']." ".$row['last_name'];
                $select_query = $con->query("SELECT * FROM `pa_users` where id='" . $row['id'] . "' AND otp != ''");
                $numrows_qr = $select_query->num_rows;
                if ($numrows_qr > 0) {
                    sent_otp($con, $row['mobile_number']);
                    header('location:enter_otp.php');
                } else {
                    
                    $active_plans_row = GetVendorActivatedPlan($con, $row['id']);
                    if ($active_plans_row) {

                        header('location:index.php');
                    } else {
                        header('location:subscriptions.php');
                    }
                }
            }
        } else {
            $_SESSION['login_time'] = time();
            $_SESSION['login_successfully'] = 'Oops! You are not the Active Vendor Please contact to Admin.';
            $_SESSION['login_alert'] = 'alert-danger';
        }
    }
    else{
        $_SESSION['login_time'] = time();
        $_SESSION['login_successfully'] = 'Oops! The details you entered were incorrect.';
        $_SESSION['login_alert'] = 'alert-danger';
    }
}else{
    $_SESSION['login_time'] = time();
        $_SESSION['login_successfully'] = 'Invalid Captch.';
        $_SESSION['login_alert'] = 'alert-danger'; 
}
}

$site_settings_row = getAdminSettings($con);
 if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';    
} else {
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.ADMIN_URL.$site_settings_row['dashboard_logo'].'" />';
}
 
         
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Vendor Login | <?php echo $site_settings_row['site_name'];  ?></title>
        <?php if($site_settings_row['favicon_logo']!=''){ ?>
          <link rel="shortcut icon" type="image/png" href="<?php echo ADMIN_URL; ?><?php echo $site_settings_row['favicon_logo']; ?>"/>
       <?php } ?>
        <link href="<?php echo ADMIN_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css">

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
     
                                   <div class="form-group">
                            <!-- Google reCAPTCHA block -->
                            <div class="g-recaptcha" data-sitekey="6LdINcgaAAAAAJ58BjX7cf1ns53Vc8k1Wi7F4nHm"></div>
                          </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="submit" type="submit">Log In</button>
                                </div>
                            </div>
    
                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-6">
                                    <a href="forgot-password.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="signup_mobile.php" class="text-muted"><i class="far fa-user m-r-5"></i> Create an account</a>
                                </div>
                            </div>
                        </form>

                        <?php include 'help-support.php'; ?>
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="<?php echo ADMIN_URL; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/metismenu.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/waves.min.js"></script>

        <!-- App js -->
        <script src="<?php echo ADMIN_URL; ?>assets/js/app.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
