<?php
include 'header.php';
$id = '';
$display_name = '';
$Email = '';
$role = '';
$state = '';
$profile_image = '';
$access_permission = array();

if ($_GET['id']) {
    $id = $_GET['id'];
    $user_query = $con->query("select * from `login` where Id = '" . $id . "'");
    $admin_row = $user_query->fetch_assoc();
    $display_name = $admin_row['display_name'];
    $Email = $admin_row['Email'];
    $role = $admin_row['Role'];
     $mobileno = $admin_row['mobileno'];
    $profile_image = $admin_row['profile_image'];
    $access_permission = explode(',', $admin_row['access_permission']);
    $cities = explode(',', $admin_row['cities']);
    $state = $admin_row['states'];
    $citys= $con->query("SELECT * FROM `city` WHERE status ='Active' and state_id='".$state."'");
}

if (isset($_POST['submit'])) {
    $eid = $_POST['id'];
    $display_name = $_POST['display_name'];
    $Email = $_POST['Email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = $_POST['role'];
    $state = $_POST['state'];
    $mobileno = $_POST['mobileno'];
    $access_permission = implode(',', $_POST['access_permission']);
    $cities = implode(',', $_POST['city']);
    $date_time = time();
    $profile_image_nm = '';

    if ($eid) {

        $new_profile_image = $_FILES['profile_image']['name'];
        $path_profile_image = "upload/" . $new_profile_image;
        if ($new_profile_image) {
            if (($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png')) {
                if ($_FILES['profile_image']['error'] > 0) {
                    echo "<script>alert('Return'" . $_FILES['profile_image']['error'] . "')</script>";
                } else if (move_uploaded_file($_FILES['profile_image']['tmp_name'], 'upload/' . $_FILES['profile_image']['name'])) {
                    unlink($profile_image);
                    $con->query("update `login` SET profile_image = '" . $path_profile_image . "' where Id = '" . $eid . "'");
                }
            }
        }


        if ($password) {
            if ($cpassword == $password) {
                $insert_query = "update `login` SET display_name = '" . $display_name . "', User_name = '" . $Email . "', Email = '" . $Email . "', Password = '" . $password . "', access_permission = '" . $access_permission . "', Role = '" . $role . "', cities = '" . $cities . "', states = '" . $state . "' , mobileno = '" . $mobileno . "' where Id = '" . $eid . "'";
            } else {
                $error = 'Password Does Not Match Please fill correct Password';
            }
        } else {
            $insert_query = "update `login` SET display_name = '" . $display_name . "', User_name = '" . $Email . "', Email = '" . $Email . "', access_permission = '" . $access_permission . "', Role = '" . $role . "', cities = '" . $cities . "' , states = '" . $state . "' , mobileno = '" . $mobileno . "'  where Id = '" . $eid . "'";
        }


        if ($con->query($insert_query) === TRUE) {
            header('location:all-admins.php');
        } else {
            $error = 'Some Database Error';
        }
    } else {

        $select_user1 = $con->query("SELECT Email FROM login WHERE Email = '" . $Email . "' ");
        if ($select_user1->num_rows < 1) {
             $select_user12 = $con->query("SELECT Email FROM login WHERE mobileno = '" . $mobileno . "' ");
        if ($select_user12->num_rows < 1) {
            if ($cpassword == $password) {
                $new_profile_image = $_FILES['profile_image']['name'];
                $path_profile_image = "upload/" . $new_profile_image;
                if ($new_profile_image) {
                    if (($_FILES['profile_image']['type'] == 'image/gif') || ($_FILES['profile_image']['type'] == 'image/jpeg') || ($_FILES['profile_image']['type'] == 'image/jpg') || ($_FILES['profile_image']['type'] == 'image/png')) {
                        if ($_FILES['profile_image']['error'] > 0) {
                            echo "<script>alert('Return'" . $_FILES['profile_image']['error'] . "')</script>";
                        } else if (move_uploaded_file($_FILES['profile_image']['tmp_name'], 'upload/' . $_FILES['profile_image']['name'])) {
                            $profile_image_nm = $path_profile_image;
                        }
                    }
                }

                $insert_query = "INSERT INTO login(display_name,User_name,Email,Password,Role,user_status,date_time,access_permission,profile_image,cities,states,mobileno) VALUES('$display_name','$Email','$Email','$password','$role','1','$date_time','$access_permission','$profile_image_nm','$cities','$state','$mobileno')";
                if ($con->query($insert_query) === TRUE) {
                    header('location:all-admins.php');
                } else {
                    $error = 'Some Database Error';
                }
            } else {
                $error = 'Password Does Not Match Please fill correct Password';
            }
        } else {
            $error = 'User Already Exists please try diffrent Mobile Number';
        }
            
        } else {
            $error = 'User Already Exists please try diffrent Username and Email';
        }
    }
}
?>

<div class="wrapper">

    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Add New Admin</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                        <li class="breadcrumb-item active">Add New Admin</li>
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
<?php
if (isset($error)) {
    echo '<p style="color:red">' . $error . '</p>';
}
?>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $display_name; ?>" id="display_name" name="display_name" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username / Email<br><small>(Not Changeable)</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="email" value="<?php echo $Email; ?>" id="Email" name="Email" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number<br><small></small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" value="<?php echo $mobileno; ?>" id="mobileno" maxlength="10" minlength="10"  name="mobileno" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" value="" id="password" name="password" <?php if ($id == '') {
                                echo 'required="required"';
                            } ?> >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="password" value="" id="cpassword" name="cpassword" <?php if ($id == '') {
                                echo 'required="required"';
                            } ?> >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input name="profile_image" type="file">   
<?php if ($profile_image) { ?>
                                        <img style="width: 10%;" src="<?php echo $profile_image; ?>">                             
<?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select name="role" class="form-control" required="required">
                                        <option value="">Select Role</option>
                                        <option <?php if ($role == 'admin') {
    echo 'selected="selected"';
} ?> value="admin">Admin</option>
                                        <option <?php if ($role == 'subadmin') {
    echo 'selected="selected"';
} ?> value="subadmin">Sub Admin</option>
                                    </select>
                                </div>
                            </div>

                                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-10">
                                    <select name="state" class="form-control" id="state-dropdown" required="required">
                                        <option value="">State</option>
                                        <?php
                                        $states = $con->query("select * from `state` where status='Active' order by state_title asc");

                                        while ($row_state = $states->fetch_assoc()) {
                                            ?>
                                            <option <?php if ($state == $row_state['state_id']) {
                                            echo 'selected="selected"';
                                        } ?> value="<?php echo $row_state['state_id']; ?>"><?php echo $row_state['state_title']; ?></option>
<?php } ?>

                                    </select>
                                </div>
                            </div>
                                 <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="city[]" id="city-dropdown" multiple="multiple">
                                        <option value="">City</option>
                                        <?php
                                        if ($citys->num_rows > 0) {
                                            while ($row_city = $citys->fetch_assoc()) {
                                                ?> 
                                                <option  <?php if (in_array($row_city['id'], $cities)) {
                                                echo 'selected="selected"';
                                            } ?>   value="<?php echo $row_city['id'] ?>"><?php echo $row_city['name']; ?></option>
    <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>           
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Access Permission   </label>


                                <?php
                                $PermissionArrays = AdminPermissionArray();
                                $i = 1;
                                foreach ($PermissionArrays as $Permissionarray) {
                                    echo '<div class="col-sm-5">';
                                    foreach ($Permissionarray as $key => $Permission) {
                                        ?>
                                        <div class="custom-control custom-checkbox">
                                            <input <?php if (in_array($key, $access_permission)) {
                                            echo 'checked="checked"';
                                        } ?>  type="checkbox" class="custom-control-input" id="customCheck<?php echo $i; ?>" data-parsley-multiple="groups" data-parsley-mincheck="<?php echo $i; ?>" value="<?php echo $key; ?>" name="access_permission[]">
                                            <label class="custom-control-label" for="customCheck<?php echo $i; ?>"><?php echo $Permission; ?></label>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>  

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button class="btn btn-danger" type="submit" name="submit">Submit</button>
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
<script>
    $(document).ready(function () {
        $('#state-dropdown').on('change', function () {
            var state_id = this.value;
            $.ajax({
                url: "city-by-state.php",
                type: "POST",
                data: {
                    state_id: state_id
                },
                cache: false,
                success: function (result) {
                    $("#city-dropdown").html(result);

                }
            });
        });

    });
</script>


<?php include 'footer.php'; ?>