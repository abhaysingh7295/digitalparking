<?php 
session_start();
include '../config.php';
include '../administration/functions.php';

$site_settings_row = getAdminSettings($con);
 if($site_settings_row['dashboard_logo']==''){
$site_logo = '<span>'.$site_settings_row['site_name'].'</span>';    
} else {
$site_logo = '<img style="width: 20%;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.ADMIN_URL.$site_settings_row['dashboard_logo'].'" />';
}
if(isset($_POST['submit'])){
    
   // reCAPTCHA validation
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

                // Google secret API
                $secretAPIkey = '6LexNcgaAAAAAFMEYPaw8LjmwxGie3iCmiK8jhGv';

                // reCAPTCHA response verification
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

    
   
        
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    $email = $_POST['email'];
    
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['forget_time'] = time();
    $_SESSION['forget_successfully'] = 'Invalid email format please try to correct email address.';
    $_SESSION['forget_alert'] = 'alert-danger';
    	
    } else {
    if($cpassword==$password){
    
    $password = $password;
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_role = 'vandor';
    $user_status  = 1;
    $register_date  = date('Y-m-d h:i:s');
    
    $social_type  = 'simple';
    $os  = 'android';
    $mobile_number  = $_SESSION['verify_mobile'];
    $date_of_birth  = '';

 $reflength = 10;
 $refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 $referral_code = substr( str_shuffle( $refchars ), 0, $reflength );
               
 	$select_user_name = $con->query("SELECT * FROM `pa_users` Where user_email='".$email."'"); 
	$val_user = $select_user_name->fetch_assoc();
	$numrows_username = $select_user_name->num_rows;

	if($numrows_username==0) {

		$insert_query = "INSERT INTO pa_users(user_email,user_pass,first_name,last_name,mobile_number,user_role,date_of_birth,os,social_type,user_status,register_date,referral_code) VALUES('$email','$password','$first_name','$last_name','$mobile_number','$user_role','$date_of_birth','$os','$social_type','$user_status','$register_date','$referral_code')";
		if ($con->query($insert_query) === TRUE) {
			$user_id = $con->insert_id;
			$amount = 50;
			$num0 = (rand(10,100));
			$num1 = date("Ymd");
			$num2 = (rand(100,1000));
			$transaction_id = $num0 . $num1 . $num2;
			$transaction_type = 'Trial';
			$transaction_remarks = 'New Vendor Registration Trial Amount '.$amount.'Rs / Ref. '. $transaction_id. ' / 15 Days';
			$wallet_date = date('Y-m-d H:i:s');
			$amount_type = 'Dr';
			$con->query("INSERT INTO `wallet_history` (user_id,amount,amount_type,transaction_id,transaction_type,wallet_date,transaction_remarks) VALUES ('$user_id','$amount','$amount_type','$transaction_id','$transaction_type','$wallet_date','$transaction_remarks')");
			$con->query("update `pa_users` SET wallet_amount = '".$amount."' where id = ".$user_id);
            check_vender_bowser($con,$user_id);
            $_SESSION['forget_time'] = time();
            $_SESSION['forget_successfully'] = 'Registration Successfully';
            $_SESSION['forget_alert'] = 'alert-success';
 
		} else {
		$_SESSION['forget_time'] = time();
        $_SESSION['forget_successfully'] =  'Some occurred error';
        $_SESSION['forget_alert'] = 'alert-danger';
		}
	} else{
	$_SESSION['forget_time'] = time();
    $_SESSION['forget_successfully'] =  'Email already Registered';
    $_SESSION['forget_alert'] = 'alert-danger';
	}

} else {
    $_SESSION['forget_time'] = time();
    $_SESSION['forget_successfully'] = 'Password Not matched please try again.';
    $_SESSION['forget_alert'] = 'alert-danger';
 
}

}

}
 else{ 
     $_SESSION['forget_time'] = time();
    $_SESSION['forget_successfully'] = 'Plese check on the reCAPTCHA box.';
    $_SESSION['forget_alert'] = 'alert-danger';
               
            } 
    
}


         
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Vendor Signup | <?php echo $site_settings_row['site_name'];  ?></title>
        <?php if($site_settings_row['favicon_logo']!=''){ ?>
          <link rel="shortcut icon" type="image/png" href="<?php echo ADMIN_URL; ?><?php echo $site_settings_row['favicon_logo']; ?>"/>
       <?php } ?>
        <link href="<?php echo ADMIN_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
       <!--  <div class="home-btn d-none d-sm-block">
                <a href="index.html" class="text-white"><i class="fas fa-home h2"></i></a>
            </div> -->
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="index.php" class="logo logo-admin"><?php echo $site_logo; ?></a>
                        </div>
                        <h5 class="font-18 text-center">Signup to <?php echo $site_settings_row['site_name'];  ?>.</h5>
                            
                        <form class="form-horizontal m-t-30" action="" id="SignUpForm" method="post">
                            
                          	<?php if(isset($_SESSION['forget_time'])) { ?>
                            <div class="alert <?php echo $_SESSION['forget_alert']; ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $_SESSION['forget_successfully']; ?>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>First Name</label>
                                    <input class="form-control" type="text" required="" name="first_name" placeholder="First Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Last Name</label>
                                    <input class="form-control" type="text" required="" name="last_name" placeholder="Last Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Mobile Number</label>
                                    <input class="form-control" type="text" required="" name="mobile_number" readonly="" value="<?php if(isset($_SESSION['verify_mobile'])){ echo $_SESSION['verify_mobile'] ;}?>" placeholder="Mobile Number">
                                </div>
                            </div>
 

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Email</label>
                                    <input class="form-control" type="email" required="" name="email" placeholder="Email">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Password</label>
                                    <input class="form-control" type="password" required="" name="password" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Confirm Password</label>
                                    <input class="form-control" type="password" required="" name="cpassword" placeholder="Confirm Password">
                                </div>
                            </div>

                            <?php /* ?>
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Parking Name</label>
                                    <input class="form-control" type="text" required="" name="parking_name" placeholder="Parking Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Parking Type</label>
                                    <input class="form-control" type="text" required="" name="parking_type" placeholder="Parking Type">
                                </div>
                            </div>

                             <div class="form-group">
                                <div class="col-12">
                                        <label>Address</label>
                                    <input class="form-control" type="text" required="" name="address" placeholder="Address">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Landmark</label>
                                    <input class="form-control" type="text" required="" name="landmark" placeholder="Landmark">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>State</label>
                                    <input class="form-control" type="text" required="" name="state" placeholder="State">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                        <label>City</label>
                                    <input class="form-control" type="text" required="" name="city" placeholder="City">
                                </div>
                            </div>
                            <?php */?>
                           <!--<input type="email" name="email" placeholder="Type your email" size="40"><br><br>-->
                               <div class="form-group">
                            <!-- Google reCAPTCHA block -->
                            <div class="g-recaptcha" data-sitekey="6LdINcgaAAAAAJ58BjX7cf1ns53Vc8k1Wi7F4nHm"></div>
                          </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" name="submit" type="submit">Signup</button>
                                </div>
                            </div>
    
                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-7">
                                    <a href="login.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Log In</a>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <!-- <a href="pages-register.html" class="text-muted">Create an account</a> -->
                                </div>
                            </div>
                        </form>
                        <?php include 'help-support.php'; ?>
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!--<script src="https://www.google.com/recaptcha/api.js?render=6Lc0L8gaAAAAABEoVDovv6Ykh0IigXS8fVB79ZR5"></script>-->
        <script src="<?php echo ADMIN_URL; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/metismenu.min.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo ADMIN_URL; ?>assets/js/waves.min.js"></script>
      <!-- Google reCaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
<!--//       <script>-->
//       // when form is submit
//     $('#SignUpForm').submit(function() {
//         // we stoped it
//         event.preventDefault();
//         var email = $('#email').val();
//       // var comment = $("#comment").val();
//         // needs for recaptacha ready
//         grecaptcha.ready(function() {
//             // do request for recaptcha token
//             // response is promise with passed token
//             grecaptcha.execute('6Lc0L8gaAAAAABEoVDovv6Ykh0IigXS8fVB79ZR5', {action: 'create_comment'}).then(function(token) {
//                 // add token to form
               
//                 $('#SignUpForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
//                  document.getElementById('theForm').submit();
//                     // $.post("form.php",{email: email, token: token}, function(result) {
//                     //         console.log(result);
//                     //         if(result.success) {
//                     //                 alert('Thanks for posting comment.')
//                     //         } else {
//                     //                 alert('You are spammer ! Get the @$%K out.')
//                     //         }
//                     // });
//             });;
//         });
<!--//   });-->
<!--  </script>-->
        <!-- App js -->
        <script src="<?php echo ADMIN_URL; ?>assets/js/app.js"></script>
        <!--script type="text/javascript">
            $(document).ready(function(){

                function getFormData($form){
                    var unindexed_array = $form.serializeArray();
                    var indexed_array = {};
                    $.map(unindexed_array, function(n, i){
                        indexed_array[n['name']] = n['value'];
                    });
                    return indexed_array;
                }

                $('#SignUpForm').submit(function(e){
                    e.preventDefault();
                    var formdata = getFormData($(this));
                    var action  = $(this).attr('action');
                      $.ajax({
                        url: action,
                        type: 'POST',
                        data: {"request" : JSON.stringify(formdata)},
                        beforeSend:function()
                        {
                        },
                        success: function(result){
                            var obj = $.parseJSON(result); 
                             var response  = obj.response;
                            console.log(response);
                            if(response.error_code==200){
                                 alert(response.message);
                                window.location.href = "signup.php";
                            } else {
                                alert(response.message);
                            }
                        }
                    });  
                })
            })
        </script-->

    </body>

</html>