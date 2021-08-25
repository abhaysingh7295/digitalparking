<?php 
session_start();
include '../config.php';
include '../administration/functions.php';

if(isset($_POST['submit'])){
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password = $password;
    if($password=='vendorparking')
    { 
        $_SESSION["vendor_lock"]=md5($password);
        header('location:index.php');
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
        <title>Vendor Administration Lock | <?php echo $site_settings_row['site_name'];  ?></title>
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
                                        <label>Pin</label>
                                    <input class="form-control" type="password" required="" name="password" placeholder="Password">
                                </div>
                            </div>
     
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="submit" type="submit">Unlock Vendor </button>
                                </div>
                            </div>
                            <?php if(isset($_SESSION['sess_user'])){ ?>
                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-7">
                                    <a href="logout.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Logout</a>
                                </div>
                            </div>
                        <?php } ?>
                        </form>
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