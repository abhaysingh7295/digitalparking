<?php
include 'header.php'; 

$block_vechiles = GetVendorsBlockedVechiles($con,$current_user_id);
 
if(isset($_POST['submit'])){

    $vendor_id = $_POST['vendor_id'];
    $vehicle_number = $_POST['vehicle_number'];
    $mobile_number = $_POST['mobile_number'];
    $amount = $_POST['amount'];
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_in_date_time = time();
    $vehicle_status = 'In';

    if (!in_array($vehicle_number, $block_vechiles))
    {
        if($mobile_number){
            $select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role='customer'"); 
            $numrows_username = $select_user_name->num_rows;
            if ($numrows_username > 0) {
                $val_user = $select_user_name->fetch_assoc();
                $customer_id = $val_user['id'];
            } else {
                $user_role = 'customer';
                $user_status  = 1;
                $register_date  = date('Y-m-d h:i:s');
                $social_type  = 'simple';
                $os  = 'android';
                $reflength = 10;
                $refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
                $insert_query = "INSERT INTO pa_users(mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code) VALUES('$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code')";
                if ($con->query($insert_query) === TRUE) {
                    $customer_id = $con->insert_id;
                }
            }
        } else {
            $customer_id = 0;
        }
        $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where customer_id='".$customer_id."' AND vendor_id='".$current_user_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'"); 
        
        if($select_vehicle->num_rows==0) {
//            $qury = $con->query('SELECT * FROM vehicle_booking WHERE vendor_id="'.$current_user_id.'" ORDER BY id DESC LIMIT 1');
//             if($qury->num_rows>0) {
//                 while($rslt=$qury->fetch_assoc()){
//                    $serial_number= $rslt['serial_number']+1;
//                 }
//             }else{
//                $serial_number=1;
//             }
             $serial_number="(SELECT COALESCE(MAX(vbg.serial_number),0)+1 FROM vehicle_booking as vbg where vbg.vendor_id='".$current_user_id."')";
            $insert_vehicle = "INSERT INTO vehicle_booking(vendor_id,customer_id,serial_number,vehicle_number,mobile_number,vehicle_type,vehicle_in_date_time,vehicle_status) VALUES('$current_user_id','$customer_id',$serial_number,'$vehicle_number','$mobile_number','$vehicle_type','$vehicle_in_date_time','$vehicle_status')";

            if ($con->query($insert_vehicle)) {
                $booking_id= $con->insert_id;
                GetVendorsWantedVechiles($con,$current_user_id,$vehicle_number,$booking_id);
                SensitiveVechilesNotify($con,$current_user_id,$vehicle_number,$booking_id);
                GetMissingVehicleNumber($con,$vendor_id,$vehicle_number,$booking_id);

                if(($mobile_number) && ($active_plans_row['sms_notification']==1)){
                    $vendor_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as vendor_name, parking_name FROM pa_users WHERE id = ".$vendor_id."");
                    $vendor_ow=$vendor_query->fetch_assoc();

                    $customer_name = '';
                    if($customer_id!=0){
                      $customer_name = $val_user['first_name'].' '.$val_user['last_name'].' ';
                    }
                    // idhar otp ki jarurat nhi hai only template id pass karna hoga
                    //so method check kariye
                    // yeh jo msg hai abhi nhi araha hai template id is mai pass karna hoga
                    
                    $sendmessage = 'Hello, '.$customer_name.'Your vehicle '.$vehicle_number.' '.$vehicle_type.' has been parked at '.$vendor_ow['parking_name'].' on '.date('Y-m-d h:i A',$vehicle_in_date_time).', Rs. '.$amount.', View More https://bit.ly/3iNx8b0';
                    $message = urlencode($sendmessage);
                    //SendVehicleinoutSMS($mobile_number, $message);
                }
                
               // if(($amount) && ($amount > 0)){


                    $payment_type = 'Cash';

                   // echo "INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time) VALUES('$booking_id','$amount','$payment_type','$vehicle_in_date_time')"; 


                    $con->query("INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time) VALUES('$booking_id','$amount','$payment_type','$vehicle_in_date_time')");
                //}

                header('location:parking-history.php'); 
            } else {
                $error = 'Some Datebase Error';
                //$error = $insert_vehicle;
            }
        } else {
            $error = 'Vehicle Already in Parking';
        }
    } else {
        $error = $vehicle_number.' Vehicle is blocked in our Parking'; 
    }

}

?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vehicle In Process</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vehicle In Process</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
 						<form class="filterform" id="signupForm" method="post" action="" enctype="multipart/form-data" style="margin: auto;">
                            <?php //print_r($block_vechiles);
                            if(isset($error)) {
                                echo '<p style="color:red">'.$error.'</p>';
                                } ?>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Vehicle Number</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="vehicle_number" name="vehicle_number" type="text" value="" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Mobile Number</small></label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="mobile_number" name="mobile_number" type="tel" />
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-5 col-form-label">Vehical Type</label>
                                <div class="col-sm-7">
									<select class="form-control" name="vehicle_type" id="vehicle_type">
										<option value="">Select Vehicle</option>
										<option value="2W">2W</option>
										<option value="3W">3W</option>
										<option value="4W">4W</option>
										<option value="BUS">Bus</option>
										<option value="TRUCK">Truck</option>
										<option value="Staff">Staff</option>
									</select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-5 col-form-label">Amount</label>
                                <div class="col-sm-7">
                                   <input class="form-control" id="amount" name="amount" type="number" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <a class="btn btn-primary waves-effect waves-light active getpricefare" href="javascript:void(0)">Get Price Fare</a>

                                    <button style="display: none;" class="btn btn-primary waves-effect waves-light active vehicle-submit" type="submit" name="submit">Submit</button>

                                    <input class="form-control" id="vendor_id" name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
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

    $(document).ready(function(){
        $(document).on('change', '#vehicle_type', function()
        {
            $('.getpricefare').show();
            $('.vehicle-submit').hide();
        })

    $(document).on('click', '.getpricefare', function()
    {
        var gform = $(this).closest('form');
        var vehicle_number = gform.find('#vehicle_number').val();
        var vendor_id = gform.find('#vendor_id').val();
        var vehicle_type = gform.find('#vehicle_type').val();
        var parking_status = 'In';
        var data = {"vehicle_number" : vehicle_number, "vendor_id" : vendor_id, "vehicle_type" : vehicle_type, "parking_status" : parking_status};

         $.ajax({
           type: "POST",
           url: "<?php echo SITE_URL; ?>customer/get_vehicle_price.php",
           data: {"request" : JSON.stringify(data)},
           beforeSend : function()
           {
             //$('#news_loading1').fadeIn();
           },
           success: function(result)
           {
             var obj = $.parseJSON(result);
             var response  = obj.response;
             if(response.error_code==200){
                gform.find('#amount').val(response.parking_price);
                gform.find('#amount').prop("readonly", false);
                gform.find('.getpricefare').hide();
                gform.find('.vehicle-submit').show();
             } else {
                alert(response.message);
             }
           }
         });

    })
  
    });
</script>


 <!--main content end-->
<?php include 'footer.php' ?>