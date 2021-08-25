<?php include 'header.php';

$user_id = $_REQUEST['edit_id'];

 if(isset($_POST['update']))
 {
	 
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$col0 = $_POST['name'];
$col2 = $password;
$col3 = $_POST['os'];
$col4 = $_POST['email'];

$col6 = $_POST['gender'];
$col7 = $_POST['date_of_birth'];
$col8 = $_POST['location'];
$col9 = $_POST['religon_caste'];


if($password!=''){
if($cpassword==$password){
	
$aqled = "update `user` SET name = '".$col0."', email = '".$col4."', password = '".$col2."', os = '".$col3."', gender = '".$col6."', date_of_birth = '".$col7."', location = '".$col8."', religon_caste = '".$col9."' where user_id = '".$user_id."'";
	 $ress = $con->query($aqled);
	 if($ress){
$_SESSION['user_updated'] = 'User Update Successfully';
		header('location:all-users.php');
	 }
} else {
	$error = 'Password Does Not Match Please fill correct Password'; 
}
} else {
	$aqled = "update `user` SET name = '".$col0."', email = '".$col4."', os = '".$col3."', gender = '".$col6."', date_of_birth = '".$col7."', location = '".$col8."', religon_caste = '".$col9."' where user_id = '".$user_id."'";
	$ress = $con->query($aqled);
	 if($ress){
$_SESSION['user_updated'] = 'User Update Successfully';
		 header('location:all-users.php');
	 }
}
	 
} 
    ?>
 
<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            Edit User
                          </header>
                          <div class="panel-body">
                              <div class="form">
                               <?php if(isset($error)) {
				echo '<p style="color:red">'.$error.'</p>';
                                }
                               if(isset($_SESSION['user_updated'])) {
                              echo '<p style="color:green">'.$_SESSION['user_updated'].'</p>';
                              
                               } unset($_SESSION['user_updated']);				
 ?>
                
   <?php $select_query = $con->query("SELECT * FROM `user` where user_id = '".$user_id."'");
	$row=$select_query->fetch_assoc() ; ?>  
                         
           <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="name" name="name" type="text" value="<?php echo $row['name']; ?>" />
                  </div>
                </div>
                
                
               
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email/Username</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="email" name="email" type="email" value="<?php echo $row['email']; ?>" />
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
                
                <div class="form-group ">
                    <label class="control-label col-lg-2" for="title">Gender</label>
                    <div class="col-lg-10">
                    <lable class="col-lg-2">
                      <input type="radio" value="male" name="gender" id="gender" class="" <?php if($row['gender']=='male') { echo 'checked'; } ?>> Male
                      </lable>
                      <lable class="col-lg-2">
                      <input type="radio" value="female" name="gender" id="gender" class="" <?php if($row['gender']=='female') { echo 'checked'; } ?>> Female
                      </lable>
                    </div>
                  </div>

		<div class="form-group">
                  <label for="date_of_birth" class="control-label col-lg-2">Date of Birth</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="start_date" name="date_of_birth" type="text" value="<?php echo $row['date_of_birth']; ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="location" class="control-label col-lg-2">Location</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="location" name="location" type="text" value="<?php echo $row['location']; ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="religon_caste" class="control-label col-lg-2">Religon Caste</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="religon_caste" name="religon_caste" type="text" value="<?php echo $row['religon_caste']; ?>" />
                  </div>
                </div>
                
                
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
                                  
                                  
                              </div>
                          </div>
                      </section>
                  </div>
              </div>
             
          </section>
      </section>
      <!--main content end-->
      <?php  include 'footer.php' ?>