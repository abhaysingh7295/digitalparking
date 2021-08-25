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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $admin_login_row['display_name']; ?>" id="display_name" name="display_name">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username <br><small>(Not Changeable)</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" readonly="readonly" value="<?php echo $admin_login_row['User_name']; ?>" id="User_name" name="User_name">
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="email" id="Email" name="Email" type="email" value="<?php echo $admin_login_row['Email']; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                        <input name="profile_image" type="file">

                                        <img style="width: 10%;" alt="<?php echo $admin_login_row['display_name']; ?>" src="<?php echo $admin_profile_image;  ?>">
                                  
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