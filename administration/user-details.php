<?php include 'header.php';

$user_id = $_GET['user_id'];


$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."' AND user_role = 'vandor'");
 

$numrows_vendor = $select_query->num_rows;
if($numrows_vendor==0) {
	header('location:all-users.php');
	exit();
}


$row=$select_query->fetch_assoc();
$vendor_id = $user_id;

$select_qr = $con->query("SELECT * FROM `vendor_qr_codes` Where vendor_id='".$vendor_id."'");

$row_qr=$select_qr->fetch_assoc(); ?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vendor Details</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vendor Details</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <a href="edit-vendor-details.php?user_id=<?php echo $user_id; ?>" class="btn btn-danger" style="float: right;margin-bottom: 10px;">Edit Vendor</a>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                   
                                    <tbody>
                                        <tr>
                                            <th scope="row">First Name</th>
                                            <td> <?php echo $row['first_name']; ?></td>
                                           
                                        </tr>
                                        <tr>
                                            <th scope="row">Last Name</th>
                                            <td><?php echo $row['last_name']; ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th scope="row">Email/Username</th>
                                            <td><?php echo $row['user_email']; ?></td>  
                                        </tr>

                                        <tr>
                                            <th scope="row">Mobile No.</th>
                                            <td><?php echo $row['mobile_number']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Profile Image</th>
                                            <td> <?php if($row['profile_image']) { ?> <a href="<?php echo '../vendor/'.$row['profile_image']; ?>" target="_blank"><img width="200" src="<?php echo '../vendor/'.$row['profile_image']; ?>"></a>
						                    <?php } else {?>
						                    -- No Image --
						                    <?php }?></td>  
                                        </tr>
                                        <tr>
                                            <th scope="row">Adhar Card Image</th>
                                            <td><?php if($row['adhar_image']) { ?> <a href="<?php echo '../vendor/'.$row['adhar_image']; ?>" target="_blank"><img width="200" src="<?php echo '../vendor/'.$row['adhar_image']; ?>"></a>
						                    <?php } else {?>
						                    -- No Image --
						                    <?php }?></td>  
                                        </tr>
                                        <tr>
                                            <th scope="row">Pan Card Image</th>
                                            <td><?php if($row['pan_card_image']) { ?> <a href="<?php echo '../vendor/'.$row['pan_card_image']; ?>" target="_blank"><img width="200" src="<?php echo '../vendor/'.$row['pan_card_image']; ?>"></a>
                                            <?php } else {?>
						                    -- No Image --
						                    <?php }?></td>  
                                        </tr>

                                        <tr>
                                            <th scope="row">Parking Name</th>
                                            <td><?php echo $row['parking_name']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Parking Type</th>
                                            <td><?php echo $row['parking_type']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Address</th>
                                            <td><?php echo $row['address']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">State</th>
                                            <td><?php echo $row['state']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">City</th>
                                            <td><?php echo $row['city']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Parking Open</th>
                                            <td><?php echo $row['open_time']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Parking Close</th>
                                            <td><?php echo $row['close_time']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Parking Capacity</th>
                                            <td><?php echo $row['parking_capacity']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">Online Parking Capacity</th>
                                            <td><?php echo $row['online_booking_capacity']; ?></td> 
                                        </tr>

                                        <tr>
                                            <th scope="row">QR Code</th>
                                            <td><?php 
                                            	if($row_qr['qr_code']) {
                                            		$QR_FILE_DIR = '../qrcodes/'.$vendor_id.'/'.$row_qr['qr_code'].'.png';
                                            		if(file_exists($QR_FILE_DIR)){ ?>
                                            			<img width="200" src="<?php echo $QR_FILE_DIR; ?>">
                                            		<?php } 
                                            		else { echo ' -- No Image --'; } 
                                            	} else { echo ' -- No Image --'; } ?></td>  
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                           <h4 class="mt-0 header-title">Fare Information</h4>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                <th>Initial Hour</th>
								<th>Ending Hour</th>
								<th>Amount</th>
								<th>Fare Status</th>
								<th>Vehicle Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $select_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$vendor_id." ORDER BY hr_status ASC");
                                  while($row=$select_query->fetch_assoc())
                                  {  ?>
									<tr>
									<td><?php echo $row['initial_hr']; ?></td>
									<td><?php echo $row['ending_hr']; ?></td>
									<td><?php echo $row['amount']; ?></td>
									<td><?php echo $row['hr_status']; ?></td>
              						<td><?php echo $row['veh_type']; ?></td>
                                  </tr>
                                  <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->



            </div> <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->


    <?php include 'footer.php' ?>