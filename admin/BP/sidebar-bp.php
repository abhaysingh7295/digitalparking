<?php  include 'config.php'; 
$basename = basename($_SERVER['PHP_SELF']);

 
?>
<ul class="sidebar-menu" id="nav-accordion">

<li class="sub-menu"> <a <?php if($basename=='dashboard.php') { echo 'class="active"'; } ?>  href="dashboard.php" ><i class="icon-dashboard"></i> <span>Dashboard</span> </a> </li>
 
 
 <li class="sub-menu"> <a <?php if(($basename=='all-base-categories.php') || ($basename=='all-sub-categories.php') || ($basename=='edit-bcategory.php') || ($basename=='edit-subcategory.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-tags"></i> <span>Categories</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-base-categories.php') { echo 'active'; } ?>"> <a href="all-base-categories.php">All Base Categories</a> </li>
   <li class="sub-menu <?php if($basename=='all-sub-categories.php') { echo 'active'; } ?>"> <a href="all-sub-categories.php">All Sub Categories</a> </li>
  
   </ul>
   
   </li>
   
   
    <li class="sub-menu"> <a <?php if(($basename=='all-songs.php') || ($basename=='add-songs.php') || ($basename=='edit-song.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-music"></i> <span>Songs</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-songs.php') { echo 'active'; } ?>"> <a href="all-songs.php">All Songs</a> </li>
   </ul>
   
   </li>
   
    <li class="sub-menu"> <a <?php if(($basename=='all-songs-images.php') || ($basename=='add-song-image.php') || ($basename=='edit-song-image.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-picture"></i> <span>Songs Images</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-songs-images.php') { echo 'active'; } ?>"> <a href="all-songs-images.php">All Images</a> </li>
   </ul>
   
   </li>
   
   <li class="sub-menu"> <a <?php if(($basename=='all-pujan-samagri.php') || ($basename=='add-pujan-samagri.php') || ($basename=='edit-pujan-samagri.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-archive"></i> <span>Pujan Samagri</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-pujan-samagri.php') { echo 'active'; } ?>"> <a href="all-pujan-samagri.php">All Pujan Samagri</a> </li>
  
   </ul>
   
   </li>
   
   
   <li class="sub-menu"> <a <?php if(($basename=='all-users.php') || ($basename=='add-user.php') || ($basename=='edit-user.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-user"></i> <span>Users</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-users.php') { echo 'active'; } ?>"> <a href="all-users.php">All Users</a> </li>
    <!-- <li class="sub-menu <?php //if($basename=='add-user.php') { echo 'active'; } ?>"><a href="add-user.php">Add New User </a> </li> -->
   </ul>
   
   </li>
   
    <li class="sub-menu"> <a <?php if(($basename=='notifications.php') || ($basename=='notifications-ios.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="fa fa-mobile"></i> <span>Notifications</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='notifications.php') { echo 'active'; } ?>"> <a href="notifications.php">Android Notification</a> </li>
   <li class="sub-menu <?php if($basename=='notifications-ios.php') { echo 'active'; } ?>"> <a href="notifications-ios.php">IOS Notification</a> </li>
   
   </ul>
   
   </li>

<li class="sub-menu"> <a <?php if(($basename=='all-email-notifications.php') || ($basename=='send-email-notifications.php')|| ($basename=='all-email-messages.php')|| ($basename=='add-email-message.php')|| ($basename=='edit-email-message.php')) { echo 'class="active"'; } ?> href="javascript:;" ><i class="icon-envelope"></i> <span>Email Notifications</span> </a> 
   <ul class="sub">
   <li class="sub-menu <?php if($basename=='all-email-notifications.php') { echo 'active'; } ?>"> <a href="all-email-notifications.php">Email Notification</a> </li>
 <li class="sub-menu <?php if($basename=='all-email-messages.php') { echo 'active'; } ?>"> <a href="all-email-messages.php">Email Messages</a> </li>
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