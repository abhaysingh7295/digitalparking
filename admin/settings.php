<?php  include 'header.php';

$settings_id = 1;
  
 if(isset($_POST['submit']))
 {
	 
	 $site_name = $_POST['site_name'];
	 $site_url = $_POST['site_url'];
	 $site_description = $_POST['site_description'];
	 $contact_email = $_POST['contact_email'];
	 $contact_number = $_POST['contact_number'];
	 $address = $_POST['address'];
	 $facebook_url = $_POST['facebook_url'];
	 $twitter_url = $_POST['twitter_url'];
	 $linkedin_url = $_POST['linkedin_url'];
	 $google_url = $_POST['google_url'];
	 $youtube_url = $_POST['youtube_url'];

	 $admin_commission = $_POST['admin_commission'];
	 
	 
	 
	 
	 $favicon_logo = $_FILES['favicon_logo']['name'];
	 $path_favicon = "upload/" .$favicon_logo ;
	 
	$newpicture = $_FILES['file']['name'];
	$path = "upload/" .$newpicture ;
	
	$new_dashboard_logo = $_FILES['dashboard_logo']['name'];
	$path_dashboard_logo = "upload/" .$new_dashboard_logo ;
	
	if(($newpicture) && ($favicon_logo) && ($new_dashboard_logo) ){
	
	 if((($_FILES['file']['type'] == 'image/gif')
     || ($_FILES['file']['type'] == 'image/jpeg')
	 || ($_FILES['file']['type'] == 'image/jpg')
	 || ($_FILES['file']['type'] == 'image/png')
	 && ($_FILES['file']['size'] < 200000)) 
	 && (($_FILES['favicon_logo']['type'] == 'image/gif')
     || ($_FILES['favicon_logo']['type'] == 'image/jpeg')
	 || ($_FILES['favicon_logo']['type'] == 'image/jpg')
	 || ($_FILES['favicon_logo']['type'] == 'image/png')
	 && ($_FILES['favicon_logo']['size'] < 200000)) 
	 && (($_FILES['dashboard_logo']['type'] == 'image/gif')
     || ($_FILES['dashboard_logo']['type'] == 'image/jpeg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/jpg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/png')
	 && ($_FILES['dashboard_logo']['size'] < 200000)))
	 {  
	    if($_FILES['file']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
			
			} else if($_FILES['favicon_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['favicon_logo']['error']."')</script>";
			
			}  else if($_FILES['dashboard_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['dashboard_logo']['error']."')</script>";
			
			}
			
			else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name'])) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name'])))) ;
	
		{
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',dashboard_logo = '".$path_dashboard_logo."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 
		
	} 
	
	else if(($newpicture) && ($favicon_logo)){
		
		
	 if((($_FILES['file']['type'] == 'image/gif')
     || ($_FILES['file']['type'] == 'image/jpeg')
	 || ($_FILES['file']['type'] == 'image/jpg')
	 || ($_FILES['file']['type'] == 'image/png')
	 && ($_FILES['file']['size'] < 200000)) && (($_FILES['favicon_logo']['type'] == 'image/gif')
     || ($_FILES['favicon_logo']['type'] == 'image/jpeg')
	 || ($_FILES['favicon_logo']['type'] == 'image/jpg')
	 || ($_FILES['favicon_logo']['type'] == 'image/png')
	 && ($_FILES['favicon_logo']['size'] < 200000)))
	 {  
	    if($_FILES['file']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
			
			} else if($_FILES['favicon_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['favicon_logo']['error']."')</script>";
			
			} else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name'])))) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 
		
	}
	
	else if(($newpicture) && ($new_dashboard_logo)){
		
		
	 if((($_FILES['file']['type'] == 'image/gif')
     || ($_FILES['file']['type'] == 'image/jpeg')
	 || ($_FILES['file']['type'] == 'image/jpg')
	 || ($_FILES['file']['type'] == 'image/png')
	 && ($_FILES['file']['size'] < 200000)) 
	 && (($_FILES['dashboard_logo']['type'] == 'image/gif')
     || ($_FILES['dashboard_logo']['type'] == 'image/jpeg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/jpg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/png')
	 && ($_FILES['dashboard_logo']['size'] < 200000)))
	 {  
	    if($_FILES['file']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
			
			} else if($_FILES['dashboard_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['dashboard_logo']['error']."')</script>";
			
			} else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name'])))) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 
		
	}
	
	else if(($favicon_logo) && ($new_dashboard_logo)){
		
		
	 if((($_FILES['favicon_logo']['type'] == 'image/gif')
     || ($_FILES['favicon_logo']['type'] == 'image/jpeg')
	 || ($_FILES['favicon_logo']['type'] == 'image/jpg')
	 || ($_FILES['favicon_logo']['type'] == 'image/png')
	 && ($_FILES['favicon_logo']['size'] < 200000)) 
	 && (($_FILES['dashboard_logo']['type'] == 'image/gif')
     || ($_FILES['dashboard_logo']['type'] == 'image/jpeg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/jpg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/png')
	 && ($_FILES['dashboard_logo']['size'] < 200000)))
	 {  
	    if($_FILES['favicon_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['favicon_logo']['error']."')</script>";
			
			} else if($_FILES['dashboard_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['dashboard_logo']['error']."')</script>";
			
			} else if((move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name']) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name'])))) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',favicon_logo = '".$path_favicon."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 
		
	}
	
	else if($newpicture)  {
		 if(($_FILES['file']['type'] == 'image/gif')
     || ($_FILES['file']['type'] == 'image/jpeg')
	 || ($_FILES['file']['type'] == 'image/jpg')
	 || ($_FILES['file']['type'] == 'image/png')
	 && ($_FILES['file']['size'] < 200000))
	 {  
	    if($_FILES['file']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
			
			} else if(move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name'])) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 } else if($new_dashboard_logo)  {
		 if(($_FILES['dashboard_logo']['type'] == 'image/gif')
     || ($_FILES['dashboard_logo']['type'] == 'image/jpeg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/jpg')
	 || ($_FILES['dashboard_logo']['type'] == 'image/png')
	 && ($_FILES['dashboard_logo']['size'] < 200000))
	 {  
	    if($_FILES['dashboard_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['dashboard_logo']['error']."')</script>";
			
			} else if(move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name'])) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	 }
	
	 else if($favicon_logo) {
		
	 if(($_FILES['favicon_logo']['type'] == 'image/gif')
     || ($_FILES['favicon_logo']['type'] == 'image/jpeg')
	 || ($_FILES['favicon_logo']['type'] == 'image/jpg')
	 || ($_FILES['favicon_logo']['type'] == 'image/png')
	 && ($_FILES['favicon_logo']['size'] < 200000))
	 {  
	    if($_FILES['favicon_logo']['error'] > 0)
		{   
		   echo "<script>alert('Return'".$_FILES['favicon_logo']['error']."')</script>";
			
			} else if(move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name'])) ;
	
		{
					
					//unlink($picture);
					$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
					
		 }
		 
	 } 
	  
		}
	 else {
		$aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',	contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
		
		 }
		 
		// echo $aqledit; die; 
		$ress = $con->query($aqledit);
			 if($ress){
			 header('location:settings.php');
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
          <header class="panel-heading"> Edit Site Settings </header>
          <div class="panel-body">
            <div class="form">
  <?php 
  // $select_query = $con->query("select * from `settings` where id = '1'");
	//$query = $con->query($sql);
	//$row=$select_query->fetch_assoc();
	
if($site_settings_row['logo']==''){
$rowlogo = 'http://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';	
} else {
$rowlogo = $site_settings_row['logo'];
}
if($site_settings_row['dashboard_logo']==''){
$rowdashboard = 'http://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';	
} else {
$rowdashboard = $site_settings_row['dashboard_logo'];
}

if($site_settings_row['favicon_logo']==''){
$favicon = 'http://www.placehold.it/80x80/EFEFEF/AAAAAA&text=no+image';	
} else {
$favicon = $site_settings_row['favicon_logo'];
}	
	?>
              <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group ">
                  <label for="title" class="control-label col-lg-2">Site Title</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="site_name" name="site_name" type="text" value="<?php echo $site_settings_row['site_name'] ?>" required/>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="site_url" class="control-label col-lg-2">Site URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="site_url" name="site_url" type="url" value="<?php echo $site_settings_row['site_url'] ?>" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label col-sm-2">Site Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="site_description" rows="6"><?php echo $site_settings_row['site_description'] ?></textarea>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="contact_email" class="control-label col-lg-2">Contact Email</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="contact_email" name="contact_email" type="email" value="<?php echo $site_settings_row['contact_email'] ?>" required />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="contact_number" class="control-label col-lg-2">Contact Number</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="contact_number" name="contact_number" type="text" value="<?php echo $site_settings_row['contact_number'] ?>" required />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="address" class="control-label col-lg-2">Address</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="address" name="address" type="text" value="<?php echo $site_settings_row['address'] ?>" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="facebook_url" class="control-label col-lg-2">Facebook URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="facebook_url" name="facebook_url" type="url" value="<?php echo $site_settings_row['facebook_url'] ?>" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="twitter_url" class="control-label col-lg-2">Twitter URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="twitter_url" name="twitter_url" type="url" value="<?php echo $site_settings_row['twitter_url'] ?>" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="linkedin_url" class="control-label col-lg-2">Linkedin URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="linkedin_url" name="linkedin_url" type="url" value="<?php echo $site_settings_row['linkedin_url'] ?>" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="google_url" class="control-label col-lg-2">Google Plus URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="google_url" name="google_url" type="url" value="<?php echo $site_settings_row['google_url'] ?>" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="youtube_url" class="control-label col-lg-2">Youtube URL</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="youtube_url" name="youtube_url" type="url" value="<?php echo $site_settings_row['youtube_url'] ?>" />
                  </div>
                </div>
                <div class="form-group last">
                  <label class="control-label col-md-2">Logo Upload</label>
                  <div class="col-md-10">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                      <div style="" class="fileupload-new thumbnail"> <img alt="" src="<?php echo $rowlogo;  ?>"> </div>
                      <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                      <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                        <input type="file" class="default" name="file">
                        </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                    </div>
                    <span class="label label-danger">NOTE!</span> <span> Only view in Froend  </span> </div>
                </div>
                
                <div class="form-group last">
                  <label class="control-label col-md-2">Dashboard Logo Upload</label>
                  <div class="col-md-10">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                      <div style="" class="fileupload-new thumbnail"> <img alt="" src="<?php echo $rowdashboard;  ?>"> </div>
                      <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                      <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                        <input type="file" class="default" name="dashboard_logo">
                        </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                    </div>
                    <span class="label label-danger">NOTE!</span> <span> Only view in Dashboard </span> </div>
                </div>
                
                <div class="form-group last">
                  <label class="control-label col-md-2">Favicon Logo</label>
                  <div class="col-md-10">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                      <div style="" class="fileupload-new thumbnail"> <img alt="" src="<?php echo $favicon;  ?>"> </div>
                      <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                      <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                        <input type="file" class="default" name="favicon_logo">
                        </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                    </div>
                  </div>
                </div>

                <div class="form-group ">
                  <label for="admin_commission" class="control-label col-lg-2">Commission (%)</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="admin_commission" name="admin_commission" type="number" value="<?php echo $site_settings_row['admin_commission'] ?>" min="0" max="100" />
                  </div>
                </div>


                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-danger" type="submit" name="submit">Update Settings</button>
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
<?php include 'footer.php'; ?>