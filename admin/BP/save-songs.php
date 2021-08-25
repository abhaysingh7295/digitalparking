<?php include('config.php'); 

$name = $_POST['name'];
$image = $_POST['image'];
$audio_type = $_POST['audio_type'];
$language = $_POST['language'];
$date = date('Y-m-d');
$aacfile = '';
$mp3file = '';
$length = '';

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
	
}
}

if(empty($error)){

$ar_base_category = array_values(array_filter($_POST['base_category']));

foreach($ar_base_category as $key=> $base_category_data){

$base_category = $_POST['base_category'][$key];
$sub_category = $_POST['sub_category'][$key];
$song_sku = $_POST['song_sku'][$key];
$song_types = $_POST['song_types'][$key];
$song_price = $_POST['songe_price'][$key];
$orderid = $_POST['orderid'][$key];
 
 $insert_query = $con->query("SET NAMES utf8");
$insert_query = "INSERT INTO `detail` (name,image,url,mp3_url,length,section,language,sub_category,orderid,date,song_sku,song_price,song_type) VALUES ('$name','$image','$aacfile','$mp3file','$length','$base_category','$language','$sub_category','$orderid','$date','$song_sku','$song_price','$song_types')";

$con->query($insert_query);
}

    header('location:all-songs.php');


} else {
echo $error; 
}