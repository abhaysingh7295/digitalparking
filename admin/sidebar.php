<?php  include 'config.php'; 
$basename = basename($_SERVER['PHP_SELF']);

 
?>
<ul class="sidebar-menu" id="nav-accordion">

<li class="sub-menu"> <a <?php if($basename=='dashboard.php') { echo 'class="active"'; } ?>  href="dashboard.php" ><i class="icon-dashboard"></i> <span>Dashboard</span> </a> </li>
 
 
 <li class="sub-menu"> <a <?php if($basename=='infopolice.php') { echo 'class="active"'; } ?>  href="infopolice.php" ><i class="fa fa-star"></i> <span>Police Info</span> </a> </li>

 <li class="sub-menu"> <a <?php if($basename=='all-monthly-pass.php') { echo 'class="active"'; } ?>  href="all-monthly-pass.php" ><i class="fa fa-ticket"></i> <span>All Monthly Pass</span> </a> </li>
   
 
 <?php /* ?>
   <li> <a <?php if(($basename=='all-wallets.php') || ($basename=='user-wallet-history.php') || ($basename=='edit-wallet.php')) { echo 'class="active"'; } ?> href="all-wallets.php" ><i class="icon-dashboard"></i> <span>Parking Entity</span> </a> 
   
   </li>
    <?php */ ?>
   
   <li> <a <?php if(($basename=='all-entity.php') || ($basename=='user-wallet-history.php') || ($basename=='edit-wallet.php')) { echo 'class="active"'; } ?> href="all-entity.php" ><i class="fa fa-car"></i> <span>Parking Entity</span> </a> 

   <li class="sub-menu"> <a <?php if(($basename=='all-users.php') || ($basename=='add-user.php') || ($basename=='edit-user.php') || ($basename=='all-customers.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-user"></i> <span>All Users</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-users.php') { echo 'active'; } ?>"> <a href="all-users.php">All Vendors</a> </li>
   <li class="sub-menu <?php if($basename=='all-customers.php') { echo 'active'; } ?>"><a href="all-customers.php">All Customers </a> </li>
   </ul>
   
   </li>
  
   
<li class="sub-menu"> <a <?php if(($basename=='password_change.php')||($basename=='settings.php')||($basename=='profile.php')) { echo 'class="active"'; } ?> href="javascript:;" > <i class="icon-cog"></i> <span>Account</span> </a>
    <ul class="sub">
     <li class="sub-menu <?php if($basename=='profile.php') { echo 'active'; } ?>"><a href="profile.php">Profile</a></li>
     
      <li class="sub-menu <?php if($basename=='password_change.php') { echo 'active'; } ?>"><a href="password_change.php">Change Password</a></li>
    
       <li class="sub-menu <?php if($basename=='settings.php') { echo 'active'; } ?>"><a href="settings.php">Settings</a></li>
       
    </ul>
  </li>
 
  
 
    
    <!--multi level menu end-->

  

</ul>