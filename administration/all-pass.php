<?php include 'header.php'; 
$currentdate = date('Y-m-d');

 if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
  $vendorid = $_GET['vendorid'];
 // echo "***".$vendorid;
  if($getstart !="" && $getend!="" && $vendorid!='')
  {
    $query = "SELECT m.vendor_id, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as parking_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') AND m.vendor_id =".$vendorid." GROUP BY m.vendor_id";
    
  }
  else if($getstart !="" && $getend!="" && $vendorid=='')
  {
    $query = "SELECT m.vendor_id, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as parking_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') GROUP BY m.vendor_id";
    
  }
  else if($getstart =="" && $getend=="" && $vendorid=='')
  {
       $getstart = $currentdate;
    $getend = $currentdate;
    $query = "SELECT m.vendor_id, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as parking_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') GROUP BY m.vendor_id";
    
  }
  else if($getstart =="" && $getend=="" && $vendorid!='')
  {
       $getstart = $currentdate;
    $getend = $currentdate;
    $query = "SELECT m.vendor_id, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as parking_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') AND m.vendor_id =".$vendorid." GROUP BY m.vendor_id";
    
  }
     
 }
 else
 {
     $getstart = $currentdate;
    $getend = $currentdate;
   $query = "SELECT m.vendor_id, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as parking_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') GROUP BY m.vendor_id";
    
 }
 
  $select_query = $con->query($query);


  

 ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Vehicle Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Vehicle Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>
<?php  //echo $query; exit; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <form action="" method="get" style="width: 60%;"> 
                            <div class="form-group ">
                             <div>
                                <div class="input-daterange input-group" id="date-range" style="width:30%; float:left">
                                    
                                  <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                  <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                 &nbsp;&nbsp;
                                 
                                 
                                    </div>
                                </div>
                                 <select class="form-control" name="vendorid" id="vendorid" style="width:20%; float:left">
                                    <option value="">Select Parking</option>
                                   <?php
                                    $vendorlist = $con->query("SELECT * FROM `pa_users` WHERE `user_role` LIKE 'vandor' AND `user_status` = 1");
                                    while($vendor_row=$vendorlist->fetch_assoc())
                                  {
                                     // $vendor_name = $vendor_row['first_name']." ".$vendor_row['last_name'];
                                     $parking = $vendor_row['parking_name'];
                                      ?>
                                      <option value="<?php echo $vendor_row['id'];?>" <?php if($vendor_row['id']==$vendorid){ ?> selected="selected" <?php } ?>><?php echo $parking;?></option>
                                      <?php
                                  }
                                    ?>
                                    </select>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
</div>
                          </form>
                           
                            <table id="datatable" class="table table-bordered dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                      <th>S.No.</th>
                                      <th></th>
                                      <th>Parking name</th>   
                                      <th>Address</th>
                                      <th>Total Vehicle Pass</th>
                                      <th>Total Parking IN</th>
                                      <th>Total Parking OUT</th>

                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                //  echo $select_query->num_row(); exit;
                                  while($row=$select_query->fetch_assoc())
                                  {
                                      $vendor_id = $row['vendor_id'];
                                       $select_query1 = $con->query("SELECT count(m.id) as total_pass FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') AND  m.vendor_id =".$vendor_id);
                                     //  echo "SELECT count(m.id) as total_pass FROM `monthly_pass` as m LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') AND status =1 AND  m.vendor_id =".$vendor_id;
                                    // $total_pass =0;
                                     
                                         while($row1=$select_query1->fetch_assoc())
                                          {
                                              $total_pass = $row1['total_pass'];
                                          }
                                         $select_query2 = $con->query("SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout FROM `vehicle_booking` as vb LEFT JOIN payment_history as ph ON ph.booking_id = vb.id WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$getstart."'  AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$getend."'  AND vb.vendor_id =".$vendor_id);
                                         while($row2=$select_query2->fetch_assoc())
                                          {
                                              $total_vin = $row2['vin'];
                                              $total_vout = $row2['vout'];
                                          }
                                     if($total_pass==0 && $total_vin==0 && $total_vout==0)
                                     {
                                     }
                                     else{
                                  ?>
                                    <tr class="">
                                      <td><?php echo $i; ?></td>
                                      <td></td>
                                      <td><?php echo $row['parking_name']."(".$vendor_id.")"; ?></td>
                                      <td><?php echo $row['parking_address']; ?></td>
                                      <td><?php echo $total_pass; ?></td>
                                      <td><?php echo $total_vin; ?></td>
                                       <td><?php echo $total_vout; ?></td>
                                  </tr>
                                  <?php   $i++; }} ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
<?php include 'datatablescript.php'; ?>
 <?php include 'formscript.php'; ?>
  <!--main content end-->
  <?php include 'footer.php' ?>