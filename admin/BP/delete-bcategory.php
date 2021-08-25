<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){

$base_cat_id = $_REQUEST['delete']; 
	
$sql = "DELETE FROM `base_category` WHERE id='".$base_cat_id."'";

if ($con->query($sql) === TRUE) {

//$con->query("DELETE FROM `sub_category` WHERE base_category_id='".$base_cat_id."'");

//$con->query("DELETE FROM `detail` WHERE section='".$base_cat_id."'");


    header('location:all-base-categories.php');
} else {
    echo "Error deleting record: " ;
}
	
}

