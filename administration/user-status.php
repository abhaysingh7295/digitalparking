<?php include('../config.php');
include 'functions.php';
$site_settings_row = getAdminSettings($con);
$user_id = $_GET['user_id'];
$return = $_GET['return'];
if($_GET['action']=='status'){
	$status = $_GET['status'];

	if($status==1){
		$statusbody = 'Your Account Status Deactivate to Activated has been changed by admin.';
	} else {
		$statusbody = 'Your Account Status Activate to Deactivated has been changed by admin. Please contact with Admin.';
	}

	$select_query = $con->query("SELECT * FROM `pa_users` where id='".$user_id."' AND user_role='vandor'");

	$aqled = "update `pa_users` SET user_status = '".$status."' where id = ".$user_id;
	 $ress = $con->query($aqled);
	 if($ress){
 		if($row = $select_query->fetch_assoc())
		{
	 		$username = $row['first_name'].' '.$row['last_name'];
            $to = $row['user_email'];
           // $to = 'deepshar2009@gmail.com';
            $subject = "Your Status Changed by Admin on ".$site_settings_row['site_name'];
            $message = 'Dear '.$username.', <br/>
            <br/>
            '.$statusbody.'<br/><br/>
            Thank You<br/>
            '.$site_settings_row['site_name'].' Team<br/>';
        }
        SendEmailNotification($to,$subject,$message);
	 	header('location:'.$return);
	}
} else if($_GET['action']=='delete'){
	$sql = "DELETE FROM `pa_users` WHERE id='".$user_id."'";
	if ($con->query($sql) === TRUE) {
		header('location:'.$return);
	}
} if($_GET['adminaction']=='status'){
	$status = $_GET['status'];

	if($status==1){
		$statusbody = 'Your Account Status Deactivate to Activated has been changed by admin.';
	} else {
		$statusbody = 'Your Account Status Activate to Deactivated has been changed by admin. Please contact with Admin.';
	}

	$select_query = $con->query("SELECT * FROM `login` where Id='".$user_id."'");

	$aqled = "update `login` SET user_status = '".$status."' where Id = ".$user_id;
	 $ress = $con->query($aqled);
	 if($ress){
	 	$row = $select_query->fetch_assoc();
 		$username = $row['User_name'];
        $to = $row['Email'];
       // $to = 'deepshar2009@gmail.com';
        $subject = "Your Status Changed by Admin on ".$site_settings_row['site_name'];
        $message = 'Dear '.$username.', <br/>
        <br/>
        '.$statusbody.'<br/><br/>
        Thank You<br/>
        '.$site_settings_row['site_name'].' Team<br/>';
        SendEmailNotification($to,$subject,$message);
	 	header('location:'.$return);
	}
} else if($_GET['adminaction']=='delete'){
	$sql = "DELETE FROM `login` WHERE Id='".$user_id."'";
	if ($con->query($sql) === TRUE) {
		header('location:'.$return);
	}
}