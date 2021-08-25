<?php include('config.php'); 

if(isset($_POST['update'])) {
$id = $_POST['id'];


$select_query = $con->query("SELECT * FROM `songs_images` where id = '".$id."' ");
$row_song_image = $select_query->fetch_assoc();


$name = $_POST['image_name'];
$slug = $_POST['image_slug'];
$status = $_POST['status'];



if($_FILES['file']['name']!='') {
$file_name =  $_FILES['file']['name'];
	$file_type =  $_FILES['file']['type'];
	$file_path =  $_FILES['file']['tmp_name'];
	$file_size =  $_FILES['file']['size'];
	
	$new_file_name1 = trim(str_replace(" ","-", $file_name));
	
	$path="../song_image/600/".$new_file_name1;
	
	$newpath="song_image/600/".$new_file_name1;
	
	if(($_FILES['file']['type'] == 'image/gif') || ($_FILES['file']['type'] == 'image/jpeg') || ($_FILES['file']['type'] == 'image/jpg') || ($_FILES['file']['type'] == 'image/png'))
	 {
	 if($_FILES['file']['error']>0){
	   $error = 'Return '.$_FILES['audio_file']['error'];;
	} else if(move_uploaded_file($file_path,$path)){
        $song_image = $newpath;
	 $error = '';
	}
	} else {
	 $error = "Please Upload image only jpeg, jpg, png, gif format";
	}
	
} else {
 $song_image = $row_song_image['image'];
 $error = '';
}


if(empty($error)){

$update_query = $con->query("SET NAMES utf8");
//$update_query = "INSERT INTO `songs_images` (name,slug,image,date,status) VALUES ('$name','$slug','$song_image','$date','$status')";

$update_query = "UPDATE `songs_images` set name='".$name."',slug='".$slug."',image='".$song_image."',status='".$status."' WHERE id='".$id."'";

if ($con->query($update_query) === TRUE) {
    header('location:edit-song-image.php?edit_id='.$id);
} 

}
 else {
echo $error; 
}
}