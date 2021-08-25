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
                      <th>Vendor Name</th>
                      <th>Vendor Email</th>
                      <th>Vendor Mobile No.</th>
                      <th>Vehicle No.</th>
                      <th>Parking Date/Time</th>
                      <th>Vendor Address</th>
                       
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php




$select_query = $con->query("SELECT * FROM `vehicle_book` Where vehicle_number LIKE '%".$vehicle_number."%' AND vehicle_status='In'");
while($row=$select_query->fetch_assoc())
{
     $user_id = $row['user_id'];
    
     $select_user = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
  $row_user = $select_user->fetch_assoc(); 
  
  $select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$user_id."'"); 
$place_info_row = $select_place->fetch_assoc();

$arrayaddress = array($place_info_row['area'], $place_info_row['landmark'], $place_info_row['city'], $place_info_row['state'], $place_info_row['country'], $place_info_row['pincode'])
?>
                    <tr class="gradeX">
                      <td><?php echo $row_user['first_name'].' '.$row_user['last_name']; ?></td>
                      <td><?php echo $row_user['user_email']; ?></td>
                      <td><?php echo $row_user['mobile_number']; ?></td>
                     <td><?php echo $row['vehicle_number']; ?></td>
                     <td><?php echo $row['vehicle_in_date_time']; ?></td>
                      <td><?php echo implode(', ',$arrayaddress); ?></td>
                      
                       
                      <td class="center"> 

            
                      	 <a class="" title="View Vendor Details" href="user-details.php?user_id=<?php echo $row['user_id'];?>" id="<?php echo $row['user_id'];?>"><i class="icon-eye-open"></i> </a>&nbsp;&nbsp;

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