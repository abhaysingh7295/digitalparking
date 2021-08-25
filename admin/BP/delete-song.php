<?php 
session_start();
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';


if(isset($_REQUEST['delete'])){

$song_id = $_REQUEST['delete']; 
	
$sql = "DELETE FROM `detail` WHERE id='".$song_id."'";

if ($con->query($sql) === TRUE) {

$con->query("DELETE FROM `favourite` WHERE song_id='".$song_id."'");

$con->query("DELETE FROM `user_play_list` WHERE song_id='".$song_id."'");


    header('location:all-songs.php');
} else {
    echo "Error deleting record: " ;
}
	
}

