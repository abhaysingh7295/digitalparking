<?php include 'header.php';

$user_id = $_GET['user_id'];


$select_querysuser = $con->query("SELECT * FROM `pa_users` where id = '".$user_id."'");
  $rowuser=$select_querysuser->fetch_assoc(); 



?>
<!--main content start-->

<section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> <strong><?php echo $rowuser['first_name'].' '.$rowuser['last_name']; ?></strong> All Parking History </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">

<?php 
if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

//$vehicle_book_query = $con->query("SELECT * FROM `vehicle_book` where (vehicle_in_date_time between date('".$getstart."') AND date('".$getend."') OR vehicle_out_date_time between date('".$getstart."') AND date('".$getend."'))AND user_id = '".$user_id."' ORDER BY id DESC");

  $vehicle_book_query = $con->query("SELECT * FROM `vehicle_book` where (STR_TO_DATE(vehicle_in_date_time, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(vehicle_in_date_time, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(vehicle_out_date_time, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(vehicle_out_date_time, '%Y-%m-%d') <= '".$getend."')AND user_id = '".$user_id."' ORDER BY id DESC");


} else {
  $getstart = '';
  $getend = '';

  $vehicle_book_query = $con->query("SELECT * FROM `vehicle_book` where user_id = '".$user_id."' ORDER BY id DESC");
}

?>


 <form action="" method="get"> 
   <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
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
                <table  class="display table table-bordered table-striped" id="exampleusers">
                  <thead>
                    <tr>
                       <th style="display: none;">ID</th>
                      <th>Vehicle Number</th>
                      <th>Mobile Number</th>
                     
                      <th>Booked By</th>
                      <th>Vehicle Type</th>
                      <th>In Time</th>
                      <th>Out</th>
                      <th>Status</th>
                       <th>Total Amount</th>
                      <th>Advance Amount</th>
                      <th>Due Amount</th>
                      <th>To Pay Amount</th>
                      <th>Total Received Amount</th>
                    </tr>
                  </thead>
                  <tbody id="userlistshow">
                    <?php


$face_info = $con->query("SELECT * FROM `face_info` Where user_id='".$user_id."'");
$val_face_info = $face_info->fetch_assoc(); 
		
while($row=$vehicle_book_query->fetch_assoc())
{
    
    $in_time = $row['vehicle_in_date_time'];
	$parking_type = $row['parking_type'];
	$vehicle_type = $row['vehicle_type'];
	$advance_amount = $row['advance_amount'];
		
    if($row['vehicle_status']=='In'){
		$perhouramount = 0;
		$hour_diffrance = 0;
		$days_diffrance = 0;
		
		if($parking_type=='hour'){
			if($vehicle_type=='2'){
				$wheeler = 'h_two_wheeler';
			} else if($vehicle_type=='3'){
				$wheeler = 'h_three_wheeler';
			} else if($vehicle_type=='4'){
				$wheeler = 'h_four_wheeler';
			}


			$starttimestamp = strtotime($in_time);
			$endtimestamp = strtotime(date('Y-m-d H:i:s'));
			$difference = abs($endtimestamp - $starttimestamp)/3600;
			$hour_diffrance = ceil($difference);
			$perhouramount = $val_face_info[$wheeler];
			$total_bill_amount = $perhouramount * $hour_diffrance;
		} else if($parking_type=='days'){
			if($vehicle_type=='2'){
				$wheeler = 'd_two_wheeler';
			} else if($vehicle_type=='3'){
				$wheeler = 'd_three_wheeler';
			} else if($vehicle_type=='4'){
				$wheeler = 'd_four_wheeler';
			}

			$then = $in_time;
			$then = strtotime($then);
			$now = time();
			//Calculate the difference.
			$difference = $now - $then;
			//Convert seconds into days.
			$days_diffrance = ceil($difference / (60*60*24) );
			$perdayamount = $val_face_info[$wheeler];
			$total_bill_amount = $perdayamount * $days_diffrance;
		}
	
			$due_amount = $total_bill_amount - $advance_amount;
			if($due_amount < 0){
		 		$total_due_amount = 0;
		 		$total_pay_amount = $due_amount;
		 	} else {
		 		$total_due_amount = $due_amount;
		 		$total_pay_amount = 0;
		 	}
		 	
		$total_received_amount = $total_bill_amount - $advance_amount + $total_due_amount;
    } else {
        $total_bill_amount = $row['total_amount'];
        $total_due_amount = $row['due_amount'];
	    $total_pay_amount = $row['to_pay_amount'];
	    
	    
    }
        
        $total_received_amount =  $row['advance_amount'] + $row['due_amount'] - $row['to_pay_amount'];
		
		
?>
                    <tr class="gradeX">
                       <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td><?php echo $row['vehicle_number']; ?></td>
                      <td><?php echo $row['mobile_number']; ?></td>
                     
                      <td><?php echo $row['booked_by']; ?></td>
                      <td><?php echo $row['vehicle_type']; ?> Wheeler</td>
                      <td><?php echo $row['vehicle_in_date_time']; ?></td>
                      <td><?php echo $row['vehicle_out_date_time']; ?></td>
                      <td><?php echo $row['vehicle_status']; ?></td>
                       <td><?php echo $total_bill_amount; ?></td>
                      <td><?php echo $row['advance_amount']; ?></td>
                      <td><?php echo $total_due_amount; ?></td>
                      <td><?php echo $total_pay_amount; ?></td>
                      <td><?php echo $total_received_amount; ?></td>
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