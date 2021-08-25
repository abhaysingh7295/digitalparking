<?php include 'header.php';

$id = $_GET["id"];
?>
<!--main content start-->

<section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">Vehicle Payment History </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
 
 
 <?php 
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

  //echo "SELECT * FROM `payment_history` where (FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$getend."') AND booking_id = '".$id."' ORDER BY id DESC"; die; 

  $vehicle_book_query = $con->query("SELECT * FROM `payment_history` where (FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$getend."') AND booking_id = '".$id."' ORDER BY id DESC");

} else {
  $getstart = '';
  $getend = '';

  $vehicle_book_query = $con->query("SELECT * FROM `payment_history` where booking_id = '".$id."' ORDER BY id DESC");
}

?>


 <form action="" method="get"> 
   <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
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
                <table  class="display table table-bordered table-striped" id="exampleusers" data-page-length="50">
                  <thead>
                    <tr>
                       <th style="display: none;">ID</th>
                      <th>Amount (Rs.)</th>
                      <th>Payment Type</th>
                      <th>Transaction ID</th>
                      <th>Payment Date</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php while($row=$vehicle_book_query->fetch_assoc())
                          { 
                             ?>
                    <tr class="gradeX">
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['amount']; ?></td>
                      <td><?php echo $row['payment_type']; ?></td>
                      <td><?php echo $row['transaction_id']; ?></td>
                      <td><?php echo date('Y-m-d h:i A',$row['payment_date_time']); ?></td>
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
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