<?php 
include 'config.php';

if(isset($_POST['update'])){
$id = $_POST['id'];
$sub_category_id = $_POST['sub_category'];
$hindi_name = $_POST['hindi_name'];
$hindi_description = $_POST['hindi_description'];
$english_name = $_POST['english_name'];
$english_description = $_POST['english_description'];
$quantity = $_POST['quantity'];
$status = $_POST['status'];


if($_FILES['file']['name']!='') {
$file_name =  $_FILES['file']['name'];
	$file_type =  $_FILES['file']['type'];
	$file_path =  $_FILES['file']['tmp_name'];
	$file_size =  $_FILES['file']['size'];
	
	$new_file_name1 = trim(str_replace(" ","-", $file_name));
	
	$path="../pujan_samagri_image/".$new_file_name1;
	$newpath="pujan_samagri_image/".$new_file_name1;
	
	if(($_FILES['file']['type'] == 'image/gif') || ($_FILES['file']['type'] == 'image/jpeg') || ($_FILES['file']['type'] == 'image/jpg') || ($_FILES['file']['type'] == 'image/png') && ($_FILES['file']['size'] < 200000))
	 {
	 if($_FILES['file']['error']>0){
	  echo "<script>alert('Return'".$_FILES['file']['error']."')</script>";
	} else if(move_uploaded_file($file_path,$path)){
	$insert_query = $con->query("SET NAMES utf8");

$insert_query = "update `pujan_samagri`  SET sub_category_id = '".$sub_category_id."', image = '".$file_name."', hindi_name = '".$hindi_name."' , hindi_description = '".$hindi_description."' , english_name = '".$english_name."' , english_description = '".$english_description."' , quantity = '".$quantity."', status = '".$status."' where id = '".$id."'";

	}
	} else {
	 echo "<script>alert('Please Upload image only jpeg, jpg, png, gif format and image size less then 2 MB')</script>";
	}
	
} else {
$insert_query = $con->query("SET NAMES utf8");
$insert_query = "update `pujan_samagri`  SET sub_category_id = '".$sub_category_id."', hindi_name = '".$hindi_name."' , hindi_description = '".$hindi_description."' , english_name = '".$english_name."' , english_description = '".$english_description."' , quantity = '".$quantity."', status = '".$status."' where id = '".$id."'";

}


if ($con->query($insert_query) === TRUE) {
    header('location:edit-pujan-samagri.php?edit_id='.$id);
} 
}