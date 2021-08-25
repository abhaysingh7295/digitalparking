<?php include 'header.php'; 

if($_GET['action']=='status'){
  $status = $_GET['status'];
  $id = $_GET['id'];
  $aqled = "update `police_stations` SET status = '".$status."' where id = ".$id;
  $ress = $con->query($aqled);
  if($ress){
    header('location:all-police-stations.php');
  }
} else if($_GET['action']=='delete'){
  $id = $_GET['id'];
  $sql = "DELETE FROM `police_stations` WHERE id='".$id."'";
  if ($con->query($sql) === TRUE) {
    header('location:all-police-stations.php');
  }
}


$police_stations = $con->query("select police_stations.*, city.name as city_name, state.state_title as state_name from `police_stations` inner join city on city.id=police_stations.city inner join state on state.state_id=police_stations.state order by police_stations.id desc");
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Police Stations</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Police Stations</li>
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
                          <a href="add-police-station.php" class="btn btn-info waves-effect waves-light">Add Police Station</a>
                        </div>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No</th>
                                  <th style="display: none;">ID</th>
                                  <th>Police Station Name</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Name</th>
                                  <th>Designation</th>
                                  <th>Department</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$police_stations->fetch_assoc())
                                  { ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['police_station_name']; ?></td>
                                    <td><?php echo $row['state_name']; ?></td>
                                    <td><?php echo $row['city_name']; ?></td>
                                    <td><?php echo $row['name'].'<br/>'.$row['mobile_number']; ?></td>
                                    <td><?php echo $row['designation']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td>
                                      <a title="Edit" href="add-police-station.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" ><i class="fas fa-user-edit"></i></a>&nbsp;&nbsp;

                                      <a title="Delete" href="all-police-stations.php?action=delete&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to delete this Police Station?')"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;

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

  <?php include '../administration/datatablescript.php'; ?>



<?php include 'footer.php' ?>