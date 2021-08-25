<?php include 'header.php'; 
 
  $id = $_GET['id'];
  $select_query = $con->query("SELECT * FROM `monthly_pass` WHERE id = ".$id."");
  $row=$select_query->fetch_assoc();
  $vendor_id = $row['vendor_id'];
  $vehicle_number = $row['vehicle_number'];
  $vehicle_type = $row['vehicle_type'];
  $company_name = $row['company_name'];
  $mobile_number = $row['mobile_number'];
  $amount = $row['amount'];
  $start_date = $row['start_date'];
  $end_date = $row['end_date'];
  $payment_type = $row['payment_type'];
  $status = $row['status'];

  $monthlypassdir = '../vendor/monthlypass/'.$vendor_id.'/';
  $new_user_image = $row['user_image'];
  $user_image = $monthlypassdir.$new_user_image;
  $new_vehicle_image = $row['vehicle_image'];
  $vehicle_image = $monthlypassdir.$new_vehicle_image;
  //$disablefileds = 'readonly="readonly"';
  $disablefileds = '';
 


if(isset($_POST['submit'])){
  $eid = $_POST['id'];
  $vendor_id = $_POST['vendor_id'];
  $vehicle_number = $_POST['vehicle_number'];
  $old_vehicle_number = $_POST['old_vehicle_number'];
  $vehicle_type = $_POST['vehicle_type'];
  $company_name = $_POST['company_name'];
  $mobile_number = $_POST['mobile_number'];
  $amount = $_POST['amount'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $pass_issued_date = time();
  $payment_type = $_POST['payment_type'];
  //$user_image = $_POST['user_image'];
  //$vehicle_image = $_POST['vehicle_image'];
  $status = $_POST['status'];

    $select_user_name = $con->query("SELECT id, CONCAT_WS(' ', first_name,last_name) as customer_name FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role = 'customer'"); 
    $numrows_username = $select_user_name->num_rows;
    if($numrows_username==1) {
      $val_user = $select_user_name->fetch_assoc();
      $customer_id = $val_user['id'];
     } else {
      $customer_id = 0;
    }


    $con->query("update `monthly_pass` SET vehicle_number = '".$vehicle_number."', customer_id = '".$customer_id."', vehicle_type = '".$vehicle_type."', company_name = '".$company_name."', mobile_number = '".$mobile_number."', amount = '".$amount."', start_date = '".$start_date."', end_date = '".$end_date."', payment_type = '".$payment_type."', status = '".$status."' where id = ".$id."");


    $MONTHLY_TEMP_DIR = '../vendor/monthlypass/'.$vendor_id.'/';
    if (!file_exists($MONTHLY_TEMP_DIR)){
       mkdir($MONTHLY_TEMP_DIR,0777, true); 
    }

    $upload_user_images = false;
    if($_FILES['user_image']){
      $type_user_image = $_FILES['user_image']['type'];
      if(($type_user_image == 'image/gif') || ($type_user_image == 'image/jpeg') || ($type_user_image == 'image/jpg') || ($type_user_image == 'image/png') )
      {
        $user_image_name = $_FILES['user_image']['name'];
        $user_image_tmp_name = $_FILES['user_image']['tmp_name'];
        $ext = pathinfo($user_image_name, PATHINFO_EXTENSION);
        $new_user_image = 'customer_user_'. time().".".$ext;
        $path_user_image = $MONTHLY_TEMP_DIR.$new_user_image;
        if($_FILES['user_image']['error'] == 0)
        { 
          if(move_uploaded_file($user_image_tmp_name, $path_user_image));
          {
            $con->query("update `monthly_pass` SET vehicle_image = '".$new_vehicle_image."' where id = ".$id."");
          }
        }
      }
    }

    $upload_vehicle_images = false;
    if($_FILES['vehicle_image']){
      $type_vehicle_image = $_FILES['vehicle_image']['type'];
      if(($type_vehicle_image == 'image/gif') || ($type_vehicle_image == 'image/jpeg') || ($type_vehicle_image == 'image/jpg') || ($type_vehicle_image == 'image/png') )
      {
        $vehicle_image_name = $_FILES['vehicle_image']['name'];
        $vehicle_image_tmp_name = $_FILES['vehicle_image']['tmp_name'];
        $ext = pathinfo($vehicle_image_name, PATHINFO_EXTENSION);
        $new_vehicle_image = 'customer_vehicle_'. time().".".$ext;
        $path_vehicle_image = $MONTHLY_TEMP_DIR.$new_vehicle_image;
        if($_FILES['vehicle_image']['error'] == 0)
        { 
          if(move_uploaded_file($vehicle_image_tmp_name, $path_vehicle_image));
          {
             $con->query("update `monthly_pass` SET user_image = '".$new_user_image." where id = ".$id."");
          }
        }
      }
    }
 
  $returnmsg = 'Vehicle Pass update successfully';
  $select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where vehicle_number='".$vehicle_number."'"); 
  $numrows_qr = $select_qr->num_rows;
  if($numrows_qr==0){
      $con->query("update `vehicle_qr_codes` SET vehicle_number = '".$vehicle_number."' where vehicle_number = '".$old_vehicle_number."'");
  } else {
    $returnmsg = 'Vehicle Pass update successfully! This Vehicle have QR code. So for this vehicle can not generate new QR.';
  }
  //header('location:edit-monthly-pass.php?id='.$id);
  //header('location:all-monthly-pass.php');
 
}

?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title"> Edit Monthly Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active"> Edit Monthly Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <?php if($returnmsg){ ?>
                           <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $returnmsg; ?>
                            </div>
                          <?php } ?>

 						               <form class="" id="signupForm" method="post" action="" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Number</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="vehicle_number" name="vehicle_number" type="text" value="<?php echo $vehicle_number; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Type</label>
                                <div class="col-sm-10">
                                   
                                    <select class="form-control" name="vehicle_type" required="required" <?php echo $disablefileds; ?>>
                                        <option value="">Select Vehicle</option>
                                        <option value="2W" <?php if($vehicle_type=='2W'){ echo 'selected'; } ?>>2W</option>
                                        <option value="3W" <?php if($vehicle_type=='3W'){ echo 'selected'; } ?>>3W</option>
                                        <option value="4W" <?php if($vehicle_type=='4W'){ echo 'selected'; } ?>>4W</option>
                                        <option value="BUS" <?php if($vehicle_type=='BUS'){ echo 'selected'; } ?>>Bus</option>
                                        <option value="TRUCK" <?php if($vehicle_type=='TRUCK'){ echo 'selected'; } ?>>Truck</option>
                                        <option value="Staff" <?php if($vehicle_type=='Staff'){ echo 'selected'; } ?>>Staff</option>
                                    </select>
                                  
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Company Name</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="company_name" name="company_name" type="text" value="<?php echo $company_name; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
									                 <input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $mobile_number; ?>" <?php echo $disablefileds; ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
									                 <input class="form-control" id="amount" name="amount" type="number" value="<?php echo $amount; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">From Date</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="start_date_m" name="start_date" type="text" value="<?php echo $start_date; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">To Date</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="end_date_m" name="end_date" type="text"  value="<?php echo $end_date; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Payment Type</label>
                                <div class="col-sm-10">
                                  
                                    <select name="payment_type" class="form-control" required="required" <?php echo $disablefileds; ?>>
                                        <option <?php if($payment_type=='Cash') { echo 'selected="selected"'; } ?> value="Cash">Cash</option>
                                        <option <?php if($payment_type=='Online') { echo 'selected="selected"'; } ?> value="Online">Online</option>
                                        <option  <?php if($payment_type=='Bank Transfer') { echo 'selected="selected"'; } ?>value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                  
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">User Image</label>
                                <div class="col-sm-10">
                                  <input name="user_image" type="file">
                                  <?php if($user_image){ ?>  <img style="width: 10%;" alt="" src="<?php echo $user_image; ?>"> <?php } ?>
                                         
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Vehicle Image</label>
                                <div class="col-sm-10">
                                  <input name="vehicle_image" type="file">
                                  <?php if($vehicle_image){ ?> <img style="width: 10%;" alt="" src="<?php echo $vehicle_image; ?>"> <?php } ?>
   
                                </div>
                            </div>

                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control" required="required">
                                        <option <?php if($status==2) { echo 'selected="selected"'; } ?> value="2">Applied</option>
                                        <option <?php if($status==1) { echo 'selected="selected"'; } ?> value="1">Active</option>
                                        <option <?php if($status==0) { echo 'selected="selected"'; } ?> value="0">Expired</option>
                                    </select>
                                </div>
                            </div>
                              

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit">Submit</button>
                                </div>
                            </div>
                             <input name="old_vehicle_number" type="hidden" value="<?php echo $vehicle_number; ?>" />
                            <input name="vendor_id" type="hidden" value="<?php echo $vendor_id; ?>" />
                            <input name="id" type="hidden" value="<?php echo $id; ?>" />
                             </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>


<?php include 'formscript.php'; ?>

<script>
 $(document).ready(function() {
 $('#start_date_m,#end_date_m').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        autoclose: true,
        todayHighlight: true
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script>


 <!--main content end-->
<?php include 'footer.php' ?>