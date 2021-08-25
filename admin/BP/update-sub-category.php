<?php 
include 'config.php';

if(isset($_POST['update'])){
$id = $_POST['id'];
$name = $_POST['name'];
$base_category = $_POST['base_category'];
$hindi_sku = $_POST['hindi_sku'];
$hindi_price = $_POST['hindi_price'];
$sanskrit_sku = $_POST['sanskrit_sku'];
$sanskrit_price = $_POST['sanskrit_price'];
$status = $_POST['status'];
$insert_query = "update `sub_category`  SET base_category_id = '".$base_category."', name = '".$name."', hindi_sku = '".$hindi_sku."',  hindi_price = '".$hindi_price."',  sanskrit_sku = '".$sanskrit_sku."',  sanskrit_price = '".$sanskrit_price."', status = '".$status."' where id = '".$id."'";
if ($con->query($insert_query) === TRUE) {
    header('location:all-sub-categories.php');
} 
}