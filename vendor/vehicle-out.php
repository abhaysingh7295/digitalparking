<?php include 'header.php';

if(isset($_POST['submit'])){
    //echo "<pre>";  print_r($_POST['submit']); die("Hello");
	$vendor_id = $_POST['vendor_id'];
    $vehicle_number = $_POST['vehicle_number'];
    $mobile_number = $_POST['mobile_number'];
    $amount = $_POST['due_parking_amount'];
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_out_date_time = time();
    $vehicle_status = 'Out';
	$booking_id = $_POST['booking_id'];

    $select_vehicle = $con->query("SELECT * FROM `vehicle_booking` Where vendor_id='".$vendor_id."' AND vehicle_number='".$vehicle_number."' AND vehicle_status='In'");
    if($select_vehicle->num_rows==1) {
    	$update_query = "update `vehicle_booking` SET vehicle_out_date_time = '".$vehicle_out_date_time."', vehicle_status = '".$vehicle_status."' where id = ".$booking_id.""; 
    	if ($con->query($update_query) === TRUE) {
            SensitiveVechilesNotify($con,$vendor_id,$vehicle_number,$booking_id);
            OutPreBookingVechile($con,$vendor_id,$vehicle_number);

            if(($mobile_number) && ($active_plans_row['sms_notification']==1)){
                $vendor_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as vendor_name, parking_name FROM pa_users WHERE id = ".$vendor_id."");
                $vendor_ow=$vendor_query->fetch_assoc();

                $customer_id = $val_vehicle_id['customer_id'];
                $customer_name = '';
                if($customer_id!=0){
                    $customer_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as customer_name FROM pa_users WHERE id = ".$customer_id.""); 
                    $customer_row=$customer_query->fetch_assoc();
                    $customer_name = $customer_row['customer_name'].' ';
                }
                
                $parking_name = $vendor_ow['parking_name'];
                $vehicle_out_date_time_forAPi = date('Y-m-d h:i A',$vehicle_out_date_time);
                $sendmessage = $customer_name.'|'.$vehicle_number.' '.$vehicle_type.'|'.$parking_name.'|'.$vehicle_out_date_time_forAPi.'|'.$amount.'|';
                
                // $sendmessage = 'Hello, '.$customer_name.'Your vehicle '.$vehicle_number.' '.$vehicle_type.' successfully out from '.$vendor_ow['parking_name'].' on '.date('Y-m-d h:i A',$vehicle_out_date_time).', Rs. '.$amount.', View More https://bit.ly/3iNx8b0';
                // $message = urlencode($sendmessage);
                SendSMSNotification($mobile_number, $message);
            }
            
    		//if($amount > 0){
    			$payment_type='Cash';
    			$con->query("INSERT INTO payment_history(booking_id,amount,payment_type,payment_date_time) VALUES('$booking_id','$amount','$payment_type','$vehicle_out_date_time')");
    		//}
    		header('location:parking-history.php'); 
    	} else {
    		$error = 'Some Datebase Error';
    	}
    } else {
    	$error = 'Vehicle not found in parking';
    }

}
 ?>


<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vehicle Out Process</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vehicle Out Process</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">

                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body vehicle-out-card-body">
                        	<?php if(isset($error)) {
                                echo '<p style="color:red">'.$error.'</p>';
                                } ?>
                                
 						<form class="" id="VehicleForm" method="post" action="ajax-vehicle-out.php" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Vehicle Number</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="vehicle_number" name="vehicle_number" type="text" value="" />
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-primary waves-effect waves-light active vehicle-submit" type="submit" name="submit">Get Details</button>
                                    <input class="form-control" id="vendor_id" name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
                                    <input class="form-control" id="action" name="action" type="hidden" value="get_vehicle_details" />
                                </div>
                            </div>
                        </form>


                        </div>
               
                        <div class="card-body vehicle-out-card-body">
 						<form class="" id="vehicle-out-submit" method="post" action="" enctype="multipart/form-data" style="display: none;">
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Mobile Number</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_mobile_number" name="mobile_number" type="text" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Vehicle Number</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_vehicle_number" name="vehicle_number" type="text" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Vehicle Type</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_vehicle_type" name="vehicle_type" type="text" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">In Time</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_vehicle_in_time" name="vehicle_in_time" type="text" value="" readonly="readonly" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Out Time</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_vehicle_out_time" name="vehicle_out_time" type="text" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Total Parking Amount</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_total_parking_amount" name="total_parking_amount" type="number" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-5 col-form-label">Due Parking Amount</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="get_due_parking_amount" name="due_parking_amount" type="number" value="" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit">Finish</button>
                                    <input class="form-control" id="vendor_id" name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
                                    <input class="form-control" id="get_booking_id" name="booking_id" type="hidden" value="" />
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
		$('#VehicleForm').submit(function(e){
			e.preventDefault();
		    var formdata =  $(this).serialize();
		    var action  = $(this).attr('action');
		    var vehicle_out_form = $('#vehicle-out-submit');
		    vehicle_out_form.hide();
			$.ajax({
				url: action,
				type: 'POST',
				data: formdata,
				beforeSend:function()
				{
				},
				success: function(result){
					var obj = $.parseJSON(result); 
					if(obj.error_code==200){
						vehicle_out_form.find('#get_booking_id').val(obj.booking_id);
						vehicle_out_form.find('#get_mobile_number').val(obj.mobile_number);
						vehicle_out_form.find('#get_vehicle_number').val(obj.vehicle_number);
						vehicle_out_form.find('#get_vehicle_type').val(obj.vehicle_type);
						vehicle_out_form.find('#get_vehicle_in_time').val(obj.vehicle_in_date_time);
						vehicle_out_form.find('#get_vehicle_out_time').val(obj.vehicle_out_date_time);
						vehicle_out_form.find('#get_total_parking_amount').val(obj.total_parking_price);
						vehicle_out_form.find('#get_due_parking_amount').val(obj.due_parking_price);
						vehicle_out_form.show();
					} else {

						 alert(obj.message);
					}
				
				}
			});
		})

	})

	/*$('#setReminderForms').submit(function(e){
   var claim_id = $('#claim_id').val();
    e.preventDefault();
    var formdata =  $(this).serialize();
    var action  = $(this).attr('action');
      $('.ajax-response').html('');
        $.ajax({
          url: action,
          type: 'POST',
          data: formdata,
          beforeSend:function()
          {
            $('#news_loading1').fadeIn();
            $('button').attr('disabled', true);
          },
          success: function(result){
            var obj = $.parseJSON(result); 
            $('.reminder-response').html(obj.message);
            if(obj.status==1){
              $('#setReminderForms')[0].reset(); 
              $('#myModalSetReminder').modal('hide');
              loadData(claim_id);
            }
            $('button').attr('disabled', false);  
            $('#news_loading1').fadeOut();
 
          }
        });
  })*/


</script>
<?php include 'footer.php'; ?>