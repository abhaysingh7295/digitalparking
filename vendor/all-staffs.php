<?php include 'header.php'; 

if($_GET['action']=='delete'){
    $id = $_GET['id']; 
    $sql = "DELETE FROM `staff_details` WHERE staff_id=".$id."";
    if ($con->query($sql) === TRUE) {
        header('location:all-staffs.php'); 
    }
}


if($_GET['action']=='loginstatus'){
    $id = $_GET['id']; 
    $sql = "update `staff_details` SET login_status = 0 where staff_id = ".$id;
    if ($con->query($sql) === TRUE) {
        header('location:all-staffs.php'); 
    }
}

if($_GET['action']=='active'){
    $id = $_GET['id']; 
    $sql = "update `staff_details` SET active_status = 'active' where staff_id = ".$id;
    if ($con->query($sql) === TRUE) {
        header('location:all-staffs.php'); 
    }
}

if($_GET['action']=='unactive'){
    $id = $_GET['id']; 
    $sql = "update `staff_details` SET active_status = 'unactive' where staff_id = ".$id;
    if ($con->query($sql) === TRUE) {
        header('location:all-staffs.php'); 
    }
}

$select_query = $con->query("SELECT * FROM `staff_details` WHERE user_id = ".$current_user_id." ORDER BY staff_id DESC");


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Staffs</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Staffs</li>
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
                                <th>Name</th>
                                  <th>Email</th>
                                  <th>Mobile</th>
                                  <th>Added Date</th>
                                  <th>Login Status</th>
                                  <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$select_query->fetch_assoc())
                                  { ?>
                                    <tr class="gradeX" id="user-details-<?php echo $row['staff_id'];?>">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['staff_id']; ?></td>
                                     <td><?php echo $row['staff_name']; ?></td>
                                    <td><?php echo $row['staff_email']; ?></td>
                                    <td><?php echo $row['staff_mobile_number']; ?></td>
                                    <td><?php echo date('d-m-Y h:i A', strtotime($row['staff_added'])); ?></td>
                                    <td><?php if($row['login_status']==1){ echo '<i title="Login" style="color:green" class="fas fa-circle" aria-hidden="true"></i>'; } else { echo '<i title="Logout" style="color:red" class="fas fa-circle" aria-hidden="true"></i>'; } ?></td>
                                    <td class="center" id="user-action-<?php echo $row['staff_id'];?>"> 
                                    <a title="Edit" href="add-staff.php?edit=<?php echo $row['staff_id'];?>" id="<?php echo $row['staff_id'];?>" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;
                                    <!-- <a title="Delete" href="all-staffs.php?action=delete&id=<?php //echo $row['staff_id'];?>" id="<?php //echo $row['staff_id'];?>"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp; -->
                                    <a href="staff-payment-recevied.php?id=<?php echo $row['staff_id'];?>" title="View Payment Received"><i class="fas fa-history" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                    <?php if($row['login_status']==1){ ?>
                                        <a href="all-staffs.php?action=loginstatus&id=<?php echo $row['staff_id'];?>" title="Logout"><i class="fas fa-user-lock" aria-hidden="true"></i></a>
                                    <?php } ?>
                                    <?php if($row['active_status']=='active'){ ?>
                                        <a href="all-staffs.php?action=unactive&id=<?php echo $row['staff_id'];?>" 
                                        class="btn btn-flat btn-default" data-method="delete"
                                        data-trans-button-cancel="Cancel"
                                        data-trans-button-confirm="Confirm"
                                        data-trans-title="Are you sure you want to do this?">
                                            <span class="badge badge-pill badge-info">Active</span>
                                         </a>
                                    <?php } else {?>        
                                        <a href="all-staffs.php?action=active&id=<?php echo $row['staff_id'];?>" 
                                        class="btn btn-flat btn-default" data-method="delete"
                                        data-trans-button-cancel="Cancel"
                                        data-trans-button-confirm="Confirm"
                                        data-trans-title="Are you sure you want to do this?">
                                            <span class="badge badge-pill badge-danger">Unactive</span>
                                         </a>
                                    <?php }?>

                                    </td>
                                    </tr>
                                <?php $i++; } ?>
                                </tbody>
                                
                                </tfoot>
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