<?php include('config.php'); 

$user_id =$_POST['userid'];
$subscribe =$_POST['subscribe']; 
$sqlupdate = "UPDATE `user` set notification_subscription =".$subscribe." WHERE user_id=".$user_id."";
if($con->query($sqlupdate) === TRUE) { 
$select_query = $con->query("SELECT user_id,notification_subscription FROM `user` where user_id = $user_id");
$row=$select_query->fetch_assoc();


if($row['notification_subscription']==1){ ?>
                     <a class="changeuserstatus" title="Unsubscribe" href="javascript:void(0)"  data-subscribe="0" id="<?php echo $row['user_id'];?>"><i class="fa fa-bell-slash-o"></i></a>
                     <?php } else { ?>
                       <a class="changeuserstatus" title="Subscribe" href="javascript:void(0)" data-subscribe="1" id="<?php echo $row['user_id'];?>"><i class="icon-bell"></i></a>
                       <?php } ?>
                         
                      &nbsp;&nbsp;
                     
             
                     
              <a class="edit-user-ajax" data-toggle="modal" data-target="#myModaluser" title="Edit" href="javascript:void(0)" id="<?php echo $row['user_id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp;
              
              <a class="delete-user-ajax" title="Delete" href="javascript:void(0)" id="<?php echo $row['user_id'];?>"><i class="icon-remove"></i></a>
<?php } ?>