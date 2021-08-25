<?php include 'header.php';

$user_id = $_GET['user_id'];


$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."' AND user_role = 'vandor'");
 

$numrows_vendor = $select_query->num_rows;
if($numrows_vendor==0) {
	header('location:all-users.php');
	exit();
}

$row=$select_query->fetch_assoc();
$vendor_id = $user_id;

$select_qr = $con->query("SELECT * FROM `vendor_qr_codes` Where vendor_id='".$vendor_id."'");

$row_qr=$select_qr->fetch_assoc();

?>
<!--main content start-->

<section id="main-content">
  <section class="wrapper"> 
    <!-- page start-->
    
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading"> Vendor Details </header>
          <div class="panel-body">
            <div class="form">
             
            
            <form class="cmxform form-horizontal tasi-form" id="edit-user-submit" method="post" action="" enctype="multipart/form-data">
              <h4> Personal Details: </h4>
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">First Name</label>
                  <div class="col-lg-10">
                    <?php echo $row['first_name']; ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Last Name</label>
                  <div class="col-lg-10">
                    <?php echo $row['last_name']; ?>
                  </div>
                </div>
                
               
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email/Username</label>
                  <div class="col-lg-10">
                    <?php echo $row['user_email']; ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Profile Image</label>
                  <div class="col-lg-10">
                      <?php if($row['profile_image']) { ?>
                    <div style="width: 40%;" class="fileupload-new thumbnail"> <a href="<?php echo '../vendor/'.$row['profile_image']; ?>" target="_blank"><img style="width: 100%;" alt="" src="<?php echo '../vendor/'.$row['profile_image']; ?>"></a> </div>
                    <?php } else {?>
                    -- No Image --
                    <?php }?>
                  </div>
                </div>
                
                 <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Adhar Card Image</label>
                  <div class="col-lg-10">
                      <?php if($row['adhar_image']) { ?>
                    <div style="width: 40%;" class="fileupload-new thumbnail"> <a href="<?php echo '../vendor/'.$row['adhar_image']; ?>" target="_blank"><img style="width: 100%;" alt="" src="<?php echo '../vendor/'.$row['adhar_image']; ?>"></a> </div>
                    <?php } else {?>
                    -- No Image --
                    <?php }?>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Pan Card Image</label>
                  <div class="col-lg-10">
                      <?php if($row['pan_card_image']) { ?>
                    <div style="width: 40%;" class="fileupload-new thumbnail"> <a href="<?php echo '../vendor/'.$row['pan_card_image']; ?>" target="_blank"><img style="width: 100%;" alt="" src="<?php echo '../vendor/'.$row['pan_card_image']; ?>"></a> </div>
                    <?php } else {?>
                    -- No Image --
                    <?php }?>
                  </div>
                </div>
                
            </hr>
            <?php $QR_FILE_DIR = '../qrcodes/'.$vendor_id.'/'.$row_qr['qr_code'].'.png';
				if(file_exists($QR_FILE_DIR)){ ?>
				      <div class="row">
				    <div class="col-md-12"> 
				      <img src="<?php echo $QR_FILE_DIR; ?>" width="200" />
				    </div>
				    </div>
				<?php } ?>

		         </hr>
              <div class="row"> 
              
              <div class="col-md-12">
              	<h4> Fare Information: </h4>
                   
                 <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="example" data-page-length="100">
                  <thead>
                    <tr>
                      <th>Initial Hour</th>
                      <th>Ending Hour</th>
                       <th>Amount</th>
 			                <th>Fare Status</th>
                      <th>Vehicle Type</th>
                      
                      <!-- <th class="">Action</th> -->
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php

$select_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." ORDER BY hr_status DESC");
			while($row=$select_query->fetch_assoc())
			{
?>
                    <tr class="gradeX" id="fare-<?php echo $row['id'];?>">
                      <td><?php echo $row['initial_hr']; ?></td>
                      <td><?php echo $row['ending_hr']; ?></td>
                       <td><?php echo $row['amount']; ?></td>
 		        	<td><?php echo $row['hr_status']; ?></td>
              <td><?php echo $row['veh_type']; ?></td>
                     
              <!-- <td class="center" id="user-fare-<?php echo $row['id'];?>"> 

                       
              <a title="Edit" href="add-fare-info.php?edit=<?php echo $row['id'];?>"><i class="icon-edit"></i></a>&nbsp;&nbsp;
              
              <a title="Delete" href="fare-info.php?id=<?php echo $row['id'];?>" ><i class="icon-remove"></i></a>
                   
            </td> -->
                    </tr>
                    <?php } ?>
                  </tbody>
                  
                </table>
           </div>


                  </div>
                 
               
                  </div>
                
                   

                </hr>

                <br>
                 
               </form>
               
             
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</section>
<!--main content end-->
<?php include 'footer.php' ?>