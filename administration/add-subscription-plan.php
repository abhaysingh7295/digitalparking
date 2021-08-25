<?php include 'header.php'; 

$id = '';
$plan_name = '';
$plan_amount = '';
$plan_content = '';
$staff_capacity = '';
$report_export_capacity = '';

if($_GET['id']){
    $id = $_GET['id'];
    $subscriptions_plans = $con->query("select * from `subscriptions_plans` where id = '".$id."'");
    $plans_row = $subscriptions_plans->fetch_assoc();
    extract($plans_row);
} 

if(isset($_POST['submit']))
{
    extract($_POST);
    $eid = $id;
    $date_time = time();

    if($eid){
         $insert_query = "update `subscriptions_plans` SET plan_name = '".$plan_name."', plan_amount = '".$plan_amount."',  staff_capacity = '".$staff_capacity."', report_export_capacity = '".$report_export_capacity."', bgcolor = '".$bgcolor."', duration = ".$duration.",self_parking = ".$self_parking.",monthly_pass = ".$monthly_pass.",pre_booking = ".$pre_booking.",sms_notification = ".$sms_notification.",auto_email = ".$auto_email.",daily_report = ".$daily_report.",monthly_report = ".$monthly_report.",wanted_notification = ".$wanted_notification.",block_vehicle = ".$block_vehicle.",wallet = ".$wallet.",vendor_logo = ".$vendor_logo.",fare_info = ".$fare_info." where id = '".$eid."'";
    } else {
        $insert_query = "INSERT INTO subscriptions_plans(plan_name,plan_amount,staff_capacity,report_export_capacity,bgcolor,status,date_time,duration,self_parking,monthly_pass,pre_booking,sms_notification,auto_email,daily_report,monthly_report,wanted_notification,block_vehicle,wallet,vendor_logo,fare_info) VALUES('$plan_name','$plan_amount','$staff_capacity', '$report_export_capacity','$bgcolor','1','$date_time','$duration', '$self_parking', '$monthly_pass', '$pre_booking', '$sms_notification', '$auto_email', '$daily_report', '$monthly_report', '$wanted_notification', '$block_vehicle', '$wallet', '$vendor_logo', '$fare_info')";   
    }

    if ($con->query($insert_query) === TRUE) {
        header('location:add-subscription-plan.php');
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
                        <h4 class="page-title">Add Subscription Plan</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Add Subscription Plan</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Plan Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $plan_name; ?>" id="plan_name" name="plan_name" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $plan_amount; ?>" id="plan_amount" name="plan_amount" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Staff Capacity</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $staff_capacity; ?>" id="staff_capacity" name="staff_capacity" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Duration in Month</label>
                                <div class="col-sm-10">
                                    <select name="duration" class="form-control" required="required">
                                        <option value="">Select Duration</option>
                                        <option <?php if($duration==1){ echo 'selected="selected"'; } ?> value="1">1 Month</option>
                                        <option <?php if($duration==2){ echo 'selected="selected"'; } ?> value="2">2 Month</option>
                                        <option <?php if($duration==3){ echo 'selected="selected"'; } ?> value="3">3 Month</option>
                                        <option <?php if($duration==4){ echo 'selected="selected"'; } ?> value="4">4 Month</option>
                                        <option <?php if($duration==5){ echo 'selected="selected"'; } ?> value="5">5 Month</option>
                                        <option <?php if($duration==6){ echo 'selected="selected"'; } ?> value="6">6 Month</option>
                                        <option <?php if($duration==7){ echo 'selected="selected"'; } ?> value="7">7 Month</option>
                                        <option <?php if($duration==8){ echo 'selected="selected"'; } ?> value="8">8 Month</option>
                                        <option <?php if($duration==9){ echo 'selected="selected"'; } ?> value="9">9 Month</option>
                                        <option <?php if($duration==10){ echo 'selected="selected"'; } ?> value="10">10 Month</option>
                                        <option <?php if($duration==11){ echo 'selected="selected"'; } ?> value="11">11 Month</option>
                                        <option <?php if($duration==12){ echo 'selected="selected"'; } ?> value="12">12 Month</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Data Store in Months</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="<?php echo $report_export_capacity; ?>" id="report_export_capacity" name="report_export_capacity" required="required">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Self Parking</label>
                                <div class="col-sm-10">
                                    <select name="self_parking" class="form-control" required="required">
                                        <option value="">Select Self Parking</option>
                                        <option <?php if($self_parking==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($self_parking==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Monthly Pass</label>
                                <div class="col-sm-10">
                                    <select name="monthly_pass" class="form-control" required="required">
                                        <option value="">Select Monthly Pass</option>
                                        <option <?php if($monthly_pass==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($monthly_pass==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Pre Booking</label>
                                <div class="col-sm-10">
                                    <select name="pre_booking" class="form-control" required="required">
                                        <option value="">Select Pre Booking</option>
                                        <option <?php if($pre_booking==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($pre_booking==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">SMS Notification</label>
                                <div class="col-sm-10">
                                    <select name="sms_notification" class="form-control" required="required">
                                        <option value="">Select SMS Notification</option>
                                        <option <?php if($sms_notification==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($sms_notification==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Auto Email</label>
                                <div class="col-sm-10">
                                    <select name="auto_email" class="form-control" required="required">
                                        <option value="">Select Auto Email</option>
                                        <option <?php if($auto_email==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($auto_email==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Daily Report</label>
                                <div class="col-sm-10">
                                    <select name="daily_report" class="form-control" required="required">
                                        <option value="">Select Daily Report</option>
                                        <option <?php if($daily_report==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($daily_report==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Monthly Report</label>
                                <div class="col-sm-10">
                                    <select name="monthly_report" class="form-control" required="required">
                                        <option value="">Select Monthly Report</option>
                                        <option <?php if($monthly_report==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($monthly_report==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Wanted Notification</label>
                                <div class="col-sm-10">
                                    <select name="wanted_notification" class="form-control" required="required">
                                        <option value="">Select Wanted Notification</option>
                                        <option <?php if($wanted_notification==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($wanted_notification==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Block Vehicle</label>
                                <div class="col-sm-10">
                                    <select name="block_vehicle" class="form-control" required="required">
                                        <option value="">Select Block Vehicle</option>
                                        <option <?php if($block_vehicle==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($block_vehicle==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Wallet</label>
                                <div class="col-sm-10">
                                    <select name="wallet" class="form-control" required="required">
                                        <option value="">Select Wallet</option>
                                        <option <?php if($wallet==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($wallet==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vendor Logo</label>
                                <div class="col-sm-10">
                                    <select name="vendor_logo" class="form-control" required="required">
                                        <option value="">Select Vendor Logo</option>
                                        <option <?php if($vendor_logo==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($vendor_logo==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Fare Info</label>
                                <div class="col-sm-10">
                                    <select name="fare_info" class="form-control" required="required">
                                        <option value="">Select Fare Info</option>
                                        <option <?php if($fare_info==0){ echo 'selected="selected"'; } ?> value="0">No</option>
                                        <option <?php if($fare_info==1){ echo 'selected="selected"'; } ?> value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                             

                            <?php $arraybgcolor = array(
                               'primary' => 'Primary',
                               'secondary' => 'Secondary',
                               'success' => 'Success',
                               'info' => 'Info',
                               'warning' => 'Warning',
                               'danger' => 'Danger',
                               'light' => 'Light',
                               'dark' => 'Dark'

                            ) ?>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">BG Color Type</label>
                                <div class="col-sm-10">
                                    <select name="bgcolor" class="form-control" required="required">
                                        <option value="">Select BG Color Type</option>
                                        <?php foreach($arraybgcolor as $key => $abgcolor) { ?>
                                        <option <?php if($bgcolor==$key){ echo 'selected="selected"'; } ?> value="<?php echo $key; ?>"><?php echo $abgcolor; ?></option>
                                    <?php } ?>
                                    </select>
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


     



<?php include 'footer.php'; ?>