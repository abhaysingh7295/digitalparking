<?php include 'header.php';


if(isset($_POST['submit'])){
	
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
if($cpassword==$password){
	
$col0 = $_POST['display_name'];
 $col1 = $_POST['user_name'];
 $col2 = md5($password);
 $col3 = $_POST['role'];
//echo "SELECT * FROM `login` Where User_name='".$col1."'"; die; 
  $select_user_name = $con->query("SELECT * FROM `login` Where User_name='".$col1."'"); 
	$val_user = $select_user_name->fetch_assoc();
$numrows_username = $select_user_name->num_rows;

if($numrows_username==0) {

$insert_query = $con->query("SET NAMES utf8");
	
$insert_query = "INSERT INTO login(display_name,User_name,Password,Role) VALUES('$col0','$col1','$col2','$col3')";
//echo $insert_query; die; 
if ($con->query($insert_query) === TRUE) {
    header('location:all-users.php');
}
} else {
	$error = 'User Already Exists please try diffrent Username and Email';
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
          <header class="panel-heading"> Add New User </header>
          <div class="panel-body">
            <div class="form">
            <?php if(isset($error)) {
				echo '<p style="color:red">'.$error.'</p>';
				} ?>
            
              <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="first_name" class="control-label col-lg-2">Display Name</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="display_name" name="display_name" type="text" />
                  </div>
                </div>
                
                
               
                <div class="form-group">
                  <label for="user_name" class="control-label col-lg-2">Email/Username</label>
                  <div class="col-lg-10">
                    <input class="form-control" id="user_name" name="user_name" type="email" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="control-label col-lg-2">Role</label>
                  <div class="col-lg-10">
                     <select name="role" id="role" class="form-control">
                      <option value="">Select User Role</option>
                    <option value="administrator">Administrator</option>
                     <option value="editer">Editer</option>
                    </select>
                  </div>
                </div>

		<div class="form-group">
                  <label for="password" class="control-label col-lg-2">Permissions</label>
                  <div class="col-lg-10">
                    <lable class="col-lg-2">
                      <input type="checkbox" value="1" name="permissions[]" id="permissions" class=""> Categories
                      </lable>
                      <lable class="col-lg-2">
                      <input type="checkbox" value="2" name="permissions[]" id="permissions" class=""> Songs
                      </lable>
		     <lable class="col-lg-2">
                      <input type="checkbox" value="3" name="permissions[]" id="permissions" class=""> Songs Images
                      </lable>
                    
		    <lable class="col-lg-2">
                      <input type="checkbox" value="4" name="permissions[]" id="permissions" class=""> Pujan Samagri
                      </lable>
                   
		    <lable class="col-lg-2">
                      <input type="checkbox" value="5" name="permissions[]" id="permissions" class=""> Users
                      </lable>
                    
		   <lable class="col-lg-2">
                      <input type="checkbox" value="6" name="permissions[]" id="permissions" class=""> Settings
                      </lable>
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
                    <button class="btn btn-danger" type="submit" name="submit">Add</button>
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