<?php 

include '../config.php';
include '../administration/functions.php';

var_dump($_POST);
print_r($_POST);
die('sdsds');



$id = '';
$vehicle_number = '';
$vehicle_type = '';
$mobile_number = '';
$engine_number = '';
$chassis_number = '';
$city = '';
$state = '';
$address = '';
$pin_code = '';
$polic_station = '';
$search_reason = '';
$remark = '';
$photo_upload = '';
$heading = 'Add';


if($_GET['id']){
    
    $heading = 'Edit';
    $id = $_GET['id'];
    $sensitive_vehicle = $con->query("select * from `sensitive_vehicle` where id = '".$id."'");
    $vehicle_row = $sensitive_vehicle->fetch_assoc();
    extract($vehicle_row);
} 

if(isset($_POST['submit']))
{ 
    extract($_POST);
    $eid = $id;
    $submit_date_time = time();

    if($eid){
         $insert_query = "update `sensitive_vehicle` SET vehicle_number = '".$vehicle_number."', vehicle_type = '".$vehicle_type."',  mobile_number = '".$mobile_number."', engine_number = '".$engine_number."', chassis_number = '".$chassis_number."', city = '".$city."',state = '".$state."',address = '".$address."',pin_code = '".$pin_code."',polic_station = '".$polic_station."',search_reason = '".$search_reason."',remark = '".$remark."' where id = '".$eid."'";
    } else {
        $crn_no = $submit_date_time;
        $insert_query = "INSERT INTO sensitive_vehicle(admin_id,open_admin_id,crn_no,vehicle_number,vehicle_type,mobile_number,engine_number,chassis_number,city,state,address,pin_code,polic_station,search_reason,remark,submit_date_time) VALUES('$current_user_id','$current_user_id','$crn_no','$vehicle_number','$vehicle_type','$mobile_number', '$engine_number','$chassis_number', '$city', '$state', '$address', '$pin_code', '$polic_station', '$search_reason', '$remark', '$submit_date_time')";   
    }

    if ($con->query($insert_query) === TRUE) {
         
        if($eid==''){
            $sensitive_id = $con->insert_id;
             $con->query("INSERT INTO sensitive_vehicle_remark(sansitive_vehicle_id,admin_id,remark,date_time) VALUES('$sensitive_id','$current_user_id','$remark', '$submit_date_time')");
        } else {
            $sensitive_id = $eid;
        }

        $new_photo_upload = $_FILES['photo_upload']['name'];
        $path_profile_image = "upload/sensitives/" .$new_photo_upload;
        if($new_photo_upload)  {
            if(($_FILES['photo_upload']['type'] == 'image/gif') || ($_FILES['photo_upload']['type'] == 'image/jpeg') || ($_FILES['photo_upload']['type'] == 'image/jpg') || ($_FILES['photo_upload']['type'] == 'image/png') )
            { 
                if(move_uploaded_file($_FILES['photo_upload']['tmp_name'],$path_profile_image)) ;
                {
                    if($photo_upload){
                        unlink($photo_upload); 
                    }
                     $con->query("update `sensitive_vehicle` SET photo_upload = '".$new_photo_upload."' where id = '".$sensitive_id."'");
                }
            }
        }
        header('location:all-sensitive-vehicles.php');
    } else {
         $error = 'Some Database Error';  
    }

}
?>


