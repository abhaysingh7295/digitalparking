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

$select_query = $con->query("select image from `pujan_samagri` where id = '".$id."'");
$row_pujan = $select_query->fetch_assoc();

if($row_pujan['image']!='') {
unlink('../pujan_samagri_image/'.$row_pujan['image']);
}
	
$sql = "DELETE FROM `pujan_samagri` WHERE id='".$id."'";

if ($con->query($sql) === TRUE) {

    header('location:all-pujan-samagri.php');
} else {
    echo "Error deleting record: " ;
} 
	
}
