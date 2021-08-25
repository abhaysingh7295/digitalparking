<?php
include 'header.php';

$id = '';
$police_station_name = '';
$state = '';
$mobile_number = '';
$city = '';
$department = '';
$designation = '';
$name = '';
$remark = '';
$heading = 'Add';
$citys=array();
if ($_GET['id']) {
    $heading = 'Edit';
    $id = $_GET['id'];
    $police_stations = $con->query("select * from `police_stations`  where id = '" . $id . "'");
    $vehicle_row = $police_stations->fetch_assoc();
    extract($vehicle_row);
    $citys= $con->query("SELECT * FROM `city` WHERE status ='Active' and state_id='".$state."'");
    
}

if (isset($_POST['submit'])) {
    extract($_POST);
    $eid = $id;
    $submit_date_time = time();

    if ($eid) {
        $insert_query = "update `police_stations` SET police_station_name = '" . $police_station_name . "',state = '" . $state . "',city = '" . $city . "',department = '" . $department . "',designation = '" . $designation . "',name = '" . $name . "',mobile_number = '" . $mobile_number . "' where id = '" . $eid . "'";
    } else {
        $insert_query = "INSERT INTO police_stations(police_station_name,state,city,department,designation,name,mobile_number) VALUES('$police_station_name','$state','$city','$department','$designation','$name','$mobile_number')";
    }

    if ($con->query($insert_query) === TRUE) {
        header('location:all-police-stations.php');
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
                    <h4 class="page-title"><?php echo $heading; ?> Police Station</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $heading; ?> Police Station</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Police Station Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $police_station_name; ?>" id="police_station_name" name="police_station_name" required="required">
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
                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">State</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $state; ?>" id="state" name="state" required="required">
                                                            </div>
                                                        </div>-->

                            <!--                            <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">City</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?php //echo $city; ?>" id="city" name="city" required="required">
                                                            </div>
                                                        </div>-->
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="city" id="city-dropdown">
                                        <option value="">City</option>
                                        <?php
                                        if ($citys->num_rows > 0) {
                                            while ($row_city = $citys->fetch_assoc()) {
                                                ?> 
                                                <option  <?php
                                                    if (!empty($city) && $city == $row_city['id']) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>  value="<?php echo $row_city['id'] ?>"><?php echo $row_city['name']; ?></option>
    <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Department</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $department; ?>" id="department" name="department" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Designation</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $designation; ?>" id="designation" name="designation" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $name; ?>" id="name" name="name" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $mobile_number; ?>" id="mobile_number" name="mobile_number" required="required">
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