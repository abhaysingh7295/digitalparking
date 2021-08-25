<?php include 'header.php'; 

$vehicle_id = $_GET['vehicle_id']; 

if(!$vehicle_id)
{
    header('location:all-sensitive-vehicles.php');
    exit();
} 
 

 
$sensitive_vehicle = $con->query("select * from `sensitive_vehicle` where id = '".$vehicle_id."'");
$vehicle_row = $sensitive_vehicle->fetch_assoc();
extract($vehicle_row);
 

if(isset($_POST['submit']))
{
    extract($_POST);
    $date_time = time();
        $insert_query = "INSERT INTO sensitive_vehicle_remark(sansitive_vehicle_id,remark,date_time) VALUES('$vehicle_id','$remark', '$date_time')";   
 
    if ($con->query($insert_query) === TRUE) {
        header('location:view-sensitive-vehicle-remarks.php?vehicle_id='.$vehicle_id);
    } else {
         $error = 'Some Database Error';  
    }


}


?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Add Remark for Sensitive Vehicle</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Add Remark for Sensitive Vehicle</li>
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
                            <?php  if(isset($error)) {
                                echo '<p style="color:red">'.$error.'</p>';
                                } ?>
                           

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="remark" required="required"></textarea> 
                                </div>
                            </div>
 
                            <div class="form-group row">
                                <label for="example-st-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
                                    <button class="btn btn-danger" type="submit" name="submit">Submit</button>
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