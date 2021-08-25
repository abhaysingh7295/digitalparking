<?php include 'header.php'; 

$vehicle_id = $_GET['vehicle_id']; 

if(!$vehicle_id)
{
    header('location:all-sensitive-vehicles.php');
    exit();
}


/*if($_GET['action']=='delete'){
  $id = $_GET['id'];
  $sql = "DELETE FROM `sensitive_vehicle_remark` WHERE id='".$id."'";
  if ($con->query($sql) === TRUE) {
    header('location:view-sensitive-vehicle-remarks.php?vehicle_id='.$vehicle_id);
  }
}*/


//$sensitive_vehicle = $con->query("select * from `sensitive_vehicle`");

$sensitive_vehicle_remark = $con->query("select svr.*, a.display_name,a.User_name from `sensitive_vehicle_remark` as svr LEFT JOIN login as a ON svr.admin_id = a.Id WHERE sansitive_vehicle_id='".$vehicle_id."'");

?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sensitive Vehicles Remarks</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Sensitive Vehicles Remarks</li>
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
                          <a href="add-sensitive-vehicle-remark.php?vehicle_id=<?php echo $vehicle_id;?>" class="btn btn-info waves-effect waves-light">Add Sensitive Vehicle Remark</a>
                        </div>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No</th>
                                  <th style="display: none;">ID</th>
                                  <th>Date</th>
                                  <th>Remarked By</th>
                                  <th>Remark</th>
                                 <!--  <th>Action</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$sensitive_vehicle_remark->fetch_assoc())
                                  {  ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo date('d-m-Y h:i A',$row['date_time']); ?></td>
                                    <td><?php echo $row['display_name'].' ('.$row['User_name'].')'; ?></td>
                                    <td><?php echo $row['remark']; ?></td>
                                    <!-- <td>
                                      <a title="Delete" href="view-sensitive-vehicle-remarks.php?action=delete&id=<?php echo $row['id'];?>&vehicle_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to delete this Sensitive Vehicle?')"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;

                                    </td> -->
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

  <?php include '../administration/datatablescript.php'; ?>



<?php include 'footer.php' ?>