<?php include 'header.php'; 

 if(isset($_POST['update']))
 {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $Email = $_POST['Email'];
    $parking_name = $_POST['parking_name'];
    $parking_type = $_POST['parking_type'];
    $parking_address = $_POST['parking_address'];
    $parking_state = $_POST['parking_state'];
    $parking_city = $_POST['parking_city'];
    $parking_capacity = $_POST['parking_capacity'];
    $online_booking_capacity = $_POST['online_booking_capacity'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $new_profile_image = $_FILES['profile_image']['name'];
    $path_profile_image = "upload/" .$new_profile_image;




    $new_parking_logo = $_FILES['parking_logo']['name'];
    $path_parking_logo = "upload/" .$new_parking_logo;


    $new_adhar_image = $_FILES['adhar_image']['name'];
    $path_adhar_image = "upload/" .$new_adhar_image;
    $new_pan_card_image = $_FILES['pan_card_image']['name'];
    $path_pan_card_image = "upload/" .$new_pan_card_image;

 
    $aqled = $con->query("update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', open_time = '".$open_time."', close_time = '".$close_time."',  mobile_number = '".$mobile_number."', parking_name = '".$parking_name."', parking_type = '".$parking_type."', address = '".$parking_address."', state = '".$parking_state."', city = '".$parking_city."', parking_capacity = '".$parking_capacity."', online_booking_capacity = '".$online_booking_capacity."' where id = '".$current_user_id."'");


    if($new_profile_image)  {
        if(($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png') )
        {
            if($_FILES['profile_image']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['profile_image']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['profile_image']['tmp_name'],'upload/' .$_FILES['profile_image']['name']))
            {
                unlink($admin_login_row['profile_image']);  
               $con->query("update `pa_users` SET profile_image = '".$path_profile_image."' where id = '".$current_user_id."'");
            }
        }
    }  
     
    if($new_parking_logo)  {
        if(($_FILES['parking_logo']['type'] == 'image/gif') || ($_FILES['parking_logo']['type'] == 'image/jpeg') || ($_FILES['parking_logo']['type'] == 'image/jpg') || ($_FILES['parking_logo']['type'] == 'image/png') )
        {
            if($_FILES['parking_logo']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['parking_logo']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['parking_logo']['tmp_name'],'upload/' .$_FILES['parking_logo']['name']))
            {
                unlink($admin_login_row['parking_logo']);
                $aqled = $con->query("update `pa_users` SET parking_logo = '".$path_parking_logo."' where id = '".$current_user_id."'");
            }
        }
    }
    
   
        if(($_FILES['adhar_image']['type'] == 'image/gif') || ($_FILES['adhar_image']['type'] == 'image/jpeg') || ($_FILES['adhar_image']['type'] == 'image/jpg') || ($_FILES['adhar_image']['type'] == 'image/png') ) {
            if($_FILES['adhar_image']['error'] > 0) {   
                echo "<script>alert('Return'".$_FILES['adhar_image']['error']."')</script>";            
            } else if(move_uploaded_file($_FILES['adhar_image']['tmp_name'],'upload/' .$_FILES['adhar_image']['name'])) {
                $con->query("update `pa_users` SET adhar_image = '".$path_adhar_image."' where id = '".$current_user_id."'");
            }
        }

        if(($_FILES['pan_card_image']['type'] == 'image/gif') || ($_FILES['pan_card_image']['type'] == 'image/jpeg') || ($_FILES['pan_card_image']['type'] == 'image/jpg') || ($_FILES['pan_card_image']['type'] == 'image/png') ) {
            if($_FILES['pan_card_image']['error'] > 0) {   
                echo "<script>alert('Return'".$_FILES['pan_card_image']['error']."')</script>";         
            } else if(move_uploaded_file($_FILES['pan_card_image']['tmp_name'],'upload/' .$_FILES['pan_card_image']['name'])) {
                $con->query("update `pa_users` SET pan_card_image = '".$path_pan_card_image."' where id = '".$current_user_id."'"); 
            }
        }
        header('location:profile.php');
     
}

if($_GET['latlong']=='yes'){
    if($admin_login_row['address'] && $admin_login_row['state'] && $admin_login_row['city']){
        $completeAddress = $admin_login_row['address'].', '.$admin_login_row['city'].', '.$admin_login_row['state'];
        $getgeoLocate = getgeoLocate($completeAddress);
        if($getgeoLocate['status']==1){
            $latitude = $getgeoLocate['lat'];
            $longitude = $getgeoLocate['long'];
            UpdateUsersLatLong($con,$current_user_id,$latitude,$longitude);
            //$con->query("update `pa_users` SET latitude = '".$latitude."', longitude = '".$longitude."' where id = ".$current_user_id."");

            echo "<script> alert('Latitude / Longitude Updated successfully'); window.location.href = 'profile.php'; </script>";
        } else {
            echo "<script> alert('".$getgeoLocate['message']."'); window.location.href = 'profile.php'; </script>";
        }

    } else {
         echo "<script> alert('Please Complete your address.'); window.location.href = 'profile.php'; </script>";
    }
    

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
                                <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="first_name" name="first_name" type="text" value="<?php echo $admin_login_row['first_name']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="last_name" name="last_name" type="text" value="<?php echo $admin_login_row['last_name']; ?>" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username <br><small>(Not Changeable)</small></label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="user_email" name="user_email" type="text" readonly="readonly" value="<?php echo $admin_login_row['user_email']; ?>" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $admin_login_row['mobile_number']; ?>" <?php if($admin_login_row['mobile_number']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>
                             
 
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                        <input name="profile_image" type="file">
                                        <img style="width: 10%;"src="<?php echo $admin_profile_image;  ?>">
                                </div>
                            </div>

                            <?php if($active_plans_row['vendor_logo']==1){ ?>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Logo</label>
                                <div class="col-sm-10">
                                    <?php if($admin_parking_logo){ ?>  <img style="width: 10%;"src="<?php echo $admin_parking_logo;  ?>"> <?php } else { ?> <input name="parking_logo" type="file"> <?php } ?>
                                </div>
                            </div>
                            <?php } ?>

                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">GST Certificate</label>
                                <div class="col-sm-10">
                                    <?php if($admin_adhar_image){ ?>  <img style="width: 10%;"src="<?php echo $admin_adhar_image;  ?>"> <?php } else { ?> <input name="adhar_image" type="file"> <?php } ?>
                                        
                                       
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Bank Cheque / Statement</label>
                                <div class="col-sm-10">
                                    <?php if($admin_pan_card_image){ ?>  <img style="width: 10%;"src="<?php echo $admin_pan_card_image;  ?>"> <?php } else { ?> <input name="pan_card_image" type="file"> <?php } ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="parking_name" name="parking_name" type="text" value="<?php echo $admin_login_row['parking_name']; ?>" <?php if($admin_login_row['parking_name']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Type</label>
                                <div class="col-sm-10">
                                    <?php if($admin_login_row['parking_type']){ ?>
                                        <input class="form-control" id="parking_type" name="parking_type" type="text" value="<?php echo $admin_login_row['parking_type']; ?>" <?php if($admin_login_row['parking_type']){ echo 'readonly="readonly"';} ?> />
                                <?php } else { ?>
                                    <select class="form-control" id="parking_type" name="parking_type" required="required">
                                        <option value="">Select Parking Types</option>
                                        <?php $select_parking_types = $con->query("SELECT * FROM `parking_types` ORDER BY parking_type_name ASC");
                                        $numrows_parking_types = $select_parking_types->num_rows;
                                        if ($numrows_parking_types > 0) {
                                            $parking_types = array();
                                            while($row=$select_parking_types->fetch_assoc())
                                            { ?>
                                                <option <?php if($admin_login_row['parking_type']==$row['parking_type_name']){ echo 'selected="selected"'; } ?>  value="<?php echo $row['parking_type_name']; ?>"><?php echo $row['parking_type_name']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="parking_address" name="parking_address" type="text" value="<?php echo $admin_login_row['address']; ?>" <?php if($admin_login_row['address']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking State</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_state" name="parking_state" type="text" value="<?php echo $admin_login_row['state']; ?>" <?php if($admin_login_row['state']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking City</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_city" name="parking_city" type="text" value="<?php echo $admin_login_row['city']; ?>" <?php if($admin_login_row['city']){ echo 'readonly="readonly"';} ?> />
                                </div>
                            </div>

                            <?php if($admin_login_row['latitude'] && $admin_login_row['longitude']){ ?>
                                <div class="form-group row">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">Latitude</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="latitude" name="latitude" type="text" value="<?php echo $admin_login_row['latitude']; ?>" readonly="readonly" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">Longitude</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="longitude" name="longitude" type="text" value="<?php echo $admin_login_row['longitude']; ?>" readonly="readonly" />
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Capacity</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_capacity" name="parking_capacity" type="text" value="<?php echo $admin_login_row['parking_capacity']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Pre Booking Capacity</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="online_booking_capacity" name="online_booking_capacity" type="text" value="<?php echo $admin_login_row['online_booking_capacity']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Open Time</label>
                                <div class="col-sm-10">
                                  <input class="form-control" data-date-format="HH:ii P" id="open_time" name="open_time" type="text" value="<?php echo $admin_login_row['open_time']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Close Time</label>
                                <div class="col-sm-10">
                                  <input class="form-control" data-date-format="HH:ii P" id="close_time" name="close_time" type="text" value="<?php echo $admin_login_row['close_time']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                   
                                    <?php if($admin_login_row['latitude']=='' && $admin_login_row['longitude']==''){ ?>
                                        <a href="profile.php?latlong=yes" class="btn btn-danger">Update Latitude / Longitude</a>
                                    <?php } ?>
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