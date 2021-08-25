<?php include 'header.php'; 

if(isset($_POST['submit'])){
    $blocked_time = time();
	$vehicle_number = $_POST['vehicle_number'];
	$insert_query = $con->query("SET NAMES utf8");
		$insert_query = "INSERT INTO block_vehicles(vendor_id,vehicle_number,blocked_time) VALUES('$current_user_id','$vehicle_number','$blocked_time')";
	if ($con->query($insert_query) === TRUE) {
		header('location:block-vehicles.php');
	} else {
		$error = 'Some Issue';
	}
}

	$submitBtn = 'Submit';
	$heading = 'Add Block Vehicle';
 

?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title"><?php echo $heading; ?></h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $heading; ?></li>
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
                                    <input class="form-control" id="vehicle_number" name="vehicle_number" type="text"  />
                                </div>
                            </div>

 

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit"><?php echo $submitBtn; ?></button>
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



 <!--main content end-->
<?php include 'footer.php' ?>