<?php include('../config.php');

$user_id = $_REQUEST['userid'];
 
$select_query = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
$row=$select_query->fetch_assoc() ; 

 

?>  
             <div id="user-edit-frm-loading"></div>        
           <form class="cmxform form-horizontal tasi-form" id="edit-user-submit" method="post" action="" enctype="multipart/form-data">
                <input class="form-control" id="id" name="id" type="hidden" value="<?php echo $user_id; ?>" />
                 <input class="form-control" id="os" name="os" type="hidden" value="android" />

                <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                  <div class="col-sm-10">
                     <input class="form-control" id="first_name" name="first_name" type="text" value="<?php echo $row['first_name']; ?>" />
                  </div>
              </div>

              <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label">Last Name</label>
                  <div class="col-sm-10">
                     <input class="form-control" id="last_name" name="last_name" type="text" value="<?php echo $row['last_name']; ?>" />
                  </div>
              </div>

              <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label">Email/Username</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="user_email" readonly="readonly" name="user_email" type="email" value="<?php echo $row['user_email']; ?>" />
                  </div>
              </div>

               <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mobile_number" readonly="readonly" name="mobile_number" type="text" value="<?php echo $row['mobile_number']; ?>" />
                  </div>
              </div>

              <div class="form-group row">
                  <label for="example-text-input" class="col-sm-2 col-form-label">Date of Birth</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="start_date" name="date_of_birth" type="text" value="<?php echo $row['date_of_birth']; ?>" />
                  </div>
              </div>
              
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-danger" type="submit" name="update">Update</button>
                  </div>
                </div>
              </form>

<!-- <script>
 $(document).ready(function() {
 $('#start_date').datepicker({
        format: 'yyyy-mm-dd',
 autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});
})
</script> -->