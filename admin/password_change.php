<?php session_start();

include 'config.php';

if(isset($_POST['submit']))
{ 
//$old_password=$_POST['old_password'];
$old_password=MD5($_POST['old_password']);
$new_password=MD5($_POST['new_password']);
$confirm_password=MD5($_POST['confirm_password']);

     $email_check = $con->query("select * from login where Password='".$old_password."' AND Id='".$_SESSION["current_user_ID"]."'");
	 $count = mysql_num_rows($email_check);
	 echo $count;
	 if($count){
		 if($new_password!=$confirm_password){
			  echo "<script> alert('Password Do Not Match')</script>";
			 }else{
		 $con->query("update login set Password='".$new_password."' where Password='".$old_password."' AND Id='".$_SESSION["current_user_ID"]."'");
		 /*$email = 'rakeshjangir0403@gmail.com';
		 $subject = "login Information";
		 $message = "Your password has been changed to $email";
		 $form = "From:abc123@gmail.com";
		 
		mail($email,$subject,$message,$form);*/
		 
		 echo "<script> alert('Your new password has been change.')</script>";
	 }
}else{echo "<script> alert('Your Old password has been Wrong.')</script>";}
		 
		 }


?>
<?php include 'header.php'; ?>
<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            Update Password
                          </header>
                          <div class="panel-body">
                              <div class="form">
                              <form action="" name="foem" method="post">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Old Password</label>
                                      <input type="password" placeholder="Enter Old Password" name="old_password" id="exampleInputPassword1" class="form-control">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">New Password</label>
                                      <input type="password" placeholder="Enter New Password" name="new_password" id="exampleInputPassword1" class="form-control">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Confirm Password</label>
                                      <input type="password" placeholder="Enter Confirm Password" name="confirm_password" id="exampleInputPassword1" class="form-control">
                                  </div>
                                  <input class="btn btn-info" type="submit" name="submit" value="Update Password">
                                 
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