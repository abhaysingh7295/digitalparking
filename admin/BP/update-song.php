<?php include('config.php'); 

$id = $_POST['id'];

$select_query = $con->query("SELECT * FROM `detail` where id = '".$id."' ");
$row_song = $select_query->fetch_assoc();


$name = $_POST['name'];
$image = $_POST['image'];
$audio_type = $_POST['audio_type'];
$language = $_POST['language'];
$date = date('Y-m-d');

$base_category = $_POST['base_category'];
$sub_category = $_POST['sub_category'];
$song_sku = $_POST['song_sku'];
$song_type = $_POST['song_types'];
$song_price = $_POST['songe_price'];
$orderid = $_POST['orderid'];



if($audio_type=='both') {
/* AAC Format */
if($_FILES['audio_file']['name']!='') {

$file_name =  $_FILES['audio_file']['name'];
	$file_type =  $_FILES['audio_file']['type'];
	$file_path =  $_FILES['audio_file']['tmp_name'];
	$file_size =  $_FILES['audio_file']['size'];
$new_file_name =trim(str_replace(" ","_", $file_name));
       $path="../Recordings/upload/".$new_file_name;
       $new_path="Recordings/upload/".$new_file_name;
	$length = $file_size;
	if(($_FILES['audio_file']['type']=='audio/x-wav') || ($_FILES['audio_file']['type']=='audio/wav') || ($_FILES['audio_file']['type']=='audio/aac') || ($_FILES['audio_file']['type']=='audio/mp4') || ($_FILES['audio_file']['type']=='application/octet-stream'))
	 {
	 if($_FILES['audio_file']['error']>0){
	 $error = 'Return '.$_FILES['audio_file']['error'];
	} else if(move_uploaded_file($file_path,$path)){
	$aacfile = $new_path;
	$error = '';
	}
	} else {
	 $error = 'Please Upload only AAC format';
	}
	
} else {
	$aacfile = $row_song['url'];
	$length = $row_song['length'];
	$error = '';
}
/* MP3 Format */
if($_FILES['mp3_audio_file']['name']!='') {
$file_name1 =  $_FILES['mp3_audio_file']['name'];
	$file_type1 =  $_FILES['mp3_audio_file']['type'];
	$file_path1 =  $_FILES['mp3_audio_file']['tmp_name'];
	$file_size1 =  $_FILES['mp3_audio_file']['size'];
$new_file_name1 =trim(str_replace(" ","_", $file_name1));
	$path1="../Recordings/upload/".$new_file_name1;
$new_path1="Recordings/upload/".$new_file_name1;
	$length = $file_size1;
	if(($_FILES['mp3_audio_file']['type']=='audio/mpeg') || ($_FILES['mp3_audio_file']['type']=='audio/mpeg3') || ($_FILES['mp3_audio_file']['type']=='audio/x-mpeg3') || ($_FILES['mp3_audio_file']['type']=='audio/mp3'))
	 {
	 if($_FILES['mp3_audio_file']['error']>0){
	  $error = 'Return '.$_FILES['mp3_audio_file']['error'];
	} else if(move_uploaded_file($file_path1,$path1)){
	$mp3file = $new_path1;
	$error = '';
	}
	} else {
	
	$error = 'Please Upload only MP3 format';
	}
	
} else {
	$mp3file = $row_song['mp3_url'];
	$length = $row_song['length'];
	$error = '';
}

} else if($audio_type=='acc'){
/* AAC Format */
if($_FILES['audio_file']['name']!='') {

$file_name =  $_FILES['audio_file']['name'];
	$file_type =  $_FILES['audio_file']['type'];
	$file_path =  $_FILES['audio_file']['tmp_name'];
	$file_size =  $_FILES['audio_file']['size'];
$new_file_name =trim(str_replace(" ","_", $file_name));
	$path="../Recordings/upload/".$new_file_name;
       $new_path="Recordings/upload/".$new_file_name;
	$length = $file_size;
	if(($_FILES['audio_file']['type']=='audio/x-wav') || ($_FILES['audio_file']['type']=='audio/wav') || ($_FILES['audio_file']['type']=='audio/aac') || ($_FILES['audio_file']['type']=='audio/mp4') || ($_FILES['audio_file']['type']=='application/octet-stream'))
	 {
	 if($_FILES['audio_file']['error']>0){
	 $error = 'Return '.$_FILES['audio_file']['error'];
	} else if(move_uploaded_file($file_path,$path)){
	$aacfile = $new_path;
	$error = '';
	}
	} else {
	 $error = 'Please Upload only AAC format';
	}
	
} else {
	$aacfile = $row_song['url'];
	$length = $row_song['length'];
	$error = '';
}
} else if($audio_type=='mp3') {
/* MP3 Format */
if($_FILES['mp3_audio_file']['name']!='') {
$file_name1 =  $_FILES['mp3_audio_file']['name'];
	$file_type1 =  $_FILES['mp3_audio_file']['type'];
	$file_path1 =  $_FILES['mp3_audio_file']['tmp_name'];
	$file_size1 =  $_FILES['mp3_audio_file']['size'];
 
      $new_file_name1 =trim(str_replace(" ","_", $file_name1));

	$path1="../Recordings/upload/".$new_file_name1;
       $new_path1="Recordings/upload/".$new_file_name1;
	$length = $file_size1;
	if(($_FILES['mp3_audio_file']['type']=='audio/mpeg') || ($_FILES['mp3_audio_file']['type']=='audio/mpeg3') || ($_FILES['mp3_audio_file']['type']=='audio/x-mpeg3') || ($_FILES['mp3_audio_file']['type']=='audio/mp3'))
	 {
	 if($_FILES['mp3_audio_file']['error']>0){
	  $error = 'Return '.$_FILES['mp3_audio_file']['error'];
	} else if(move_uploaded_file($file_path1,$path1)){
	$mp3file = $new_path1;
	$error = '';
	}
	} else {
	
	$error = 'Please Upload only MP3 format';
	}
	
} else {
	$mp3file = $row_song['mp3_url'];
	$length = $row_song['length'];
	$error = '';
}
} 

if(empty($error)){
 $update_query = $con->query("SET NAMES utf8");

$update_query = "UPDATE `detail` set name='".$name."', image='".$image."', url='".$aacfile."', mp3_url='".$mp3file."', length='".$length."', section='".$base_category."',language='".$language."', sub_category='".$sub_category."', orderid='".$orderid."', song_sku='".$song_sku."', song_price='".$song_price."', song_type='".$song_type."' WHERE id ='".$id."'";


$con->query($update_query);
header('location:edit-song.php?edit_id='.$id);
} else {
echo $error; 
}