<?php include 'header.php'; 

$id = $_REQUEST["id"];
$user_id = $_REQUEST["user_id"];

$select_customer_vehicle_query = $con->query("SELECT * FROM `customer_vehicle` where id = ".$id." AND customer_id=".$user_id."");
$vehicle_row=$select_customer_vehicle_query->fetch_assoc(); 

if($vehicle_row['vehicle_photo']==''){
    $vehicle_photo = '';   
} else {
    $vehicle_photo = $vehicle_row['vehicle_photo'];
}

if($vehicle_row['vehicle_rc']==''){
    $vehicle_rc = ''; 
} else {
    $vehicle_rc = $vehicle_row['vehicle_rc'];
}
 
 if(isset($_POST['update']))
 {
    $id = $_POST['id'];

    $new_vehicle_photo = $_FILES['vehicle_photo']['name'];
    $vehicle_photo_ext = pathinfo($_FILES['vehicle_photo']['name'], PATHINFO_EXTENSION);
    $new_vehicle_name = time().".".$vehicle_photo_ext;


    $new_vehicle_rc = $_FILES['vehicle_rc']['name'];
    $vehicle_rc_ext = pathinfo($_FILES['vehicle_rc']['name'], PATHINFO_EXTENSION);
    $new_vehicle_rc_name = time().".".$vehicle_rc_ext;



    $path_vehicle_rc = "upload/" .$new_vehicle_rc;
 
    if($new_vehicle_photo)  {
        if(($_FILES['vehicle_photo']['type'] == 'image/gif') || ($_FILES['vehicle_photo']['type'] == 'image/jpeg') || ($_FILES['vehicle_photo']['type'] == 'image/jpg') || ($_FILES['vehicle_photo']['type'] == 'image/png') )
        {
            if($_FILES['vehicle_photo']['error'] > 0)
            {   
                echo "<script>alert('Return'".$_FILES['vehicle_photo']['error']."')</script>";
            } else if(move_uploaded_file($_FILES['vehicle_photo']['tmp_name'],'../uploads/'.$new_vehicle_name))
            {
                unlink($vehicle_row['vehicle_photo']);  
                $con->query("update `customer_vehicle` SET vehicle_photo = '".$new_vehicle_name."' where id = '".$id."'");
            }
        }
    }  

   
    if(($_FILES['vehicle_rc']['type'] == 'image/gif') || ($_FILES['vehicle_rc']['type'] == 'image/jpeg') || ($_FILES['vehicle_rc']['type'] == 'image/jpg') || ($_FILES['vehicle_rc']['type'] == 'image/png') ) {
        if($_FILES['vehicle_rc']['error'] > 0) {   
            echo "<script>alert('Return'".$_FILES['vehicle_rc']['error']."')</script>";            
        } else if(move_uploaded_file($_FILES['vehicle_rc']['tmp_name'],'../uploads/' .$new_vehicle_rc_name)) {
            $con->query("update `customer_vehicle` SET vehicle_rc = '".$new_vehicle_rc_name."' where id = '".$id."'");
        }
    }

 
        
    header('location:customer-vehicle.php?user_id='.$user_id);
     
}
?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Edit Vehicle</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Edit Vehicle</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="vehicle_number" name="vehicle_number" type="text" value="<?php echo $vehicle_row['vehicle_number']; ?>" readonly="readonly"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Type</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="vehicle_type" name="vehicle_type" type="text" value="<?php echo $vehicle_row['vehicle_type']; ?>" readonly="readonly"/>
                                </div>
                            </div>
                             
 
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Vehicle Photo</label>
                                <div class="col-sm-10">
                                        <input name="vehicle_photo" type="file">
                                        <?php if($vehicle_photo){ ?>
                                            <img style="width: 10%;"src="<?php echo '../uploads/'.$vehicle_photo;  ?>">
                                        <?php } ?>
                                </div>
                            </div>

                            

                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Vehicle RC</label>
                                <div class="col-sm-10">
                                    <input name="vehicle_rc" type="file">
                                 <?php if($vehicle_rc){ ?>  <img style="width: 10%;"src="<?php echo '../uploads/'.$vehicle_rc; ?>"> <?php } ?>
                                        
                                       
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="id" value="<?php echo $id; ?>" />
                                    <input class="form-control" type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
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