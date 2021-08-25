<?php

include('config.php');

$user_id = $_REQUEST['userid'];
 
$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
	$row=$select_query->fetch_assoc() ; 

 

?>  
             <div id="user-edit-frm-loading"></div>        
           <form class="cmxform form-horizontal tasi-form" id="edit-user-submit" method="post" action="" enctype="multipart/form-data">
                <input class="form-control" id="id" name="id" type="hidden" value="<?php echo $user_id; ?>" />
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">First Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="first_name" name="first_name" type="text" value="<?php echo $row['first_name']; ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Last Name</label>
                  <div class="col-lg-10">

                    <input class="form-control" id="last_name" name="last_name" type="text" value="<?php echo $row['last_name']; ?>" />
                  </div>
                </div>
                
                 <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email/Username</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="user_email" name="user_email" type="email" value="<?php echo $row['user_email']; ?>" />
                  </div>
                </div>
                <div class="form-group">
 		<?php $user_os = $row['os']; ?>
                  <label for="phone" class="control-label col-lg-2">Select Opreation System</label>
                  <div class="col-lg-10">
                     <select name="os" id="os" class="form-control">
                     <option value="android" <?php if($user_os=='android') { echo 'selected="selected"'; } ?>>Android</option>
                     <option value="ios" <?php if($user_os=='ios') { echo 'selected="selected"'; } ?>>IOS</option>
                    </select>
                  </div>
                </div>
                
               

		<div class="form-group">
                  <label for="date_of_birth" class="control-label col-lg-2">Date of Birth</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="start_date" name="date_of_birth" type="text" value="<?php echo $row['date_of_birth']; ?>" />
                  </div>
                </div>
                
                <!-- <div class="form-group">
                  <label for="wallet_amount" class="control-label col-lg-2">Wallet Amount</label>
                  <div class="col-lg-10">

                    <input class="form-control" id="wallet_amount" name="wallet_amount" type="number" value="<?php //echo $row['wallet_amount']; ?>" />
                  </div>
                </div> -->
           
                
               <!-- <div class="form-group">
                  <label for="password" class="control-label col-lg-2">Password</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="password" name="password" type="password" />
                  </div>
                </div>
                 
                 
               <div class="form-group">
                  <label for="cpassword" class="control-label col-lg-2">Confirm Password</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="cpassword" name="cpassword" type="password" />
                  </div>
                </div> -->
               
               
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-danger" type="submit" name="update">Update</button>
                  </div>
                </div>
              </form>

<script>
 $(document).ready(function() {
 $('#start_date').datepicker({
        format: 'yyyy-mm-dd',
 autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script>