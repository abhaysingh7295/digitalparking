<?php include '../../config.php'; 

include '../../administration/functions.php';


$activate_subscriptions_plans = $con->query("select vs.vendor_id, v.user_email, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.parking_name, vs.subscription_start_date, vs.subscription_end_date, sp.plan_name from `vendor_subscriptions` as vs JOIN pa_users as v on vs.vendor_id = v.id LEFT JOIN subscriptions_plans as sp on vs.subscription_plan_id = sp.id where vs.status = 1 AND v.user_role = 'vandor'");

$currentTime = time();

while($active_plans_row=$activate_subscriptions_plans->fetch_assoc())
{
	$vendor_id = $active_plans_row['vendor_id'];
	$vendor_name = $active_plans_row['vendor_name'];
	$vendor_email = $active_plans_row['user_email'];
	$parking_name = $active_plans_row['parking_name'];
	$subscription_start_date = $active_plans_row['subscription_start_date'];
	$subscription_end_date = $active_plans_row['subscription_end_date'];
	$plan_name = $active_plans_row['plan_name'];

	$diff = $subscription_end_date - $currentTime;

	$fullDays    = floor($diff/(60*60*24));  

	//$fullDays = 3;
	
	if($fullDays==3){

		ob_start(); ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <title>A Simple Responsive HTML Email</title>
		    <style type="text/css">
			    body {margin: 0; padding: 0; min-width: 100%!important;}
			    .content {width: 100%; max-width: 600px;}  
		    </style>
		</head>
		<body yahoo bgcolor="#f6f8f1">
			<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
		    	<tr>
		    		<td>
						<table width="80%" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr style="border-collapse:collapse"> 
									<td style="border-collapse:collapse;border:1px solid lightgrey;padding:3px;text-align: center;"><img src="http://thedigitalparking.com/digital-parking/administration/upload/logo.png"><br></td> 
								</tr>
								<tr>
									<td>
										<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" style="word-break:normal;color:rgb(0,0,0);font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;text-decoration-style:initial;text-decoration-color:initial;box-sizing:border-box;border-radius:3px;background-color:rgb(255,255,255);margin:0px;border:1px solid rgb(233,233,233)">
										   <tbody>
										      <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										         <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:20px">
										         	<strong>Your the digital parking account will expire in 3 days!</strong><br><br><br>
										            Current Plan Details:- 
										            <br>Client ID:-&nbsp; <?php echo $vendor_id; ?>
										            <br>Purchase date and Due Date :- <?php echo date('d/m/Y',$subscription_end_date); ?>	
										            <br>
										            <br><a href="<?php echo VENDOR_URL.'subscriptions.php'; ?>">Purchase Now</a><br>
										            <table width="100%" cellpadding="0" cellspacing="0" style="word-break:normal;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										               <tbody>
										                  <tr style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0px">
										                     <td valign="top" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0px;padding:0px 0px 20px">
										                        <div><br></div>
										                        <div>Thanks,<br></div>
										                        <div>Team VehiclePe - The Digital Parking<br></div>
										                     </td>
										                  </tr>
										               </tbody>
										            </table>
										         </td>
										      </tr>
										   </tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
		    		</td>
		    	</tr>
		    </table>
		</body>
		</html>
		<?php 
		$message = ob_get_contents();
		ob_end_clean();
		//$to = "support@thedigitalparking.com";
		$to = $vendor_email;
		$subject = 'Subscripton will expire Soon';
		SendEmailNotification($to,$subject,$message);
	}
}