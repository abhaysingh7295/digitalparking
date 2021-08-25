<?php include 'header.php'; 

if($_GET['action']=='status'){
  $status = $_GET['status'];
  $id = $_GET['id'];
  if($status==1){
    $aqled = "update `sensitive_vehicle` SET status = '".$status."', close_admin_id = '".$current_user_id."' where id = ".$id;
  } else {
    $aqled = "update `sensitive_vehicle` SET status = '".$status."', open_admin_id = '".$current_user_id."', close_admin_id = 0 where id = ".$id;
  }
  
  $ress = $con->query($aqled);
  if($ress){
    header('location:all-sensitive-vehicles.php');
  }
} else if($_GET['action']=='delete'){
  $id = $_GET['id'];

  $con->query("DELETE FROM `sensitive_vehicle_remark` WHERE sansitive_vehicle_id='".$id."'");
  $sql = "DELETE FROM `sensitive_vehicle` WHERE id='".$id."'";
  if ($con->query($sql) === TRUE) {
    header('location:all-sensitive-vehicles.php');
  }
}


if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

  $start = strtotime($getstart);
  $end =  strtotime($getend);
  //$sensitive_vehicle = $con->query("select sv.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name from `sensitive_vehicle` as sv LEFT JOIN pa_users as u ON sv.mobile_number = u.mobile_number WHERE u.user_role='customer' AND sv.`status` = 1 AND (submit_date_time) >= '".$start."' AND (submit_date_time) <= '".$end."'order by sv.id DESC"); 
  $sensitive_vehicle = $con->query("select sv.*,ps.police_station_name from `sensitive_vehicle` as sv left join police_stations as ps on ps.id=sv.polic_station  WHERE  sv.`status` = 1 AND (submit_date_time) >= '".$start."' AND (submit_date_time) <= '".$end."'order by sv.id DESC"); 
} else {

  $getstart = '';
  $getend = '';

  $sensitive_vehicle = $con->query("select sv.*,ps.police_station_name from `sensitive_vehicle` as sv left join police_stations as ps on ps.id=sv.polic_station order by sv.id DESC");
  //$sensitive_vehicle = $con->query("select sv.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name from `sensitive_vehicle` as sv LEFT JOIN pa_users as u ON sv.mobile_number = u.mobile_number WHERE u.user_role='customer' order by sv.id DESC");
}
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sensitive Vehicles</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Sensitive Vehicles</li>
                        </ol>
                    </div>
                </div>
                <!-- end row --> 
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <div class="card-body">
                            <form class="filterform" action="" method="get"> 
                              <div class="form-group">
                                <div>
                                    search for closed status
                                  <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                    <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                    <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
                                  </div>
                              </div>
                              </div>
                            </form>
                          <a href="add-sensitive-vehicle.php" class="btn btn-info waves-effect waves-light">Add Sensitive Vehicle</a>
                        </div>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No.</th>
                                  <th style="display: none;">ID</th>
                                  <th>CRN</th>
                                  <th>Vehicle</th>
                                  <th>Mobile No</th>
<!--                                  <th>Engine No</th>
                                  <th>Chassis No</th>-->
                                  <th>Police Station</th>
                                  <th>Reason</th>
                                  <th>Status</th>
                                  <th>Address</th>
                                  <th>Open / Close By</th> 
                                  <th>Find</th> 
                                  <th>Date Time</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$sensitive_vehicle->fetch_assoc())
                                  { 
                                    $address = $row['address'].' '.$row['city'].' '.$row['state'].'-'.$row['pin_code'];
                                    ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['crn_no']; ?></td>
                                    <td><?php echo $row['vehicle_number'].' ('.$row['vehicle_type'].')'; ?></td>
                                    <td><?php echo $row['customer_name'].'<br>('.$row['mobile_number'].')'; ?></td>
<!--                                    <td><?php echo $row['engine_number']; ?></td>
                                    <td><?php echo $row['chassis_number']; ?></td>-->
                                    <td><?php echo $row['police_station_name']; ?></td>
                                    <td><?php echo $row['search_reason']; ?></td>
                                    <td> <?php if($row['status']==1){ echo 'Closed'; } else { echo 'Open'; } ?></td>
                                    <td><?php echo $address; ?></td>
                                     <td><?php if($row['open_admin_id']!=0){
                                        $select_open_admin = $con->query("select display_name,User_name from `login` WHERE Id=".$row['open_admin_id']);
                                        $row_open_admin = $select_open_admin->fetch_assoc();
                                        echo '<br/>Open By : '.$row_open_admin['display_name'].' ('.$row_open_admin['User_name'].')'.'<br/>'; 
                                     } 
                                      if($row['close_admin_id']!=0){
                                        $select_close_admin = $con->query("select display_name,User_name from `login` WHERE Id=".$row['close_admin_id']);
                                        $row_close_admin = $select_close_admin->fetch_assoc();
                                        echo 'Closed By : '.$row_close_admin['display_name'].' ('.$row_close_admin['User_name'].')'.'<br/>'; 
                                     } ?></td> 
                                     <td><?php if($row['find']==1){ echo 'Found'; } else { echo 'Not Found'; }   ?></td>
                                    <td><?php echo date('d-m-Y h:i A',$row['submit_date_time']); ?></td>
                                    <td>
                                      <?php /*  ?>
                                      <a title="Edit" href="add-sensitive-vehicle.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;
                                      <?php */ ?>
                                      <?php if($row['status']==1){ ?>
                                         <a title="Open" href="all-sensitive-vehicles.php?action=status&status=0&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to Open this Sensitive Vehicle?')"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;
                                      <?php } else { ?>
                                          <a title="Close" href="all-sensitive-vehicles.php?action=status&status=1&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to Close this Sensitive Vehicle?')"><i class="fas fa-eye-slash"></i></a>&nbsp;&nbsp;
                                      <?php } ?>

                                      <!--<a title="Delete" href="all-sensitive-vehicles.php?action=delete&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to delete this Sensitive Vehicle?')"><i class="far fa-trash-alt"></i></a>-->&nbsp;&nbsp;

                                      <a title="View Sensitive Vehicles Remarks" href="view-sensitive-vehicle-remarks.php?vehicle_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="fas fa-comment-alt"></i></a>&nbsp;&nbsp;
                                      <?php if($row['photo_upload']){ 
                                        $photo_url = ADMIN_URL.'upload/sensitives/'.$row['photo_upload'];
                                        ?>
                                      <a title="View Upload Image" target="_blank" href="<?php echo $photo_url; ?>"><i class="far fa-image"></i></a>&nbsp;&nbsp;
                                    <?php } ?>
                                    </td>
                                  </tr>
                                  <?php $i++; } ?>
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
  <!--main content end-->

  <?php include 'datatablescript.php'; ?>

<?php include 'formscript.php'; ?>

<?php include 'footer.php' ?>