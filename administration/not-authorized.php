<?php 
session_start();
include '../config.php';
include 'functions.php';

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
        <title>403 Forbidden | <?php echo $site_settings_row['site_name'];  ?></title>
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
        <div class="error-bg"></div>
        
        <div class="account-pages">
            
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8">
                            <div class="card shadow-lg">
                                <div class="card-block">
                                    <div class="text-center p-3">
                                      
                                            <h1 class="error-page mt-4"><span>403!</span></h1>
                                        <h4 class="mb-4 mt-5">Sorry, you are not authorized to access this page </h4>
                                        
                                        <a class="btn btn-primary mb-4 waves-effect waves-light" href="javascript:void(0)" onclick="window.history.back();"><i class="fas fa-angle-double-left"></i> Go to Back </a>
                                    </div>
                
                                </div>
                            </div>
                                                
                        </div>
                    </div>
                    <!-- end row -->
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
        
    </body>

</html>