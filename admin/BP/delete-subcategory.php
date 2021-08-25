<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){

$sub_cat_id = $_REQUEST['delete']; 
	
$sql = "DELETE FROM `sub_category` WHERE id='".$sub_cat_id."'";

if ($con->query($sql) === TRUE) {

//$con->query("DELETE FROM `detail` WHERE sub_category='".$sub_cat_id."'");


    header('location:all-sub-categories.php');
} else {
    echo "Error deleting record: " ;
}
	
}

