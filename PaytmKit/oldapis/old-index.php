<?php 
session_start();
include 'admin/config.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img/favicon.png">
<title><?php echo $site_settings_row['site_name'];  ?></title>
<link href="admin/css/bootstrap.min.css" rel="stylesheet">
<link href="admin/css/bootstrap-reset.css" rel="stylesheet">
<link href="admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="admin/css/style.css" rel="stylesheet">
<link href="admin/css/style-responsive.css" rel="stylesheet" />
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
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="admin/'.$site_settings_row['dashboard_logo'].'" />';
}
echo $site_logo;
			 ?></div>
<div class="row">
    <div class="col-md-6">
        <form class="form-signin" action="" method="post">
        <a href="admin/index.php"><h2 class="form-signin-heading">Admin Login</h2></a>
    
  </form>
      
        </div>
    <div class="col-md-6"> <form class="form-signin" action="" method="post">
      <a href="vendor/index.php"><h2 class="form-signin-heading">Vendor Login</h2></a>  
    
  </form>
  </div>
    
</div>
</div>
<script src="admin/js/jquery.js"></script> 
<script src="admin/js/bootstrap.min.js"></script>

</body>
</html>