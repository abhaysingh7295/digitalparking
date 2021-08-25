<?php include '../config.php'; 
session_start();

/*if(!isset($_SESSION['vendor_lock']))
{
header('location:lock.php');
}*/

if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}

include '../administration/functions.php';


$site_settings_row = getAdminSettings($con);
 if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';    
} else {
$site_logo = '<img alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.ADMIN_URL.$site_settings_row['dashboard_logo'].'" />';
}

$current_user_id = $_SESSION["current_user_ID"];
$staff_id = $_SESSION['staff_id'];


if($staff_id==''){
   
   $select_current_user_query = $con->query("SELECT * FROM `pa_users` where id = '".$current_user_id."'"); 
   $admin_login_row=$select_current_user_query->fetch_assoc(); 

if($admin_login_row['profile_image']==''){
    $admin_profile_image = 'https://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';   
} else {
    $admin_profile_image = $admin_login_row['profile_image'];
}

if($admin_login_row['adhar_image']==''){
    $admin_adhar_image = ''; 
} else {
    $admin_adhar_image = $admin_login_row['adhar_image'];
}

if($admin_login_row['pan_card_image']==''){
    $admin_pan_card_image = ''; 
} else {
    $admin_pan_card_image = $admin_login_row['pan_card_image'];
}

if($admin_login_row['parking_logo']==''){
    $admin_parking_logo = ''; 
} else {
    $admin_parking_logo = $admin_login_row['parking_logo'];
}
}else{
    $select_current_user_query = $con->query("SELECT * FROM `staff_details` where staff_id = '".$staff_id."'");
      $admin_login_row=$select_current_user_query->fetch_assoc(); 
    if($admin_login_row['profile_image']==''){
    $admin_profile_image = 'https://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';   
        } else {
            $admin_profile_image = $admin_login_row['profile_image'];
        }
}


$admin_access_permission = AdminUserPermission($con, $current_user_id);
$staff_access_permission = StaffUserPermission($con, $staff_id);
//print_r($staff_access_permission);
$active_plans_row = GetVendorActivatedPlan($con,$current_user_id);
$active_plan_id = $active_plans_row['subscription_plan_id'];
//print_r($active_plans_row);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Vendo Admin | <?php echo $site_settings_row['site_name']; ?></title>
    <?php if($site_settings_row['favicon_logo']!=''){ ?>
      <link rel="shortcut icon" type="image/png" href="<?php echo ADMIN_URL.$site_settings_row['favicon_logo']; ?>"/>
      <?php } ?>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>plugins/morris/morris.css">

    <link href="<?php echo ADMIN_URL; ?>plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">

    <link href="<?php echo ADMIN_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMIN_URL; ?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMIN_URL; ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMIN_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css">
     <script src="<?php echo ADMIN_URL; ?>assets/js/jquery.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>
<style type="text/css">
    #topnav .topbar-main .logo{margin-right: 40px; width: 15%;}
     #topnav .topbar-main .logo img{width: 50%; float: left;}
</style>
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

                                <?php if(($active_plans_row['vendor_logo']==1) && ($admin_parking_logo)){ ?>
                                    <img src="<?php echo $admin_parking_logo;  ?>">
                                <?php }  ?>    
                            </span>

                             
                        </a>

                        
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">
                        <ul class="list-inline d-none d-lg-block mb-0">
                            <li class="hide-phone app-search float-left">
                                <form action="parking-history.php" method="get" role="search" class="app-search">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="vehicle_number" placeholder="Search Vehicle">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </li>
                        </ul>

                        <ul class="navbar-right ml-auto list-inline float-right mb-0">
                            
                            <!-- full screen -->
                            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                                <span style="color: #fff;"><?php echo $admin_login_row['parking_name']; ?></span>
                            </li>

                            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                                <a class="nav-link waves-effect" href="wallet-history.php"><i class="fas fa-wallet"></i>&nbsp; <i class="fas fa-rupee-sign"></i>&nbsp; <?php echo number_format($admin_login_row['wallet_amount'],2); ?></a>
                            </li>

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
                                        <?php
                                        if($staff_id=='')
                                        { ?>
                                           <a class="dropdown-item" href="profile.php"><i class="mdi mdi-account-circle"></i> Profile</a>
                                       <?php  } 
                                        else
                                        {?>
                                             <a class="dropdown-item" href="profile_staff.php"><i class="mdi mdi-account-circle"></i> Profile</a>
                                     <?php   } ?>
                                       
                                        
                                        <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> My Wallet</a> -->
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="logout.php"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                    </div>
                                </div>
                            </li>
                            
                             <?php  
                                // if($staff_id=='') { echo "<font color='#fff'>Vendor</font>";  }
                               // else{ echo "<font color='#fff'>Staff</font>";  }
                               echo "<font color='#fff'>". $_SESSION['current_user_Name']."</font>";
                             ?>

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
<?php   
//print_r($_SESSION);
$user_role11 = $_SESSION["current_user_Role1"]; 

              if($user_role11=='vendor')
             {
                
                include('navigation_original.php'); 
            }
            else if($user_role11=='staff')
             {
               
                include('navigation.php'); 
            }
?>

        </header>


        <!-- End Navigation Bar-->

    </div>
    <!-- header-bg -->

    <!--<div class="row plan-expired-alert">
    	<div class="col-md-12">
    <div class="alert alert-danger" role="alert">
             Your Plan has been expired!
        </div>
    </div>
    </div>-->

 