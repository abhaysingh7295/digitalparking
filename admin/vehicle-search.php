<?php include 'header.php';

$vehicle_number = $_REQUEST['vehicle_number'];

if((!isset($vehicle_number))|| ($vehicle_number==''))
{
header('location:dashboard.php');
}
?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Vehicle Search</header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
		      <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers" data-page-length="100">
                  <thead>
                    <tr>
                      <th>Vendor Details</th>
                       <th>Vendor Address</th>
                      <th>Customer Details</th>
                       <th>Customer Address</th>
                      <th>Vehicle No.</th>
                       <th>Parking Name</th>
                      <th>Parking Date/Time</th>
                     
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php

$select_query = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.user_email as vendor_email, v.mobile_number as vendor_mobile, CONCAT_WS(' ', v.address, v.city,v.state) as vendor_address, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name,  c.user_email as customer_email, c.mobile_number as customer_mobile, CONCAT_WS(' ', c.address, c.city,c.state) as customer_address FROM `vehicle_booking` as vb JOIN `pa_users` AS v ON vb.vendor_id = v.id JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_number LIKE '%".$vehicle_number."%' AND vb.vehicle_status='In'");
while($row=$select_query->fetch_assoc())
{


?>
                    <tr class="gradeX">
                      <td><?php echo $row['vendor_name'].' <br/>'.$row['vendor_email'].' <br/>'.$row['vendor_mobile']; ?></td>
                      <td><?php echo $row['vendor_address']; ?></td>
                       <td><?php echo $row['customer_name'].' <br/>'.$row['customer_email'].' <br/>'.$row['customer_mobile']; ?></td>
                       <td><?php echo $row['customer_address']; ?></td>
                      <td><?php echo $row['vehicle_number']; ?></td>
                      <td><?php echo $row['parking_name']; ?></td>
                      <td><?php echo date('Y-m-d h:i A',$row['vehicle_in_date_time']); ?></td>
                     
                       
                      <td class="center"> 

            
                      	 <a class="" title="View Vendor Details" href="user-details.php?user_id=<?php echo $row['vendor_id'];?>" id="<?php echo $row['user_id'];?>"><i class="icon-eye-open"></i> </a>&nbsp;&nbsp;

            </td>
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