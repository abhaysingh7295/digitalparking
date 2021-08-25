<?php 
session_start();
include '../config.php';
include '../administration/functions.php';
$site_settings_row = getAdminSettings($con);

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con,$_POST['username']);
    $select_query = $con->query("SET NAMES utf8");
    $select_query = $con->query("SELECT * FROM `pa_users` where user_email='".$email."' AND user_role='vandor'");
    if($row = $select_query->fetch_assoc())
    { 
        $time = time();
        $key = $row['user_pass'];
        $user = $row['id'];
        $username = $row['first_name'].' '.$row['last_name'];
        $to = $email;

        //$to = 'deepshar2009@gmail.com';
        $subject = "Forget Password on ".$site_settings_row['site_name'];
        $message = 'Dear '.$username.', <br/>
        <br/>
        If You Forget your password then you can change your to click below Link : <br/><br/>
        <a href="'.VENDOR_URL.'change-password.php?user='.$user.'&userkey='.$time.'">Click here</a><br/><br/>
        Thank You<br/>
        '.$site_settings_row['site_name'].' Team<br/>';
        // this function is not there can you cros check
        SendEmailNotification($to,$subject,$message);

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
        <title>Forgot Password | <?php echo $site_settings_row['site_name'];  ?></title>
        <?php if($site_settings_row['favicon_logo']!=''){ ?>
          <link rel="shortcut icon" type="image/png" href="<?php echo $site_settings_row['favicon_logo']; ?>"/>
        <?php } ?>
        <link href="<?php echo ADMIN_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
       
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="index.php" class="logo logo-admin"><?php echo $site_logo; ?></a>
                        </div>
                        <h5 class="font-18 text-center">Reset Password</h5>
    
                        <form class="form-horizontal m-t-30" action="" method="post">
                            <?php if(isset($_SESSION['forget_time'])) { ?>
                            <div class="alert <?php echo $_SESSION['forget_alert']; ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $_SESSION['forget_successfully']; ?>
                            </div>
                            <?php } ?>
                                
                                <div class="form-group">
                                        <div class="col-12">
                                                <label>Email</label>
                                            <input class="form-control" type="email" name="username" required="" placeholder="Email">
                                        </div>
                                    </div>
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit" name="submit">Send Email</button>
                                </div>
                            </div>

                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-7">
                                    <a href="login.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Login</a>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <!-- <a href="pages-register.html" class="text-muted">Create an account</a> -->
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
        <script src="assets/js/app.js"></script>
<?php if (time() - $_SESSION['forget_time'] < 2) { // 5 seconds 

} else {
   unset($_SESSION['forget_time']); 
  unset($_SESSION['forget_successfully']); 
  unset($_SESSION['forget_alert']); 
}
?>   
    </body>

</html>