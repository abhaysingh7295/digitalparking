<?php include 'header.php';

if(isset($_POST['submit'])){
	
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
if($cpassword==$password){
	
$col0 = $_POST['first_name'];
$col00 = $_POST['last_name'];
 $col1 = $_POST['email'];
 $col2 = $password;
 $col3 = date('Y-m-d');
$col4 = 'simple';
$col5 = $_POST['os'];
 
$col7 = $_POST['date_of_birth'];
 
/* Genrate Referral Code Start */

   $reflength = 10;
    $refchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $referral_code = substr( str_shuffle( $refchars ), 0, $reflength );

/* Genrate Referral Code End */

  $select_user_name = $con->query("SELECT * FROM `pa_users` Where user_email='".$col1."'"); 
	$val_user = $select_user_name->fetch_assoc();
$numrows_username = $select_user_name->num_rows;

if($numrows_username==0) {

$insert_query = $con->query("SET NAMES utf8");
	
$insert_query = "INSERT INTO pa_users(first_name,last_name,user_email,user_pass,os,social_type,register_date,date_of_birth,referral_code,user_role) VALUES('$col0','$col00','$col1','$col2','$col5','$col4','$col3','$col7','$referral_code','vandor')";

if ($con->query($insert_query) === TRUE) {
    header('location:all-users.php');
}
} else {
	$error = 'User Already Exists please try different Username and Email';
	}
} else {
	
	$error = 'Password Does Not Match Please fill correct Password'; 
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
          <header class="panel-heading"> Add New Vendor </header>
          <div class="panel-body">
            <div class="form">
            <?php if(isset($error)) {
				echo '<p style="color:red">'.$error.'</p>';
				} ?>
            
              <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">First Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="first_name" name="first_name" type="text" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Last Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="last_name" name="last_name" type="text" />
                  </div>
                </div>
                
               
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email/Username</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="email" name="email" type="email" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="control-label col-lg-2">Select Opreation System</label>
                  <div class="col-lg-10">
                     <select name="os" id="os" class="form-control">
                     <option value="android">Android</option>
                     <option value="ios">IOS</option>
                    </select>
                  </div>
                </div>
 

		<div class="form-group">
                  <label for="date_of_birth" class="control-label col-lg-2">Date of Birth</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="start_date" name="date_of_birth" type="text" />
                  </div>
                </div>
                

                <div class="form-group">
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
                </div>
               
               
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-danger" type="submit" name="submit">Submit</button>
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
<?php include 'footer.php' ?>