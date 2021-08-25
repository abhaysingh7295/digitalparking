<?php include '../config.php'; 
session_start();

/*if(!isset($_SESSION['admin_lock']))
{
header('location:lock.php');
}
*/
if(!isset($_SESSION['sess_user']))
{
    header('location:login.php');
    exit();
}

include 'functions.php';


$site_settings_row = getAdminSettings($con);
 if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';    
} else {
$site_logo = '<img style="width: 51%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.$site_settings_row['dashboard_logo'].'" />';
}

$current_user_id = $_SESSION["current_user_ID"];
$admin_login_query = $con->query("select * from `login` where Id = '".$current_user_id."'");
$admin_login_row = $admin_login_query->fetch_assoc();
if($admin_login_row['profile_image']==''){
    $admin_profile_image = 'https://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';   
} else {
    $admin_profile_image = $admin_login_row['profile_image'];
}

$admin_access_permission = AdminUserPermission($con, $current_user_id);
$basefilename = basename($_SERVER['PHP_SELF']);
if (!in_array($basefilename, $admin_access_permission)){ 
    header('location:not-authorized.php'); exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Administration | <?php echo $site_settings_row['site_name']; ?></title>
    <?php if($site_settings_row['favicon_logo']!=''){ ?>
      <link rel="shortcut icon" type="image/png" href="<?php echo $site_settings_row['favicon_logo']; ?>"/>
      <?php } ?>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="plugins/morris/morris.css">

    <link href="plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
     <link href="assets/js/select2.css" rel="stylesheet" type="text/css">
     <script src="assets/js/jquery.min.js"></script>
       <script src="assets/js/select2.js"></script>
</head>

<body>

    <div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo-->
                    <div>
                        <a href="index.php" class="logo">
                            <span class="logo-light">
                                    <!-- <i class="mdi mdi-camera-control"></i> --> <?php echo $site_logo; ?>
                            </span>
                        </a>
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">
                        <?php if (in_array("vehicle-search.php", $admin_access_permission)){ ?>
                        <ul class="list-inline d-none d-lg-block mb-0">
                            <li class="hide-phone app-search float-left">
                                <form action="all-entity.php" method="get" role="search" class="app-search">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="vehicle_number" placeholder="Search Vehicle">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    <?php } ?>
                        <ul class="navbar-right ml-auto list-inline float-right mb-0">
                            
                            <!-- full screen -->
                            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                    <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                                </a>
                            </li>

                            <!-- notification -->

                            <li class="dropdown notification-list list-inline-item">
                                <div class="dropdown notification-list nav-pro-img">
                                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="<?php echo $admin_profile_image;  ?>" alt="<?php echo $admin_login_row['display_name']; ?>" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <a class="dropdown-item" href="profile.php"><i class="mdi mdi-account-circle"></i> Profile</a>
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> My Wallet</a> -->
                                        <?php if (in_array("all-admins.php", $admin_access_permission)){ ?>
                                            <a class="dropdown-item d-block" href="settings.php"><i class="mdi mdi-settings"></i> Settings</a>
                                        <?php } ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="logout.php"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item dropdown notification-list list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->

             <?php include('navigation.php'); ?>

        </header>
        <!-- End Navigation Bar-->

    </div>
    <!-- header-bg -->