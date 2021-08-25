<?php
include 'header.php';
if (isset($_POST['submit'])) {
    $image="";
    if(($_FILES['image']['type'] == 'image/gif') || ($_FILES['image']['type'] == 'image/jpeg') || ($_FILES['image']['type'] == 'image/jpg') || ($_FILES['image']['type'] == 'image/png') ) {
            if($_FILES['image']['error'] > 0) {   
                echo "<script>alert('Return'".$_FILES['image']['error']."')</script>";            
            } else if(move_uploaded_file($_FILES['image']['tmp_name'],'upload/' .$_FILES['image']['name'])) {
                $image="upload/" .$_FILES['image']['name'];
            }
        }
    $name = $_POST['name'];
    $code = strtoupper($_POST['code']);
    $price = $_POST['price'];
    $present = $_POST['present'];
    $expire_date =date('Y-m-d', strtotime($_POST['expire_date']));
    $images= $image;
    $insert_query = $con->query("SET NAMES utf8");
   
        $insert_query = "INSERT INTO offers(vendor_id,name,code,price,present,image,expire_date) VALUES('$current_user_id','$name','$code','$price','$present','$images','$expire_date')";
  

    if ($con->query($insert_query) === TRUE) {
        header('location:offers-info.php');
    } else {
        $error = 'Some Issue';
    }
}
$submitBtn = 'Submit';
$heading = 'Add Offer';
?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title"><?php echo $heading; ?></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $heading; ?></li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="name" name="name" type="text" value="" required=""/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Code</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="code" name="code" type="text" value="" required=""/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="price" name="price" type="number" value=""  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Present</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="present" name="present" type="number" maxlength="100"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Expire</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="expire_date" name="expire_date" type="date" value=""  required=""/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                   <input name="image" type="file"> 
                                        
                                       
                                </div>
                            </div>
                         



                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary waves-effect waves-light active" type="submit" name="submit"><?php echo $submitBtn; ?></button>
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



<!--main content end-->
<?php include 'footer.php' ?>
