<?php include 'header.php'; 

$settings_id = 1; 
if(isset($_POST['update']))
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
            } else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name'])) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name']))))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',dashboard_logo = '".$path_dashboard_logo."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        }
    } else if(($newpicture) && ($favicon_logo)){ 
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
            } else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name']))))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        }
    } else if(($newpicture) && ($new_dashboard_logo)){
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
            } else if((move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name']))))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        } 
    } else if(($favicon_logo) && ($new_dashboard_logo)){
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
            } else if((move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name']) && (move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name']))))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',favicon_logo = '".$path_favicon."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        }
    } else if($newpicture)  {
        if(($_FILES['file']['type'] == 'image/gif')
        || ($_FILES['file']['type'] == 'image/jpeg')
        || ($_FILES['file']['type'] == 'image/jpg')
        || ($_FILES['file']['type'] == 'image/png')
        && ($_FILES['file']['size'] < 200000))
        {  
            if($_FILES['file']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['file']['tmp_name'],'upload/' .$_FILES['file']['name']))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',logo = '".$path."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
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
            } else if(move_uploaded_file($_FILES['dashboard_logo']['tmp_name'],'upload/' .$_FILES['dashboard_logo']['name']))
            {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',dashboard_logo = '".$path_dashboard_logo."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        }
    } else if($favicon_logo) {
        if(($_FILES['favicon_logo']['type'] == 'image/gif')
        || ($_FILES['favicon_logo']['type'] == 'image/jpeg')
        || ($_FILES['favicon_logo']['type'] == 'image/jpg')
        || ($_FILES['favicon_logo']['type'] == 'image/png')
        && ($_FILES['favicon_logo']['size'] < 200000))
        {  
            if($_FILES['favicon_logo']['error'] > 0)
            {   
               echo "<script>alert('Return'".$_FILES['favicon_logo']['error']."')</script>";
           } else if(move_uploaded_file($_FILES['favicon_logo']['tmp_name'],'upload/' .$_FILES['favicon_logo']['name']))
           {
                $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."',favicon_logo = '".$path_favicon."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
            }
        }
    } else {
        $aqledit = "update `settings` SET site_name = '".$site_name."',site_url = '".$site_url."', site_description = '".$site_description."',  contact_email = '".$contact_email."', contact_number = '".$contact_number."', address = '".$address."', facebook_url = '".$facebook_url."', twitter_url = '".$twitter_url."', linkedin_url = '".$linkedin_url."', google_url = '".$google_url."', youtube_url = '".$youtube_url."', admin_commission = ".$admin_commission." where id = '".$settings_id."'";
    }
    $ress = $con->query($aqledit);
    if($ress){
        header('location:settings.php');
    } 
 } 

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

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Settings</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
 						<form class="" id="signupForm" method="post" action="" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Site Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="site_name" name="site_name" type="text" value="<?php echo $site_settings_row['site_name'] ?>" required/>
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Site URL</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="site_url" name="site_url" type="url" value="<?php echo $site_settings_row['site_url'] ?>" required/>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Site Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="site_description" rows="6"><?php echo $site_settings_row['site_description'] ?></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Contact Email</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="contact_email" name="contact_email" type="email" value="<?php echo $site_settings_row['contact_email'] ?>" required />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Contact Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="contact_number" name="contact_number" type="text" value="<?php echo $site_settings_row['contact_number'] ?>" required />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="address" name="address" type="text" value="<?php echo $site_settings_row['address'] ?>" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Facebook URL</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="facebook_url" name="facebook_url" type="url" value="<?php echo $site_settings_row['facebook_url'] ?>" />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Twitter URL</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="twitter_url" name="twitter_url" type="url" value="<?php echo $site_settings_row['twitter_url'] ?>" />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Linkedin URL</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="linkedin_url" name="linkedin_url" type="url" value="<?php echo $site_settings_row['linkedin_url'] ?>" />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Google Plus URL</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="google_url" name="google_url" type="url" value="<?php echo $site_settings_row['google_url'] ?>" />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Youtube URL</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="youtube_url" name="youtube_url" type="url" value="<?php echo $site_settings_row['youtube_url'] ?>" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Logo Upload</label>
                                <div class="col-sm-10">
                                        <input name="file" type="file">
                                        <img style="width: 10%;" src="<?php echo $rowlogo;  ?>">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Dashboard Logo Upload</label>
                                <div class="col-sm-10">
                                        <input name="dashboard_logo" type="file">
                                        <img style="width: 10%;" src="<?php echo $rowdashboard;  ?>">
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Favicon</label>
                                <div class="col-sm-10">
                                        <input name="favicon_logo" type="file">
                                        <img style="width: 10%;" src="<?php echo $favicon;  ?>">
                                </div>
                            </div>



                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Commission (%)</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="admin_commission" name="admin_commission" type="text" value="<?php echo $site_settings_row['admin_commission'] ?>" required />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-danger" type="submit" name="update">Update</button>
                                </div>
                            </div>
                             </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>


     



<?php include 'footer.php'; ?>