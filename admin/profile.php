<?php include 'header.php';

 if(isset($_POST['update']))
 {
$display_name = $_POST['display_name'];
$Email = $_POST['Email'];
$new_profile_image = $_FILES['profile_image']['name'];
$path_profile_image = "upload/" .$new_profile_image;

if($new_profile_image)  {
 if(($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png') )
	 {  
	    if($_FILES['profile_image']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['profile_image']['error']."')</script>";
			
			} else if(move_uploaded_file($_FILES['profile_image']['tmp_name'],'upload/' .$_FILES['profile_image']['name'])) ;
	
		{
			
        unlink($admin_login_row['profile_image']);	
	
	$aqled = "update `login` SET display_name = '".$display_name."', Email = '".$Email."', profile_image = '".$path_profile_image."' where Id = '".$current_user_id."'";
			
					
		 }
		 
	 } 
   } else {
	$aqled = "update `login` SET display_name = '".$display_name."', Email = '".$Email."' where Id = '".$current_user_id."'";
   }
 
	 $ress = $con->query($aqled);
	 if($ress){
		header('location:profile.php');
	 }
}
?>
 
<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            Edit Profile
                          </header>
                          <div class="panel-body">
                              <div class="form">
                               <?php if(isset($error)) {
				echo '<p style="color:red">'.$error.'</p>';
				} ?>
                
 
                         
           <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Display Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="display_name" name="display_name" type="text" value="<?php echo $admin_login_row['display_name']; ?>" />
                  </div>
                </div>
                
                
               
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Username <br><small>(Not Changeable)</small></label>
                  <div class="col-lg-10">
                    <input class="form-control" id="User_name" name="User_name" type="text" readonly="readonly" value="<?php echo $admin_login_row['User_name']; ?>" />
                  </div>
                </div>
                 <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="Email" name="Email" type="email" value="<?php echo $admin_login_row['Email']; ?>" />
                  </div>
                </div>
                               
                 <div class="form-group last">
                  <label class="control-label col-md-2">Profile Image</label>
                  <div class="col-md-10">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                      <div style="" class="fileupload-new thumbnail"> <img alt="" src="<?php echo $admin_profile_image;  ?>"> </div>
                      <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                      <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                        <input type="file" class="default" name="profile_image">
                        </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                    </div>
                    </div>
                </div>
                             
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-danger" type="submit" name="update">Update</button>
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