<?php include 'header.php'; 
 
  $status=1;
  $id = $_GET['id'];
  $s_msg="";
  $e_msg="";
  if (isset($_GET['vehicle_no']) && $_GET['vehicle_no']!='' )
  {
       $vehicle_no= $_GET['vehicle_no'];
       $select_query = $con->query("SELECT * FROM `monthly_pass` WHERE vehicle_number =  '". $vehicle_no."' AND vendor_id = '".$current_user_id."'  ORDER BY `monthly_pass`.`id` DESC");
       $row=$select_query->fetch_assoc();
       $id=$row['id'];
      
  }
  else
  {
  $select_query = $con->query("SELECT * FROM `monthly_pass` WHERE id = ".$id." AND vendor_id = '".$current_user_id."'");
  $row=$select_query->fetch_assoc();
  }
  $vendor_id = $row['vendor_id'];
  $customer_id = $row['customer_id'];
  $vehicle_number = $row['vehicle_number'];
  $vehicle_type = $row['vehicle_type'];
  $company_name = $row['company_name'];
  $mobile_number = $row['mobile_number'];
  $amount = $row['amount'];
  $start_date = $row['start_date'];
  $end_date = $row['end_date'];
  $o_grace_date = $row['grace_date'];
  $o_grace_date1 = strtotime($row['grace_date']);
 
  $payment_type = $row['payment_type'];
  $status = $row['status'];
  $pass_issued_date = $row['pass_issued_date'];

  $monthlypassdir = 'monthlypass/'.$current_user_id.'/';
  $new_user_image = $row['user_image'];
  $user_image = $monthlypassdir.$new_user_image;
  $new_vehicle_image = $row['vehicle_image'];
  $vehicle_image = $monthlypassdir.$new_vehicle_image;

  $disablefileds = 'readonly="readonly"';
 



if(isset($_POST['submit'])){
    
  $eid = $_POST['id'];
  $vendor_id = $_POST['vendor_id'];
  $customer_id = $_POST['customer_id'];
  $vehicle_number = $_POST['vehicle_number'];
  $vehicle_type = $_POST['vehicle_type'];
  $company_name = $_POST['company_name'];
  $mobile_number = $_POST['mobile_number'];
  $amount = $_POST['amount'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $pass_issued_date = time();
  $o_start_date = $start_date;
  $o_end_date= $end_date;
 
  $new_user_image = $_POST['new_user_image'];
  $new_vehicle_image = $_POST['new_vehicle_image'];

  $payment_type = $_POST['payment_type'];
 
    $status = $_POST['status'];
    $qr_code = $_POST['qr_code'];
    
    $grade_date= $_POST['grade_date'];
 
    $g_date='';
    
    $today=date("Y-m-d");
    $curdate=strtotime($today);
    $edate=strtotime($end_date);
  
    $row_end_date= strtotime($row['end_date']);
    
    if($o_grace_date1!='')
    {
        $expiry_date = $o_grace_date1;
    }
    else
    {
        $expiry_date = $row_end_date;
    }
     
    //if ($row_end_date>=$curdate) 
     if ($expiry_date >=$curdate) 
      {
         $e_msg="Already Activated";
      }
    /**  else if()
      {
          
      }***/
     else
     {
         

       if ( $grade_date!='' )
        {
            $status=1;
           
            $date=date_create( $end_date);
            $start_date=date_format($date,"Y-m-d");
            date_add($date,date_interval_create_from_date_string(" $grade_date days"));
            $g_date= date_format($date,"Y-m-d");
            if($g_date!='')
            {
                $end_date=$o_end_date;
                $start_date= $o_start_date;
            }
            else
            {
                 $end_date=date_format($edate,"Y-m-d");
                  $start_date=date_format($date,"Y-m-d");
            }
          
           $s_msg="Grace Added Successfully";
           
          
            
        }  
        else  if ($curdate>$row_end_date &&  $edate>$curdate )    
          {
               $status=1;
               $s_msg="Pass update successfully";
               

            //   redirect(all-monthly-pass.php)
               
          }

        
     }
      
      
   
   

    $insert_query = $con->query("SET NAMES utf8");
   
   //$insert_query = "INSERT INTO monthly_pass(vendor_id,customer_id,vehicle_number,vehicle_type,company_name,mobile_number,amount,start_date,end_date,pass_issued_date,payment_type,user_image,vehicle_image,status) VALUES('$vendor_id','$customer_id','$vehicle_number','$vehicle_type','$company_name','$mobile_number','$amount','$start_date','$end_date','$pass_issued_date','$payment_type','$new_user_image','$new_vehicle_image','$status')";
   $insert_query = "INSERT INTO monthly_pass(vendor_id,customer_id,vehicle_number,vehicle_type,company_name,mobile_number,amount,start_date,end_date,pass_issued_date,grace_date,payment_type,user_image,vehicle_image,status) VALUES('$vendor_id','$customer_id','$vehicle_number','$vehicle_type','$company_name','$mobile_number','$amount','$o_start_date','$o_end_date','$pass_issued_date','$g_date','$payment_type','$new_user_image','$new_vehicle_image','$status')";

// echo $insert_query; exit;

 // echo  $insert_query = "update `monthly_pass` SET amount = '".$amount."', payment_type = '".$payment_type."', start_date = '".$start_date."',pass_issued_date='".$pass_issued_date."', end_date = '".$end_date."',grace_date='".$g_date."' , status = '".$status."' where id = ".$id."";
    if ($e_msg=='') { 
      if ($con->query($insert_query) === TRUE) {
        if($mobile_number){
            $customer_name = '';
            if($customer_id!=0){
                $customer_query = $con->query("SELECT CONCAT_WS(' ', first_name,last_name) as customer_name FROM pa_users WHERE id = ".$customer_id.""); 
                $customer_row=$customer_query->fetch_assoc();
                $customer_name = $customer_row['customer_name'].' ';
            }

            if($status==2){
              $statusname = 'Applied';
            } else if($status==1){
              $statusname = 'Active';
            } else {
              $statusname = 'Expired';
            }
            
              $parking_name = $admin_login_row['parking_name'];
            
            $sendmessage = $vehicle_number.' '.$vehicle_type.'|'.$parking_name.'|'.$pass_issued_date.'|';
            // $sendmessage = 'Hello, '.$customer_name.'Your vehicle pass '.$vehicle_number.' '.$vehicle_type.' has been '.$statusname.' at '.$admin_login_row['parking_name'].' on '.date('Y-m-d',$pass_issued_date).', View More https://bit.ly/3iNx8b0';
            
            $message = urlencode($sendmessage);
              if($statusname = 'Active'){
                SendSMSNotificationActive($mobile_number, $sendmessage);
            }
            
           else if($statusname = 'Expired'){
                SendSMSNotificationExpired($mobile_number, $sendmessage);
            }
                        //   SendSMSNotificationActive($mobile_number, $sendmessage);

           // SendSMSNotification($mobile_number, $message);
          }

        header('location:all-monthly-pass.php');
      } else {
         $error = 'Some Database Issue';
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
                        <h4 class="page-title"> Renew Monthly Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active"> Renew Monthly Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                 <?php if ($s_msg!='') { echo $s_msg; } ?>
                  <?php if ($e_msg!='') { echo $e_msg; } ?>
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
 						<form class="" id="signupForm" method="post" action="" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Number<?php echo $id ?></label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="vehicle_number" name="vehicle_number" type="text" value="<?php echo $vehicle_number ; ?>" required="required" <?php echo $disablefileds; ?> />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Type</label>
                                <div class="col-sm-10">
                                   
                                    <input class="form-control" id="vehicle_type" name="vehicle_type" type="text" value="<?php echo $vehicle_type; ?>" required="required" <?php echo $disablefileds; ?> />
                                  
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
									<input class="form-control" id="mobile_number" name="mobile_number" type="tel" value="<?php echo $mobile_number; ?>" />
									<!--<?php echo $disablefileds; ?> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
									<!--<input class="form-control" id="amount" name="amount" type="number" value="<?php echo $amount; ?>" required="required" />-->
									<input class="form-control" id="amount" name="amount" type="number" value="" required="required" />
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">From Date</label>
                                <div class="col-sm-10">
                                  <!-- <input class="form-control" id="start_date_m" name="start_date" type="text" value="<?php echo $start_date; ?>" required="required" />-->

                                      <input class="form-control" id="start_date_m" name="start_date" type="text" value="" required="required" />
                                      </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">To Date</label>
                                <div class="col-sm-10">
                                  <!---  <input class="form-control" id="end_date_m" name="end_date" type="text" value="<?php echo $end_date; ?>" required="required" />--->
                                    <input class="form-control" id="end_date_m" name="end_date" type="text" value="" required="required" />
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Grace Period</label>
                                <div class="col-sm-10">
                                   
                                    <select  name="grade_date">
                                         <option value=""></option>
                                         <?php for ($i=1;$i<31;$i++) { ?>
                                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                         <?php } ?>
                                </select>         
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Payment Type</label>
                                <div class="col-sm-10">
                                    
                                     <select name="payment_type" class="form-control" required="required" >
                                        <option <?php if($payment_type=='Cash') { echo 'selected="selected"'; } ?> value="Cash">Cash</option>
                                        <option <?php if($payment_type=='Online') { echo 'selected="selected"'; } ?> value="Online">Online</option>
                                        <option  <?php if($payment_type=='Bank Transfer') { echo 'selected="selected"'; } ?>value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                  
                                </div>
                            </div>

                            <!--<?php if($new_user_image){ ?>-->
                            <!--<div class="form-group row">-->
                            <!--    <label for="example-email-input" class="col-sm-2 col-form-label">User Image</label>-->
                            <!--    <div class="col-sm-10">-->
                            <!--        <img style="width: 10%;" alt="" src="<?php echo $user_image; ?>">    -->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<?php } ?>-->
                            <!-- <?php if($new_vehicle_image){ ?>-->
                            <!--<div class="form-group row">-->
                            <!--    <label for="example-email-input" class="col-sm-2 col-form-label">Vehicle Image</label>-->
                            <!--    <div class="col-sm-10">-->
                            <!--      <img style="width: 10%;" alt="" src="<?php echo $vehicle_image; ?>"> -->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<?php } ?>-->
                            
                            <!--<div class="form-group row">-->
                            <!--    <label for="example-email-input" class="col-sm-2 col-form-label">Status</label>-->
                            <!--    <div class="col-sm-10">-->
                            <!--        <select name="status" class="form-control" required="required">-->
                            <!--            <option <?php if($status==2) { echo 'selected="selected"'; } ?> value="2">Applied</option>-->
                            <!--            <option <?php if($status==1) { echo 'selected="selected"'; } ?> value="1">Active</option>-->
                            <!--            <option <?php if($status==0) { echo 'selected="selected"'; } ?> value="0">Expired</option>-->
                            <!--        </select>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit">Submit</button>
                                </div>
                            </div>

                            <?php $select_qr = $con->query("SELECT qr_code FROM `vehicle_qr_codes` Where ref_id=".$id." AND ref_type='monthly_pass'"); 
                            $qr_code_row = $select_qr->fetch_assoc();
                            $qr_code = $qr_code_row['qr_code'];

                            ?>
                            <input name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
                             <input name="customer_id" type="hidden" value="<?php echo $customer_id; ?>" />
                             <!--<input name="new_user_image" type="hidden" value="<?php echo $new_user_image; ?>" />-->
                             <!--<input name="new_vehicle_image" type="hidden" value="<?php echo $new_vehicle_image; ?>" />-->
                             <input name="qr_code" type="hidden" value="<?php echo $qr_code; ?>" />
                            <input name="id" type="hidden" value="<?php echo $id; ?>" />
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
 $('#start_date_m,#end_date_m').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script>
 <?php if ($s_msg!='') { ?>
    <script>
        function redirect1()
             {
                 window.location.href = "https://thedigitalparking.com/digital-parking/vendor/all-monthly-pass.php";
                 
             }
                 setTimeout(function(){ redirect1(); }, 3000); 
    </script>
 <?php } ?>


 <!--main content end-->
<?php include 'footer.php' ?>