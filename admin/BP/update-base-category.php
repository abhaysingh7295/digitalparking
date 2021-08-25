<?php 
include 'config.php';

if(isset($_POST['update'])){
$id = $_POST['id'];
$name = $_POST['name'];
$status = $_POST['status'];
$insert_query = "update `base_category`  SET name = '".$name."', status = '".$status."' where id = '".$id."'";
if ($con->query($insert_query) === TRUE) {
    header('location:all-base-categories.php');
} 
}