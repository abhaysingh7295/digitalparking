<?php include 'header.php'; 

 if(isset($_POST['update']))
 {
   //  die('dgghgh');
    $first_name = $_POST['first_name'];
    $mobile_number = $_POST['mobile_number'];
    $Email = $_POST['Email'];
    $new_profile_image = $_FILES['profile_image']['name'];
    $path_profile_image = "upload/" .$new_profile_image;



    $aqled = $con->query("update `staff_details` SET staff_name = '".$first_name."', staff_mobile_number = '".$mobile_number."' where staff_id = '".$staff_id."'");


    if($new_profile_image)  {
        if(($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png') )
        {
            if($_FILES['profile_image']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['profile_image']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['profile_image']['tmp_name'],'upload/' .$_FILES['profile_image']['name']))
            {
                unlink($admin_login_row['profile_image']);  
               $con->query("update `staff_details` SET profile_image = '".$path_profile_image."' where staff_id = '".$staff_id."'");
            }
        }
    }  
       
        header('location:profile_staff.php');
     
}


?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>

 <div class="wrapper">
    
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Edit Profile</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label"> Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="first_name" name="first_name" type="text" value="<?php echo $admin_login_row['staff_name']; ?>" />
                                </div>
                            </div>

                            
                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username <br><small>(Not Changeable)</small></label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="user_email" name="user_email" type="text" readonly="readonly" value="<?php echo $admin_login_row['staff_email']; ?>" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $admin_login_row['staff_mobile_number']; ?>" <?php if($admin_login_row['mobile_number']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>
                             
 
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                        <input name="profile_image" type="file">
                                        <img style="width: 10%;"src="<?php echo $admin_profile_image;  ?>">
                                </div>
                            </div>

                           
                            <input class="btn btn-danger" type="submit" value='Update' name="update">
                             </form>

                             


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>
    </body>
</html>


     



<?php include 'footer.php'; ?>