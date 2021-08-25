<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Email Notifications <span style="float: right;"><a class="btn-info btn" href="add-email-message.php">Add New</a></span> </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table table-responsive">
                <table class="display table table-bordered table-striped" id="example">
                  <thead>
                    <tr>
                    <th>Subject</th>
                      <th>Message</th>
                     <th>Date Time</th>
                     <th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

$select_query = $con->query("SELECT * FROM `email_notification_messages` ORDER BY id DESC");
while($row=$select_query->fetch_assoc())
{
?>
                    <tr class="gradeX">
                   <td><?php echo $row['subject']; ?></td>
                      <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['date_time']; ?></td>
                   <td><?php if($row['status']==1) { echo "Enable";} else { echo "Disable"; } ?></td>
                      <td class="center"> <a href="edit-email-message.php?edit_id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp; <a href="delete-email-message.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                     <th>Subject</th>
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