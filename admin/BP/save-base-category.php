<?php 
include 'config.php';

if(isset($_POST['submit'])){
$name = $_POST['name'];
$status = $_POST['status'];
$insert_query = "INSERT INTO `base_category` (name,status) VALUES ('$name','$status')";
if ($con->query($insert_query) === TRUE) {
    header('location:all-base-categories.php');
} 
}