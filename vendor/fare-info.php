<?php include 'header.php'; 
if($_GET['id']) 
  {
  $id = $_REQUEST['id'];
  $sql = "DELETE FROM `fare_info` WHERE id='".$id."'";
    if ($con->query($sql) === TRUE) {
      header('location:fare-info.php');
    } 
}
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Fare Information</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Fare Information</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                           
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                  <th>S.No.</th>
                                  <th style="display: none;">ID</th>
                                  <th>Initial Hour</th>
                                  <th>Ending Hour</th>
                                  <th>Amount</th>
                                  <th>Fare Status</th>
                                  <th>Vehicle Type</th>
                                  <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $select_query = $con->query("SELECT * FROM `fare_info` WHERE user_id = ".$current_user_id." ORDER BY id DESC");
                                    $i = 1;
                                    while($row=$select_query->fetch_assoc())
                                    { ?>
                                    <tr class="gradeX" id="fare-<?php echo $row['id'];?>">
                                      <td><?php echo $i; ?></td>
                                      <td style="display: none;"><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['initial_hr']; ?></td>
                                      <td><?php echo $row['ending_hr']; ?></td>
                                      <td><?php echo $row['amount']; ?></td>
                                      <td><?php echo $row['hr_status']; ?></td>
                                      <td><?php echo $row['veh_type']; ?></td>
                                      <td class="center" id="user-fare-<?php echo $row['id'];?>"> 
                                      <a title="Edit" href="add-fare.php?edit=<?php echo $row['id'];?>"><i class="far fa-edit"></i></a>&nbsp;&nbsp;
                                      <a title="Delete" href="fare-info.php?id=<?php echo $row['id'];?>" ><i class="far fa-trash-alt"></i></a>
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