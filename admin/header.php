<?php 
include 'config.php';
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}


 /* Admin Querys */


$admin_login_query = $con->query("select * from `login` where Id = '".$_SESSION["current_user_ID"]."'");
$admin_login_row = $admin_login_query->fetch_assoc();

$current_user_id = $_SESSION["current_user_ID"];

if($admin_login_row['profile_image']==''){
$admin_profile_image = 'http://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';	
} else {
$admin_profile_image = $admin_login_row['profile_image'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
<meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Welcome To <?php echo $site_settings_row['site_name'];  ?></title>
    <!-- Bootstrap CSS start -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- Bootstrap CSS end -->
     <!--<script src="js/jquery-1.10.2.js"></script>-->
     <!--<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">-->
  <?php if($site_settings_row['favicon_logo']!=''){ ?>
  <link rel="shortcut icon" type="image/png" href="<?php echo $site_settings_row['favicon_logo']; ?>"/>
  <?php } ?>
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="dashboard.php" class="logo">
            <?php
			if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';	
} else {
$site_logo = '<img alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
}
echo $site_logo;
			 ?>
            <!--<span>Directories</span>--></a>
            <!--logo end-->
            
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li><form action="vehicle-search.php" method="get">
                        <input type="text" class="form-control search" placeholder="Search Vehicle" name="vehicle_number">
                        <input type="submit" name="search" value="Search" style="display:none;">
                    </form>
                        
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="<?php echo $admin_login_row['display_name']; ?>" src="<?php echo $admin_profile_image; ?>" height="29" width="29">
                            <span class="username"><?php echo $admin_login_row['display_name']; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="profile.php"><i class="icon-suitcase"></i>Profile</a></li>
                            <li><a href="password_change.php"><i class="icon-user"></i>Password <br/> Change</a></li>
                            <li><a href="settings.php"><i class="icon-cog"></i> Settings</a></li>
                            <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <?php include 'sidebar.php'; ?>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->