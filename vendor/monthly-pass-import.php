<?php include 'header.php'; 

  $error = '';
  $sucess = '';

function checkDateformate($date){ 
  if (preg_match("/\d{2}\-\d{2}-\d{4}/", $date)) {
      $return = 'true';
  } else {
      $return = 'false';
  }
  return $return;
}



if(isset($_POST['submit'])){
  $pass_issued_date = time();
  $vendor_id = $_POST['vendor_id'];
  
  $MONTHLY_TEMP_DIR = 'monthlypass/'.$vendor_id.'/';
  if (!file_exists($MONTHLY_TEMP_DIR)){
     mkdir($MONTHLY_TEMP_DIR,0777, true); 
  }
    $error_mobile_number = array();
    $fileName = $_FILES["monthly_pass_csv"]["tmp_name"];
    $row = 1;
    $error_skip_dates = 0;
    if ($_FILES["monthly_pass_csv"]["size"] > 0) {
      $file = fopen($fileName, "r");
      while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
        if($row == 1){ $row++; continue; }
        $vehicle_number = $column[0];
        $vehicle_type = $column[1];
        $company_name = $column[2];
        $mobile_number = $column[3];
        $amount = $column[4];
        $start_date = $column[5];
        $end_date = $column[6];
        $payment_type = $column[7];
        $status = $column[8];

        if(checkDateformate($start_date)=='true' && checkDateformate($end_date)=='true'){
          $select_user_name = $con->query("SELECT id FROM `pa_users` Where mobile_number='".$mobile_number."' AND user_role = 'customer'"); 
          $numrows_username = $select_user_name->num_rows;
            if($numrows_username==1) {
              $val_user = $select_user_name->fetch_assoc();
              $customer_id = $val_user['id'];
            } else {
              $user_role = 'customer';
              $user_status  = 1;
              $register_date  = date('Y-m-d h:i:s');
              $social_type  = 'simple';
              $os = 'android';
              $reflength = 10;
              $refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
              $referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
              $insert_query = "INSERT INTO pa_users(mobile_number,user_role,os,social_type,user_status,register_date,referral_code) VALUES('$mobile_number','$user_role','$date_of_birth','$os','$user_status','$register_date','$referral_code')";
              if ($con->query($insert_query) === TRUE) {
                $customer_id = $con->insert_id;
              }
            }

            $select_monthly_pass = $con->query("SELECT id FROM `monthly_pass` Where vehicle_number='".$vehicle_number."' AND customer_id='".$customer_id."'");
            if($select_monthly_pass->num_rows==0) {
              $insert_query = "INSERT INTO monthly_pass(vendor_id,customer_id,vehicle_number,vehicle_type,company_name,mobile_number,amount,start_date,end_date,pass_issued_date,payment_type,status) VALUES('$vendor_id','$customer_id','$vehicle_number','$vehicle_type','$company_name','$mobile_number','$amount','$start_date','$end_date','$pass_issued_date','$payment_type','$status')";
              if ($con->query($insert_query) === TRUE) {
                $ref_id = $con->insert_id;
                $ref_type = 'monthly_pass';
                GenrateVechileQRcodes($con,$ref_id,$ref_type);
              } 
            } else {
              $val_monthly_pass = $select_monthly_pass->fetch_assoc();
              $monthly_pass_id = $val_monthly_pass['id'];
              $con->query("update `monthly_pass` amount = '".$amount."', payment_type = '".$payment_type."', start_date = '".$start_date."', end_date = '".$end_date."', status = '".$status."' where id = ".$monthly_pass_id."");
            }
        } else {
          $error_skip_dates = $row + $error_skip_dates;
        }
      }
      
      if($error_skip_dates > 0){
        $error = $error_skip_dates.' Monthly Pass Skip';
      } else {
        $sucess = 'CSV Import Complete';
      }

    } else {
      $error = 'Some occurred error';
    }
 
}

?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title"> Import Monthly Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active"> Import Monthly Pass</li>
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
                            <?php if($error){ ?>
                              <p style="color: red;"><?php echo $error; ?></p>
                            <?php } ?>
                            <?php if($sucess){ ?>
                              <p style="color: green;"><?php echo $sucess; ?></p>
                            <?php } ?>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Import CSV File</label>
                                <div class="col-sm-10">
                                        <input name="monthly_pass_csv" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit">Import</button>
                                </div>
                            </div>

                            <input name="vendor_id" type="hidden" value="<?php echo $current_user_id; ?>" />
                             </form>

                             <a href="monthly-pass-sample.csv" download class="btn btn-success">Download Sample CSV</a>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>

 <!--main content end-->
<?php include 'footer.php' ?>