<?php include 'header.php'; 
$access_permission = array();

if(isset($_POST['submit'])){

$id = $_POST['id'];

$staff_name = $_POST['full_name'];
$staff_mobile_number = $_POST['mobile_number'];
$staff_email = $_POST['email'];
$staff_added = date('Y-m-d H:i:s');
$staff_dob = $_POST['date_of_birth'];
$password = $_POST['password'];
$access_permission = implode(',',$_POST['access_permission']);
$login_type = $_POST['login_type'];

//print_r($_POST);
//exit;
if($id){
   $aqled = "update `staff_details` SET staff_name = '".$staff_name."', staff_mobile_number = '".$staff_mobile_number."', staff_email = '".$staff_email."', staff_dob = '".$staff_dob."', access_permission = '".$access_permission."', login_type = '".$login_type."' where staff_id = ".$id;
    if ($con->query($aqled) === TRUE) {
      if($password){
        $con->query("update `staff_details` SET password = '".$password."' where staff_id = ".$id);
      }
      header('location:all-staffs.php');
    } else {
       $error = 'Some Database Error';
    }


} else {
    $select_user_name = $con->query("SELECT * FROM `staff_details` Where staff_email='".$staff_email."'"); 
    $val_user = $select_user_name->fetch_assoc();
    $numrows_username = $select_user_name->num_rows;
    if($numrows_username==0) {
      $insert_query = $con->query("SET NAMES utf8");
      $insert_query = "INSERT INTO staff_details(user_id,staff_name,staff_email,staff_mobile_number,staff_dob,staff_added,vendor_id,password,access_permission,login_type) VALUES('$current_user_id','$staff_name','$staff_email','$staff_mobile_number','$staff_dob','$staff_added','$current_user_id','$password','$access_permission','$login_type')";
      if ($con->query($insert_query) === TRUE) {
        header('location:all-staffs.php');
      }
    } else {
      $error = 'Staff Already Exists please try different Username and Email';
    }
}
 

 
}

if($_GET['edit']){
  $id = $_GET['edit'];
  $select_query = $con->query("SELECT * FROM `staff_details` WHERE staff_id = ".$id);
  $row = $select_query->fetch_assoc();
  $full_name = $row['staff_name'];
  $staff_email = $row['staff_email'];
  $staff_mobile_number = $row['staff_mobile_number'];
  $staff_dob = $row['staff_dob'];
  $password = $row['password'];
  $login_type = $row['login_type'];
   $access_permission = explode(',',$row['access_permission']);
} else {

  $active_plans_row = GetVendorActivatedPlan($con,$current_user_id);
  $staff_capacity = $active_plans_row['staff_capacity'];

  $select_total_staffs = $con->query("SELECT staff_id FROM `staff_details` WHERE vendor_id = ".$current_user_id);
  
  if($select_total_staffs->num_rows >= $staff_capacity)
    {
      echo "<script> alert('You can not Add More Staffs Your Staff capacity full. If you needs to add More staffs then you needs to upgrade you subscrition Plan'); window.location.replace('subscriptions.php');</script>";
    }

  $id = '';
  $full_name = '';
  $staff_email = '';
  $staff_mobile_number = '';
  $staff_dob = '';
  $password = '';
  $access_permission ='';
  $login_type = '';
  }



?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title"> Add Staff</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active"> Add Staff</li>
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
                            <?php if(isset($error)) {
                              echo '<p style="color:red">'.$error.'</p>';
                              } ?>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Full Name</label>
                                <div class="col-sm-10">
                                     <input class="form-control" id="full_name" name="full_name" type="text" value="<?php echo $full_name; ?>" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="email" name="email" type="email" value="<?php echo $staff_email; ?>" />
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                   <input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $staff_mobile_number; ?>"/>
                                </div>
                            </div>


                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Date of Birth</label>
                                <div class="col-sm-10">
								                    <input class="form-control" id="date_of_birth" name="date_of_birth" type="text" value="<?php echo $staff_dob; ?>" />
                                </div>
                            </div>


                         <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="password" name="password" type="password" value="" />
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Login Type</label>
                                <div class="col-sm-10">
                                    <select name="login_type" class="form-control" required="required" >
                                        <option value="">Select Login Type</option>
                                        <option <?php if($login_type=='web'){ echo 'selected="selected"'; } ?> value="web">Web</option>
                                        <option <?php if($login_type=='app'){ echo 'selected="selected"'; } ?> value="app">App</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Access Permission   </label>


                                <?php  $PermissionArrays = StaffPermissionArray();
                                    $i = 1;
                                    foreach($PermissionArrays as $Permissionarray){
                                        echo '<div class="col-sm-5">';
                                            foreach($Permissionarray as $key => $Permission){ ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if (in_array($key, $access_permission)){ echo 'checked="checked"'; } ?>  type="checkbox" class="custom-control-input" id="customCheck<?php echo $i; ?>" data-parsley-multiple="groups" data-parsley-mincheck="<?php echo $i; ?>" value="<?php echo $key; ?>" name="access_permission[]">
                                                    <label class="custom-control-label" for="customCheck<?php echo $i; ?>"><?php echo $Permission; ?></label>
                                                </div>
                                            <?php $i++; }
                                        echo '</div>';
                                    }


                                ?>
                           
                           
                        
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit">Submit</button>
                                </div>
                            </div>

                            <input name="id" type="hidden" value="<?php echo $id; ?>" />
                            <input name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
                            </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>


<?php include '../administration/formscript.php'; ?>

<script>
 $(document).ready(function() {
 $('#date_of_birth').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script>


 <!--main content end-->
<?php include 'footer.php' ?>