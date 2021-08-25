<?php include 'header.php'; 

$id = $_REQUEST['edit'];

if(isset($_POST['submit'])){
	$eid = $_POST['id'];
	$initial_hr = $_POST['initial_hr'];
	$ending_hr = $_POST['ending_hr'];
	$amount = $_POST['amount'];
	$hr_status = $_POST['hr_status'];
	$veh_type = $_POST['veh_type'];
	$insert_query = $con->query("SET NAMES utf8");
	if($eid){
		$insert_query = "update `fare_info` SET initial_hr = '".$initial_hr."', amount = '".$amount."', ending_hr = '".$ending_hr."', veh_type = '".$veh_type."', hr_status = '".$hr_status."' where id = ".$eid;
	} else {
		$insert_query = "INSERT INTO fare_info(user_id,initial_hr,amount,ending_hr,veh_type,hr_status) VALUES('$current_user_id','$initial_hr','$amount','$ending_hr','$veh_type','$hr_status')";
	}

	if ($con->query($insert_query) === TRUE) {
		header('location:fare-info.php');
	} else {
		$error = 'Some Issue';
	}
}

if($id){
	$select_query = $con->query("SELECT * FROM `fare_info` WHERE id = ".$id."");
	$row=$select_query->fetch_assoc();
	$editid = $id;
	$initial_hr = $row['initial_hr'];
	$ending_hr = $row['ending_hr'];
	$amount = $row['amount'];
	$hr_status = $row['hr_status'];
	$veh_type = $row['veh_type'];
	$submitBtn = 'Update';
	$heading = 'Update Fare Info';
} else {
	$editid = '';
	$initial_hr = '';
	$ending_hr = '';
	$amount = '';
	$hr_status = '';
	$veh_type = '';
	$submitBtn = 'Submit';
	$heading = 'Add Fare Info';
}

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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Initial Hou</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="initial_hr" name="initial_hr" type="text" value="<?php echo $initial_hr; ?>" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Ending Hour</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="ending_hr" name="ending_hr" type="text" value="<?php echo $ending_hr; ?>" />
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="amount" name="amount" type="number" value="<?php echo $amount; ?>" />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Fare Type</label>
                                <div class="col-sm-10">
									<select class="form-control" name="hr_status">
										<option value="">Select Fair Type</option>
										<option value="bs_fare" <?php if($hr_status=='bs_fare'){ echo 'selected'; } ?>>bs_fare</option>
										<option value="max" <?php if($hr_status=='max'){ echo 'selected'; } ?>>max</option>
										<option value="per_hr" <?php if($hr_status=='per_hr'){ echo 'selected'; } ?>>per_hr</option>
									</select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Vehical Type</label>
                                <div class="col-sm-10">
									<select class="form-control" name="veh_type">
										<option value="">Select Vehicle</option>
										<option value="2W" <?php if($veh_type=='2W'){ echo 'selected'; } ?>>2W</option>
										<option value="3W" <?php if($veh_type=='3W'){ echo 'selected'; } ?>>3W</option>
										<option value="4W" <?php if($veh_type=='4W'){ echo 'selected'; } ?>>4W</option>
										<option value="BUS" <?php if($veh_type=='BUS'){ echo 'selected'; } ?>>Bus</option>
										<option value="TRUCK" <?php if($veh_type=='TRUCK'){ echo 'selected'; } ?>>Truck</option>
										<option value="Staff" <?php if($veh_type=='Staff'){ echo 'selected'; } ?>>Staff</option>
									</select>
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit"><?php echo $submitBtn; ?></button>
                                </div>
                            </div>

                            <input class="form-control" id="id" name="id" type="hidden" value="<?php echo $editid; ?>" />
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