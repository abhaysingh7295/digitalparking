<?php include 'header.php' ;

/* if(isset($_GET['action']) == 'status'){
  $id = $_GET['id'];
  $status = $_GET['status'];
  $aqled =  $con->query("update `monthly_pass` SET status = '".$status."' where id = ".$id);
  header('location:all-monthly-pass.php');
} else if(isset($_GET['action']) == 'delete'){
  $id = $_GET['id'];
  $con->query("DELETE FROM `monthly_pass` WHERE id='".$id."'");
  header('location:all-monthly-pass.php');
} */
?>
  <!--main content start-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Monthly Pass  <span style="float: right;"><a class="btn-info btn" href="add-monthly-pass.php">Add Monthly Paas</a></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
 

<?php
 if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];


  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC ");


} else {

  $getstart = '';
  $getend = '';

  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id ORDER BY id DESC ");

}
  

 ?>

 <form action="" method="get"> 
 <div class="col-lg-2">
  <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo $getstart; ?>" placeholder="Start Date" required="required">
 </div>

<div class="col-lg-2">
 <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo $getend; ?>" placeholder="End Date" required="required">
</div>

<div class="col-lg-2">
 <input type="submit" name="submit" value="Search" class="btn btn-danger">
 </div>
</form>
 
		<div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="example" data-page-length="100">
                  <thead>
                    <tr>
                      <th style="display: none;"></th>
                      <th>Vehicle No</th>
                      <th>Customer Name</th>
                       <th>Vendor Name</th>   
                       <th>Vendor Name</th> 
                       <th>Start / End Date</th>
 			                <th>Issuing Date</th>
                      <th>Amount</th>
                      <th>Payment Type</th>
                      <th>Status</th>
                      <th>Images</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php


          while($row=$select_query->fetch_assoc())
          {

            $MONTHLY_TEMP_DIR = 'monthlypass/'.$row['vendor_id'].'/';
?>
                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                       <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['vehicle_number'].'<br/>('.$row['vehicle_type'].')'; ?></td>
 		        	        <td><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                      <td><?php echo $row['vendor_name'].'<br/>('.$row['vendor_mobile'].')'; ?></td>
                       <td><?php echo $row['vendor_address']; ?></td>
                      <td><?php echo 'Start : '.$row['start_date'].'<br/> To : '.$row['end_date']; ?></td>
                      <td><?php echo date('Y-m-d',$row['pass_issued_date']); ?></td>
                      
                      <td><?php echo $row['amount']; ?></td>
                      <td><?php echo $row['payment_type']; ?></td>
                      <td><?php  if($row['status']==1){ echo 'Active'; } else {  echo 'Expire'; } ?></td>

                      <td> <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['user_image']; ?>" title="View User Image"><i class="icon-user"></i></a>  &nbsp;&nbsp; 
                        <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['vehicle_image']; ?>" title="View Vehicle Image"><i class="fa fa-motorcycle"></i></a>
                      </td>

                      <td class="center" id="user-action-<?php echo $row['id'];?>"> 
                        <?php 
                        if($row['status']==1){ ?>
                           <a class="" title="Expire" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=0"><i class="icon-eye-close" style="color: red;"></i> </a>
                        <?php } else { ?>
                           <a class="" title="Active" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=1"><i class="icon-eye-open" style="color: green;"></i> </a>
                        <?php } ?> &nbsp;&nbsp;
                       
              <a title="Edit" href="add-monthly-pass.php?action=edit&id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp;
              
              <a title="Delete" href="all-monthly-pass.php?action=delete&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="icon-remove"></i></a>
                   
            </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                 
                </table>
           </div>
 <!-- Modal -->
 


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