<?php include 'header.php' ?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Vendors  <span style="float: right;"><a class="btn-info btn" href="add-user.php">Add New</a></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
<div class="col-lg-2">
<select id="loginwith" name="loginwith" class="form-control">
<option value="">Filter By Login With</option>
<option value="google">Google</option>
<option value="facebook">Facebook</option>
<option value="simple">Simple</option>
</select>
</div>

<div class="col-lg-3">
<select id="useros" name="useros" class="form-control">
<option value="">Filter By Operating System</option>
<option value="android">Android</option>
<option value="ios">IOS</option>

</select>
</div>

<div class="col-lg-2">
<select id="domainfliter" name="domainfliter" class="form-control">
<option value="">Filter By Domain</option>
 <?php $select_domain = $con->query("SELECT substring_index(user_email, '@', -1) domain, COUNT(*) email_count FROM pa_users  WHERE user_role = 'vandor' GROUP BY substring_index(user_email, '@', -1) ORDER BY email_count DESC, domain"); 
while($row_domain=$select_domain->fetch_assoc())
{
echo '<option value="'.$row_domain['domain'].'">'.$row_domain['domain'].'</option>';
}
?>
</select>
</div>
 
		<div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Name</th>
                      <th>Email/Username</th>
                       <th>Mobile No</th>
                       <th>Parking Place</th>
                      <th>Address</th>

 			                 
                      <th>Status</th>
                      <th>Activation Date</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php

          $select_query = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor' ORDER BY id DESC");
          while($row=$select_query->fetch_assoc())
          {  ?>
                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['first_name'].' '.$row['last_name']; ?></td>
                      <td title="<?php echo $row['user_pass']; ?>"><?php echo $row['user_email']; ?></td>
                       <td><?php echo $row['mobile_number']; ?></td>
                       <td><?php echo $row['parking_name']; ?></td>

                         <td><?php echo $row['address']; ?> <?php echo $row['city']; ?> <?php echo $row['state']; ?></td>

                       <td><?php 
                        if($row['user_status']==1){ ?>
                           <a class="" title="Deactivate" href="user-status.php?user_id=<?php echo $row['id'];?>&status=0&return=all-users.php"><i class="icon-remove" style="color: red;"></i> </a>
                        <?php } else { ?>
                           <a class="" title="Activate" href="user-status.php?user_id=<?php echo $row['id'];?>&status=1&return=all-users.php"><i class="icon-check" style="color: green;"></i> </a>
                        <?php } ?> &nbsp;&nbsp;</td>
                         <td><?php echo $row['register_date']; ?></td>
                      <td class="center" id="user-action-<?php echo $row['id'];?>"> 

                         <a class="" title="View Parking History" href="all-entity.php?vendor_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="material-icons" style="font-size: 15px;">local_car_wash</i> </a>&nbsp;&nbsp;

                      	 <a class="" title="View Vendor Details" href="user-details.php?user_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="icon-eye-open"></i> </a>&nbsp;&nbsp;

              <a class="edit-user-ajax" data-toggle="modal" data-target="#myModaluser" title="Edit" href="javascript:void(0)" id="<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp;
              
             <!--  <a class="delete-user-ajax" title="Delete" href="javascript:void(0)" id="<?php echo $row['id'];?>"><i class="icon-remove"></i></a> -->
              <a class="delete-user-ajax" title="Delete" href="javascript:void(0)" id="<?php echo $row['id'];?>"><i class="icon-trash"></i></a>&nbsp;&nbsp;

              <a class="" title="Qr Code" href="../vendor/genrate-qr-code.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="icon-qrcode"></i></a>
                   
            </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  
                </table>
           </div>
 <!-- Modal -->
<div id="myModaluser" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 60%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Vendor</h4>
      </div>
      <div class="modal-body" id="user-edit-frm">
       
      </div>
       
    </div>

  </div>
</div>


              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end--> 
    </section>
  </section>
  
 

  <!--main content end-->
  <?php include 'footer.php' ?>