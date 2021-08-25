<?php include 'header.php'; 

$vendor_id = $_GET["user_id"];

$select_current_user_query = $con->query("SELECT * FROM `pa_users` where id = '".$vendor_id."'");
$vendor_row=$select_current_user_query->fetch_assoc(); 

if($vendor_row['profile_image']==''){
    $profile_image = 'http://www.placehold.it/150x100/EFEFEF/AAAAAA&text=no+image';   
} else {
    $profile_image = $vendor_row['profile_image'];
}

if($vendor_row['adhar_image']==''){
    $adhar_image = ''; 
} else {
    $adhar_image = $vendor_row['adhar_image'];
}

if($vendor_row['pan_card_image']==''){
    $pan_card_image = ''; 
} else {
    $pan_card_image = $vendor_row['pan_card_image'];
}

if($vendor_row['parking_logo']==''){
    $parking_logo = ''; 
} else {
    $parking_logo = $vendor_row['parking_logo'];
}

 if(isset($_POST['update']))
 {
    $vendor_id = $_POST['vendor_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $user_email = $_POST['user_email'];
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

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    UpdateUsersLatLong($con,$vendor_id,$latitude,$longitude);

   $aqled = "update `pa_users` SET first_name = '".$first_name."', last_name = '".$last_name."', user_email = '".$user_email."', open_time = '".$open_time."', close_time = '".$close_time."',  mobile_number = '".$mobile_number."', parking_name = '".$parking_name."', parking_type = '".$parking_type."', address = '".$parking_address."', state = '".$parking_state."', city = '".$parking_city."', parking_capacity = '".$parking_capacity."', online_booking_capacity = '".$online_booking_capacity."' where id = '".$vendor_id."'";

    $ress = $con->query($aqled);

    if($new_profile_image)  {
        if(($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png') )
        {
            if($_FILES['profile_image']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['profile_image']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['profile_image']['tmp_name'],'upload/' .$_FILES['profile_image']['name']))
            {
                unlink($vendor_row['profile_image']);  
                $con->query("update `pa_users` SET  profile_image = '".$path_profile_image."' where id = '".$vendor_id."'");
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
                unlink($vendor_row['parking_logo']);
                $con->query("update `pa_users` SET parking_logo = '".$path_parking_logo."' where id = '".$vendor_id."'");
            }
        }
    }
   
    if(($_FILES['adhar_image']['type'] == 'image/gif') || ($_FILES['adhar_image']['type'] == 'image/jpeg') || ($_FILES['adhar_image']['type'] == 'image/jpg') || ($_FILES['adhar_image']['type'] == 'image/png') ) {
        if($_FILES['adhar_image']['error'] > 0) {   
            echo "<script>alert('Return'".$_FILES['adhar_image']['error']."')</script>";            
        } else if(move_uploaded_file($_FILES['adhar_image']['tmp_name'],'upload/' .$_FILES['adhar_image']['name'])) {
            $con->query("update `pa_users` SET adhar_image = '".$path_adhar_image."' where id = '".$vendor_id."'");
        }
    }

    if(($_FILES['pan_card_image']['type'] == 'image/gif') || ($_FILES['pan_card_image']['type'] == 'image/jpeg') || ($_FILES['pan_card_image']['type'] == 'image/jpg') || ($_FILES['pan_card_image']['type'] == 'image/png') ) {
        if($_FILES['pan_card_image']['error'] > 0) {   
            echo "<script>alert('Return'".$_FILES['pan_card_image']['error']."')</script>";         
        } else if(move_uploaded_file($_FILES['pan_card_image']['tmp_name'],'upload/' .$_FILES['pan_card_image']['name'])) {
            $con->query("update `pa_users` SET pan_card_image = '".$path_pan_card_image."' where id = '".$vendor_id."'"); 
        }
    }
        
    header('location:user-details.php?user_id='.$vendor_id);
     
}

if($_GET['latlong']=='yes'){
    if($vendor_row['address'] && $vendor_row['state'] && $vendor_row['city']){
        $completeAddress = $vendor_row['address'].', '.$vendor_row['city'].', '.$vendor_row['state'];
        $getgeoLocate = getgeoLocate($completeAddress);
        if($getgeoLocate['status']==1){
            $latitude = $getgeoLocate['lat'];
            $longitude = $getgeoLocate['long'];
            UpdateUsersLatLong($con,$vendor_id,$latitude,$longitude);
            //$con->query("update `pa_users` SET latitude = '".$latitude."', longitude = '".$longitude."' where id = ".$vendor_id."");
            echo "<script> alert('Latitude / Longitude Updated successfully'); window.location.href = 'edit-vendor-details.php?user_id=".$vendor_id."'; </script>";
        } else {
            echo "<script> alert('".$getgeoLocate['message']."'); window.location.href = 'edit-vendor-details.php?user_id=".$vendor_id."'; </script>";
        }

    } else {
         echo "<script> alert('Please Complete your address.'); window.location.href = 'edit-vendor-details.php?user_id=".$vendor_id."'; </script>";
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="first_name" name="first_name" type="text" value="<?php echo $vendor_row['first_name']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="last_name" name="last_name" type="text" value="<?php echo $vendor_row['last_name']; ?>" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username / Email </label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="user_email" name="user_email" type="text" value="<?php echo $vendor_row['user_email']; ?>" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $vendor_row['mobile_number']; ?>" />
                                </div>
                            </div>
                             
 
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                        <input name="profile_image" type="file">
                                        <?php if($profile_image){ ?>
                                            <img style="width: 10%;"src="<?php echo '../vendor/'.$profile_image;  ?>">
                                        <?php } ?>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Logo</label>
                                <div class="col-sm-10">
                                    <input name="parking_logo" type="file"> 
                                    <?php if($parking_logo){ ?>  <img style="width: 10%;"src="<?php echo '../vendor/'.$parking_logo;  ?>"> <?php } ?>
                                </div>
                            </div>
                          

                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">GST Certificate</label>
                                <div class="col-sm-10">
                                    <input name="adhar_image" type="file">
                                 <?php if($adhar_image){ ?>  <img style="width: 10%;"src="<?php echo '../vendor/'.$adhar_image; ?>"> <?php } ?>
                                        
                                       
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Bank Cheque / Statement</label>
                                <div class="col-sm-10">
                                    <input name="pan_card_image" type="file">
                                    <?php if($pan_card_image){ ?>  <img style="width: 10%;"src="<?php echo '../vendor/'.$pan_card_image;  ?>"> <?php } ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="parking_name" name="parking_name" type="text" value="<?php echo $vendor_row['parking_name']; ?>"  />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Type</label>
                                <div class="col-sm-10">

                                    <select class="form-control" id="parking_type" name="parking_type" required="required">
                                        <option value="">Select Parking Types</option>
                                        <?php $select_parking_types = $con->query("SELECT * FROM `parking_types` ORDER BY parking_type_name ASC");
                                        $numrows_parking_types = $select_parking_types->num_rows;
                                        if ($numrows_parking_types > 0) {
                                            $parking_types = array();
                                            while($row=$select_parking_types->fetch_assoc())
                                            { ?>
                                                <option <?php if($vendor_row['parking_type']==$row['parking_type_name']){ echo 'selected="selected"'; } ?>  value="<?php echo $row['parking_type_name']; ?>"><?php echo $row['parking_type_name']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="parking_address" name="parking_address" type="text" value="<?php echo $vendor_row['address']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking State</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_state" name="parking_state" type="text" value="<?php echo $vendor_row['state']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking City</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_city" name="parking_city" type="text" value="<?php echo $vendor_row['city']; ?>" />
                                </div>
                            </div>

                            <?php if($vendor_row['latitude'] && $vendor_row['longitude']){ ?>
                                <div class="form-group row">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">Latitude</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="latitude" name="latitude" type="text" value="<?php echo $vendor_row['latitude']; ?>" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">Longitude</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="longitude" name="longitude" type="text" value="<?php echo $vendor_row['longitude']; ?>" />
                                    </div>
                                </div>
                            <?php }  ?>
                            
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Capacity</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="parking_capacity" name="parking_capacity" type="text" value="<?php echo $vendor_row['parking_capacity']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Pre Booking Capacity</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="online_booking_capacity" name="online_booking_capacity" type="text" value="<?php echo $vendor_row['online_booking_capacity']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Open Time</label>
                                <div class="col-sm-10">
                                  <input class="form-control" data-date-format="HH:ii P" id="open_time" name="open_time" type="text" value="<?php echo $vendor_row['open_time']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parking Close Time</label>
                                <div class="col-sm-10">
                                  <input class="form-control" data-date-format="HH:ii P" id="close_time" name="close_time" type="text" value="<?php echo $vendor_row['close_time']; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>" />
                                    <button class="btn btn-danger" type="submit" name="update">Update</button>
                                    <?php  //if($vendor_row['latitude']=='' && $vendor_row['longitude']==''){ ?>
                                        <a href="edit-vendor-details.php?user_id=<?php echo $vendor_id; ?>&latlong=yes" class="btn btn-danger">Update Latitude / Longitude</a>
                                    <?php //}  ?>
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