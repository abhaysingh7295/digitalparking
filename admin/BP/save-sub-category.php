<?php 
include 'config.php';

if(isset($_POST['submit'])){
$name = $_POST['name'];
$base_category = $_POST['base_category'];
$hindi_sku = $_POST['hindi_sku'];
$hindi_price = $_POST['hindi_price'];
$sanskrit_sku = $_POST['sanskrit_sku'];
$sanskrit_price = $_POST['sanskrit_price'];
$status = $_POST['status'];
$insert_query = "INSERT INTO `sub_category` (base_category_id,name,hindi_sku,hindi_price,sanskrit_sku,sanskrit_price,status) VALUES ('$base_category','$name','$hindi_sku','$hindi_price','$sanskrit_sku','$sanskrit_price','$status')";
if ($con->query($insert_query) === TRUE) {
    header('location:all-sub-categories.php');
} 
}