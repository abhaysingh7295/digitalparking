<?php include 'header.php';

if($_POST) {
$startdate = $_POST['start_date'];
$endate = $_POST['end_date'];

//echo "SELECT * FROM `email_notifications` WHERE date_time >= '".$startdate."' AND date_time <= '".$endate."' ORDER BY id DESC"; 
$select_query = $con->query("SELECT * FROM `email_notifications` WHERE STR_TO_DATE( date_time, '%Y-%m-%d' ) >= '".$startdate."' AND STR_TO_DATE(date_time, '%Y-%m-%d' ) <= '".$endate."' ORDER BY id DESC");
} else {
$startdate = '';
$endate = '';
$select_query = $con->query("SELECT * FROM `email_notifications` ORDER BY id DESC");
}

 ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Email Notifications <span style="float: right;"><a class="btn-info btn" href="send-email-notifications.php">Send Email Notifications</a></span> </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table table-responsive">
		<form action="" method="POST">
		 <div class="col-lg-2">
 		<input class="form-control" type="text" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo $startdate; ?>" required />
		</div>
		
		<div class="col-lg-2">
 		<input class="form-control" type="text" name="end_date" id="end_date" placeholder="End Date" value="<?php echo $endate; ?>" required />
		</div> 
		
		<div class="col-lg-2">
 		<input class="btn-success btn" type="submit" name="submit" id="submit" value="Filter"/>
		</div> 
		 
		</form>
		 
            
                <table class="display table table-bordered table-striped" id="example">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Message</th>
                     <th>Date Time</th>
                      <th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php


while($row=$select_query->fetch_assoc())
{
?>
                    <tr class="gradeX">
                      <td><?php 

$select_user = $con->query("SELECT * FROM `user` where user_id = '".$row['user_id']."'");
if($select_user->num_rows > 0) {
$row_users=$select_user->fetch_assoc();

echo $row_users['name'].' ('.$row_users['email'].')';
} else {
echo 'No User Exists';
}

?></td>
                      <td><?php

$select_message = $con->query("SELECT * FROM `email_notification_messages` where id = '".$row['message']."'");
if($select_message->num_rows > 0) {
$row_message=$select_message->fetch_assoc();

 echo strip_tags($row_message['message']);
}   else {
echo 'No message exists';
} ?></td>
                    <td><?php echo $row['date_time']; ?></td>
                    <td><?php echo $row['message_status']; ?></td>
                      <td class="center"> <a href="delete-enotification.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                       <th>User</th>
                      <th>Message</th>
                     <th>Date Time</th>
                      <th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end--> 
    </section>
  </section>
  
  <!--main content end-->
  <?php include 'footer.php' ?>