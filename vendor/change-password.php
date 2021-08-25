<?php 
session_start();
include '../config.php';
include '../administration/functions.php';
$site_settings_row = getAdminSettings($con);
    $user_id = $_REQUEST['user'] ;
    $key = $_REQUEST['userkey'];


    $currentTime = time();
    $diff = abs($currentTime - $key);

    $fullDays    = floor($diff/(60*60*24));   
    $fullHours   = floor(($diff-($fullDays*60*60*24))/(60*60));   
    $fullMinutes = floor(($diff-($fullDays*60*60*24)-($fullHours*60*60))/60);

    if($fullMinutes > 10){
        $_SESSION['forget_time'] = time();
        $_SESSION['forget_successfully'] = 'User key has been expired. Please reforget your password with new key.';
        $_SESSION['forget_alert'] = 'alert-danger';
        echo "<script>
            window.location.href = 'forgot-password.php';
        </script>";
        exit();
    }


    $select_query = $con->query("SET NAMES utf8");
    $select_query = $con->query("SELECT * FROM `pa_users` where id='".$user_id."' AND user_status=1 AND user_role='vandor'");
    //echo $select_query->num_rows;
    if($select_query->num_rows==0) {
        $_SESSION['login_time'] = time();
        $_SESSION['login_successfully'] = 'User Not Exists .';
        $_SESSION['login_alert'] = 'alert-danger';
        echo "<script>
            window.location.href = 'login.php';
        </script>";
        exit();
    }

    $row = $select_query->fetch_assoc();

    if(isset($_POST['submit'])){
        $password = $_POST['password'];
        $cfpassword = $_POST['cpassword'];

        if($password==$cfpassword) {    
            $newpassword = $password;
            $con->query("UPDATE `pa_users` set user_pass='".$newpassword."' where id='".$user_id."'");

            $time = time();
            $key = $row['user_pass'];
            $user = $row['id'];
            $username = $row['first_name'].' '.$row['last_name'];
            $to = $email;
            
            //$to = 'deepshar2009@gmail.com';
            $subject = "Password has been changed on ".$site_settings_row['site_name'];
            $message = 'Dear '.$username.', <br/>
            <br/>
            Your Password has been changed. Now you can use your new password for login <br/><br/>
            Thank You<br/>
            '.$site_settings_row['site_name'].' Team<br/>';
            SendEmailNotification($to,$subject,$message);

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
        <title>Change Your Password | <?php echo $site_settings_row['site_name'];  ?></title>
        <?php if($site_settings_row['favicon_logo']!=''){ ?>
          <link rel="shortcut icon" type="image/png" href="<?php echo ADMIN_URL.$site_settings_row['favicon_logo']; ?>"/>
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
                        <h5 class="font-18 text-center">Change Password</h5>
    
                        <form class="form-horizontal m-t-30" action="" method="post">
                            <input type="hidden" name="userkey" value="<?php echo $key; ?>">
                            <input type="hidden" name="user" value="<?php echo $user_id; ?>">
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