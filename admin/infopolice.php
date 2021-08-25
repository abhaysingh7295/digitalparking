<?php include 'header.php'; 
?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Police Information <span style="float: right;"></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
 

 
 
		<div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Customer Name</th>
                      <th>Vehicle Number</th>
                      <th>Vehicle Type</th>
                      
                      <th>Vehicle Category</th>

                       <th>Remark</th>

                        <th>Latitude</th>

                         <th>Longitude</th>

                      <th> Photo</th>
                      <th>Added Date</th> 
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php

          $select_query = $con->query("SELECT p.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `info_police`as p LEFT JOIN `pa_users`as u ON p.user_id = u.id ORDER BY id DESC");
          while($row=$select_query->fetch_assoc())
          { 

            $upload_image = '../police-info-upload/'.$row['upload_image'];

            ?>
                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                       <td><?php echo $row['customer_name']; ?></td>
                      <td><?php echo $row['vechicle_no']; ?></td>
                      <td title=""><?php echo $row['vechicle_type']; ?></td>
                      <td><?php echo $row['vechicle_category']; ?></td>
                      <td><?php echo $row['remark']; ?></td>
                      <td><?php echo $row['latitude']; ?></td>
                      <td><?php echo $row['longitude']; ?></td>

                      <td><?php  if($row['upload_image']){ ?>
                        <a href="<?php echo $upload_image; ?>" target="_blank"><img src="<?php echo $upload_image; ?>" width="100" /></a>
                      <?php } ?></td>
                      <td><?php echo date('Y-m-d',$row['submit_date']); ?></td>
                       
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