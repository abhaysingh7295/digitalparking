<?php include 'header.php';

$user_id = $_GET['user_id'];


$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
  $row=$select_query->fetch_assoc(); 


$face_info_query = $con->query("SELECT * FROM `face_info` where user_id = '".$user_id."'");
  $face_info_row=$face_info_query->fetch_assoc(); 


$select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
$place_info_row = $select_place->fetch_assoc();


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
              <div class="row"> <h4> Fare Information: </h4>
              
             
              <div class="col-md-6">
                   
                 <header class="panel-heading"> Hourly </header>
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Two Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['h_two_wheeler']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Three Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['h_three_wheeler']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Four Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['h_four_wheeler']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Extra Amount</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['h_extra_amount']; ?>
                  </div>
                </div>
                  </div>
                  <div class="col-md-6">
                    <header class="panel-heading"> Days </header>

                   <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Two Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['d_two_wheeler']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Three Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['d_three_wheeler']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-4">Four Wheeler</label>
                  <div class="col-lg-8">
                    <?php echo $face_info_row['d_four_wheeler']; ?>
                  </div>
                </div>
                  </div>
               
                  </div>
                
                   

                </hr>

                <br>
                <div class="row">
                  <h4> Place Information: </h4>
                
                
                 <div class="col-md-6">
                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Area</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['area']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Landmark</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['landmark']; ?>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">City</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['city']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">State</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['state']; ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Country</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['country']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Pin Code</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['pincode']; ?>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Parking Capacity (Two Wheeler)</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['parking_capacity_2']; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="first_name" class="control-label  col-lg-4">Parking Capacity (Three/Four Wheeler)</label>
                  <div class="col-lg-8">
                    <?php echo $place_info_row['parking_capacity_3_4']; ?>
                  </div>
                </div>

              </div>
              </div>
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