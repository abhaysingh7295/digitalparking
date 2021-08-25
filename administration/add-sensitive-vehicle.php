<?php
include 'header.php';

$id = '';
$vehicle_number = '';
$vehicle_type = '';
$mobile_number = '';
$engine_number = '';
$chassis_number = '';
$city = '';
$state = '';
$address = '';
$pin_code = '';
$polic_station = '';
$search_reason = '';
$remark = '';
$photo_upload = '';
$heading = 'Add';
$current_cities ="";
$select_cities= $con->query("SELECT cities FROM `login` where id='" . $_SESSION["current_user_ID"] . "'");
if ($row_cities = $select_cities->fetch_assoc()) {
    $current_cities=$row_cities['cities'];
}
if ($_GET['id']) {
    $heading = 'Edit';
    $id = $_GET['id'];
    $sensitive_vehicle = $con->query("select * from `sensitive_vehicle` where id = '" . $id . "'");
    $vehicle_row = $sensitive_vehicle->fetch_assoc();
    extract($vehicle_row);
}



if (isset($_POST['submit'])) {


    extract($_POST);
    $eid = $id;
    $submit_date_time = time();

    if ($eid) {
        $insert_query = "update `sensitive_vehicle` SET vehicle_number = '" . $vehicle_number . "', vehicle_type = '" . $vehicle_type . "',  mobile_number = '" . $mobile_number . "', engine_number = '" . $engine_number . "', chassis_number = '" . $chassis_number . "', city = '" . $city . "',state = '" . $state . "',address = '" . $address . "',pin_code = '" . $pin_code . "',polic_station = '" . $polic_station . "',search_reason = '" . $search_reason . "',remark = '" . $remark . "' where id = '" . $eid . "'";
    } else {
        $crn_no = $submit_date_time;
        $insert_query = "INSERT INTO sensitive_vehicle(admin_id,open_admin_id,crn_no,vehicle_number,vehicle_type,mobile_number,engine_number,chassis_number,city,state,address,pin_code,polic_station,search_reason,remark,submit_date_time) VALUES('$current_user_id','$current_user_id','$crn_no','$vehicle_number','$vehicle_type','$mobile_number', '$engine_number','$chassis_number', '$city', '$state', '$address', '$pin_code', '$polic_station', '$search_reason', '$remark', '$submit_date_time')";
		 //whatsAppMessage($row_police_station['mobile_number'], $datas);
    }

    if ($con->query($insert_query) === TRUE) {
		
        if ($eid == '') {
            $sensitive_id = $con->insert_id;
            $con->query("INSERT INTO sensitive_vehicle_remark(sansitive_vehicle_id,admin_id,remark,date_time) VALUES('$sensitive_id','$current_user_id','$remark', '$submit_date_time')");
        } else {
            $sensitive_id = $eid;
        }

        $new_photo_upload = $_FILES['photo_upload']['name'];
        $path_profile_image = "upload/sensitives/" . $new_photo_upload;
        if ($new_photo_upload) {
            if (($_FILES['photo_upload']['type'] == 'image/gif') || ($_FILES['photo_upload']['type'] == 'image/jpeg') || ($_FILES['photo_upload']['type'] == 'image/jpg') || ($_FILES['photo_upload']['type'] == 'image/png')) {
                if (move_uploaded_file($_FILES['photo_upload']['tmp_name'], $path_profile_image))
                    ; {
                    if ($photo_upload) {
                        unlink($photo_upload);
                    }
                    $con->query("update `sensitive_vehicle` SET photo_upload = '" . $new_photo_upload . "' where id = '" . $sensitive_id . "'");
                }
            }
        }
        $police_stations = $con->query("select * from `police_stations` where city IN ($current_cities) order by police_station_name asc");
        $police_station_name = $con->query('select police_station_name,mobile_number from police_stations where id="'.$polic_station.'"');
        $plstn_name=$police_station_name->fetch_row();
        if ($police_stations->num_rows > 0) {
            $datas['parameters']=array(array('name'=>'vehicle_number_type','value'=>$vehicle_number),array('name'=>'phone','value'=>$mobile_number),array('name'=>'address','value'=>$address),array('name'=>'status','value'=>$remark),array('name'=>'date_time','value'=>date('d/m/Y h:i A',$submit_date_time)),array('name'=>'police_station','value'=>$plstn_name[0]));
                $datas['template_name']='sensative_vehicle_registration';
                 $datas['broadcast_name']='sensative vehicle registration';
				  whatsAppMessage($plstn_name[1], $datas);
				  //whatsAppMessage('9694449191', $datas);
        while ($row_police_station = $police_stations->fetch_assoc()) {
            
                 if(trim($row_police_station['mobile_number']) !='N/A') {
                   // whatsAppMessage($row_police_$mobile_numberstation['mobile_number'], $datas);
                 }
            } 
        }
        // messageloop ends here
        header('location:all-sensitive-vehicles.php');
    } else {
        $error = 'Some Database Error';
    }
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title"><?php echo $heading; ?> Sensitive Vehicle</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $heading; ?> Sensitive Vehicle 111</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle No</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $vehicle_number; ?>" id="vehicle_number" name="vehicle_number" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="vehicle_type" required="required">
                                        <option value="">Select Vehicle</option>
                                        <option value="2W" <?php if ($vehicle_type == '2W') {
                                echo 'selected';
                            } ?>>2W</option>
                                        <option value="3W" <?php if ($vehicle_type == '3W') {
                                echo 'selected';
                            } ?>>3W</option>
                                        <option value="4W" <?php if ($vehicle_type == '4W') {
                                echo 'selected';
                            } ?>>4W</option>
                                        <option value="BUS" <?php if ($vehicle_type == 'BUS') {
                                echo 'selected';
                            } ?>>Bus</option>
                                        <option value="TRUCK" <?php if ($vehicle_type == 'TRUCK') {
                                echo 'selected';
                            } ?>>Truck</option>
                                        <option value="Staff" <?php if ($vehicle_type == 'Staff') {
                                echo 'selected';
                            } ?>>Staff</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile No</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $mobile_number; ?>" id="mobile_number" name="mobile_number" required="required">
                                </div>
                            </div>


                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Engine No</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $engine_number;  ?>" id="engine_number" name="engine_number">
                                                            </div>
                                                        </div>-->

                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Chassis No</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $chassis_number;  ?>" id="chassis_number" name="chassis_number">
                                                            </div>
                                                        </div>-->

                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">City</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $city;  ?>" id="city" name="city">
                                                            </div>
                                                        </div>-->


                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">State</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $state;  ?>" id="state" name="state">
                                                            </div>
                                                        </div>-->

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $address; ?>" id="address" name="address" required="required">
                                </div>
                            </div>

                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Pin Code</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $pin_code; ?>" id="pin_code" name="pin_code">
                                                            </div>
                                                        </div>-->

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Police Station</label>
                                <div class="col-sm-10">
                                    <select name="polic_station" class="form-control select2" required="required">
                                        <option value="">Police Station</option>
<?php

$police_stations = $con->query("select * from `police_stations` where city IN ($current_cities) order by police_station_name asc");
if ($police_stations->num_rows > 0) {
while ($row_police_station = $police_stations->fetch_assoc()) {
    ?>
                                            <option <?php if ($polic_station == $row_police_station['id']) {
        echo 'selected="selected"';
    } ?> value="<?php echo $row_police_station['id']; ?>"><?php echo $row_police_station['police_station_name']; ?></option>
<?php } }?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Reason for search</label>
                                <div class="col-sm-10">
                                    <select name="search_reason" class="form-control" required="required">
                                        <option  value="">Reason for search</option>
                                        <option <?php if ($search_reason == 'Theft') {
    echo 'selected="selected"';
} ?> value="Theft">Theft</option>
                                        <option <?php if ($search_reason == 'Wanted') {
    echo 'selected="selected"';
} ?> value="Wanted">Wanted</option>
                                        <option <?php if ($search_reason == 'Other') {
    echo 'selected="selected"';
} ?> value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="remark"><?php echo $remark; ?></textarea> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Upload Photo</label>
                                <div class="col-sm-10">
                                    <input type="file" name="photo_upload" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-st-input" class="col-sm-2 col-form-label"></label>
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#mobile_number').on('keydown', function (e) {
            var deleteKeyCode = 8;
            var backspaceKeyCode = 46;
            if ((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which === deleteKeyCode || e.which === backspaceKeyCode)
            {
                $(this).removeClass('error');
                return true;
            } else
            {
                $(this).addClass('error');
                return false;
            }
        });
       
    })
</script>




<?php include 'footer.php'; ?>