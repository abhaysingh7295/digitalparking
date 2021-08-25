<?php 
session_start();
include '../config.php';
include 'functions.php';

    $user_id = $_REQUEST['user'] ;
    $key = $_REQUEST['userkey'];
    $select_query = $con->query("SET NAMES utf8");
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
        <title>Forgot Password | <?php echo $site_settings_row['site_name'];  ?></title>
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
                                                <label>New Password</label>
                                            <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-12">
                                                <label>Confirm Password</label>
                                            <input class="form-control" type="password" name="cpassword" required="" placeholder="Confirm Password">
                                        </div>
                                    </div>
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit" name="submit">Change Now</button>
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

} else {
   unset($_SESSION['forget_time']); 
  unset($_SESSION['forget_successfully']); 
  unset($_SESSION['forget_alert']); 
}
?>   
    </body>

</html>