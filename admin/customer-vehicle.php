<?php include 'header.php';
$user_id = $_GET['user_id'];
?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Customer Vehicle <span style="float: right;"></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
 

 
 
		<div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Vehicle Number</th>
                      <th>Vehicle Type</th>
                      <th>Vehicle Photo</th>
                      <th>Vehicle RC</th>

                      <th>Added Date</th> 
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php

          $select_query = $con->query("SELECT * FROM `customer_vehicle` WHERE customer_id = ".$user_id." ORDER BY id DESC");
          while($row=$select_query->fetch_assoc())
          { 

            $vehicle_photo_DIR = '../uploads/'.$row['vehicle_photo'];
            $vehicle_rc_DIR = '../uploads/'.$row['vehicle_rc'];

            ?>
                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['vehicle_number']; ?></td>

                      <td title=""><?php echo $row['vehicle_type']; ?></td>
                      <td><?php 
                      if(file_exists($vehicle_photo_DIR)){ ?>
                        <a href="<?php echo $vehicle_photo_DIR; ?>" target="_blank"><img src="<?php echo $vehicle_photo_DIR; ?>" width="100" /></a>
                      <?php } ?></td>
                      <td><?php 
                      if(file_exists($vehicle_rc_DIR)){ ?>
                        <a href="<?php echo $vehicle_rc_DIR; ?>" target="_blank"><img src="<?php echo $vehicle_rc_DIR; ?>" width="100" /></a>
                      <?php } ?></td>
                      <td><?php echo date('Y-m-d',$row['date_time']); ?></td>
                       
                    </tr>
                    <?php } ?>
                  </tbody>
                  
                </table>
           </div>
 

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