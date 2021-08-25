<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){

$id = $_REQUEST['delete']; 

$select_query = $con->query("SET NAMES utf8");

$select_query = $con->query("select image from `songs_images` where id = '".$id."'");
$row_image = $select_query->fetch_assoc();

if($row_image['image']!='') {
unlink('../'.$row_image['image']);
}
	
$sql = "DELETE FROM `songs_images` WHERE id='".$id."'";

if ($con->query($sql) === TRUE) {

    header('location:all-songs-images.php');
} else {
    echo "Error deleting record: " ;
} 
	
}