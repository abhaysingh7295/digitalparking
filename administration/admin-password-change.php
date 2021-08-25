<?php include 'header.php'; 

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
         
         echo "<script> alert('Your new password has been change.')</script>";
     }
}else{echo "<script> alert('Your Old password has been Wrong.')</script>";}
         
         }
?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Password Change</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Password Change</li>
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

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input type="password" placeholder="Enter Old Password" name="old_password" id="exampleInputPassword1" class="form-control">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">New Password</small></label>
                                <div class="col-sm-10">
                                    <input type="password" placeholder="Enter New Password" name="new_password" id="exampleInputPassword1" class="form-control">
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                   <input type="password" placeholder="Enter Confirm Password" name="confirm_password" id="exampleInputPassword1" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-danger" type="submit" name="submit">Update</button>
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


     



<?php include 'footer.php'; ?>