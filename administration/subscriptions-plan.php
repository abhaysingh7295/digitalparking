<?php include 'header.php'; 

if($_GET['action']=='status'){
  $status = $_GET['status'];
  $id = $_GET['id'];
  $aqled = "update `subscriptions_plans` SET status = '".$status."' where id = ".$id;
  $ress = $con->query($aqled);
  if($ress){
    header('location:subscriptions-plan.php');
  }
} else if($_GET['action']=='delete'){
  $id = $_GET['id'];
  $sql = "DELETE FROM `subscriptions_plans` WHERE id='".$id."'";
  if ($con->query($sql) === TRUE) {
    header('location:subscriptions-plan.php');
  }
}


$subscriptions_plans = $con->query("select * from `subscriptions_plans`");
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Subscriptions Plans</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Subscriptions Plans</li>
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
                                  <th>Plan Name</th>
                                  <th style="display: none;">ID</th>
                                  <th>Amount</th>
                                  <th>Staff Capacity</th>
                                  <th>Export Capacity</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                  while($row=$subscriptions_plans->fetch_assoc())
                                  { $status = $row['status']; ?>
                                  <tr class="gradeX">
                                    <td><?php echo $row['plan_name']; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['plan_amount']; ?></td>
                                    <td><?php echo $row['staff_capacity']; ?></td>
                                    <td><?php echo $row['report_export_capacity']; ?></td>
                                    <td><?php echo date('d-m-Y',$row['date_time']); ?></td>
                                    <td><?php if($status==1){ echo 'Active'; } else { echo 'Deactivate'; } ?></td>
                                    <td>
                                    <?php if($status==1){ ?>
                                      <a class="" title="Deactivate" href="subscriptions-plan.php?action=status&id=<?php echo $row['id'];?>&status=0"><i class="fas fa-user-alt-slash" style="color: red;"></i> </a>
                                    <?php } else { ?>
                                      <a class="" title="Activate" href="subscriptions-plan.php?action=status&id=<?php echo $row['id'];?>&status=1"><i class="fas fa-user-check" style="color: green;"></i> </a>
                                    <?php } ?> &nbsp;&nbsp;

                                      <a title="Edit" href="add-subscription-plan.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" ><i class="fas fa-user-edit"></i></a>&nbsp;&nbsp;

                                      <a title="Delete" href="subscriptions-plan.php?action=delete&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" onclick="return confirm('Are you sure to delete this Plan?')"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;

                                    </td>
                                  </tr>
                                  <?php } ?>
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