<?php include 'header.php' ?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Parking Entity  <span style="float: right;"><a class="btn-info btn" href="add-user-wallet.php">Add New</a></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
		      <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="exampleusers" data-page-length="100">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Parking Place</th>
                      <th>Address</th>
                      <th>Email/Username</th>
                      
                       <th>Wallet Amount (Rs.)</th>
                        <th>Activation Date</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php
//"SELECT * FROM wallet_history as wh INNER JOIN pa_users as u ON wh.user_id=u.id ORDER BY u.id DESC"
$select_query = $con->query("SELECT * FROM wallet_history as wh INNER JOIN pa_users as u ON wh.user_id=u.id GROUP BY wh.user_id ORDER BY u.id DESC");
while($row=$select_query->fetch_assoc())
{

$select_place = $con->query("SELECT * FROM `place_info` Where user_id='".$row['user_id']."'"); 
$val_place = $select_place->fetch_assoc();

?>
                    <tr class="gradeX" id="user-details-<?php echo $row['user_id'];?>">
                      <td><?php echo $row['first_name'].' '.$row['last_name']; ?></td>
                       <td><?php echo $val_place['area']; ?></td>

                         <td><?php echo $val_place['landmark']; ?> <?php echo $val_place['city']; ?> <?php echo $val_place['state']; ?> <?php echo $val_place['country']; ?> <?php echo $val_place['pincode']; ?></td>

                      <td><?php echo $row['user_email']; ?></td>
                      
                     
                    
                       <td><?php echo $row['wallet_amount']; ?></td>
                       <td><?php echo $row['register_date']; ?></td>
                      <td class="center" id="user-action-<?php echo $row['user_id'];?>"> 

            
                      	 <a class="" title="View Wallet History" href="user-wallet-history.php?user_id=<?php echo $row['user_id'];?>" id="<?php echo $row['user_id'];?>"><i class="icon-eye-open"></i> </a>&nbsp;&nbsp;

            </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                   <tr>
                      <th>Name</th>
                      <th>Email/Username</th>
                      <th>User Role</th>
                       <th>Wallet Amount (Rs.)</th>
                      <th class="">Action</th>
                    </tr>
                  </tfoot>
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