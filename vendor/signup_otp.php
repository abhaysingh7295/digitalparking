<?php
//header("Access-Control-Allow-Origin: *");
session_start();
include '../config.php';
include '../administration/functions.php';

if (!isset($_SESSION['verify_mobile'])) {
    
    header('location:login.php');
}

if (isset($_POST['submit'])) {
     $check_otp = mysqli_real_escape_string($con, $_POST['check_otp']);
    if($_SESSION['sent_otp']===$check_otp){
        unset($_SESSION['sent_otp']) ;   
        header('location:signup.php');
        
    } else {
        $_SESSION['login_time'] = time();
        $_SESSION['login_successfully'] = 'Oops! The otp you entered were incorrect.';
        $_SESSION['login_alert'] = 'alert-danger';
    }
}

$site_settings_row = getAdminSettings($con);
if ($site_settings_row['dashboard_logo'] == '') {
    $site_logo = '<span>' . $site_settings_row['site_name'] . '</span>';
} else {
    $site_logo = '<img style="width: 20%;" alt="' . $site_settings_row['site_name'] . '" title="' . $site_settings_row['site_name'] . '" src="' . ADMIN_URL . $site_settings_row['dashboard_logo'] . '" />';
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Vendor OTP | <?php echo $site_settings_row['site_name']; ?></title>
        <?php if ($site_settings_row['favicon_logo'] != '') { ?>
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
                    <h5 class="font-18 text-center">Enter OTP to <?php echo $site_settings_row['site_name']; ?>.</h5>

                    <form class="form-horizontal m-t-30" action="" method="post">

                        <?php if (isset($_SESSION['login_time'])) { ?>
                            <div class="alert <?php echo $_SESSION['login_alert']; ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $_SESSION['login_successfully']; ?>
                            </div>
                        <?php } ?>



                        <div class="form-group">
                            <div class="col-12">
                                <label>Enter OTP</label>
                                <input class="form-control" type="password" required="" name="check_otp" placeholder="OTP">
                            </div>
                        </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="submit" type="submit">Log In</button>
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
        <?php
        if (time() - $_SESSION['forget_time'] < 2) { // 5 seconds 
// session start
        } else {
            unset($_SESSION['login_time']);
            unset($_SESSION['login_successfully']);
            unset($_SESSION['login_alert']);
        }
        ?>

    </body>

</html>
