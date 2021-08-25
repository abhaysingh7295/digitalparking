<?php include 'header.php'; 
if($_GET['id']) 
  {
  $id = $_REQUEST['id'];
  $sql = "DELETE FROM `offers` WHERE id='".$id."'";
    if ($con->query($sql) === TRUE) {
      header('location:offers-info.php');
    } 
}
?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Offers Information</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Offers Information</li>
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
                                  <th>Code</th>
                                  <th>Price</th>
                                  <th>Present</th>
                                  <th>Expire</th>
                                  <th>Image</th>
                                  <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $select_query = $con->query("SELECT * FROM `offers` WHERE vendor_id = ".$current_user_id." ORDER BY id DESC");
                                    $i = 1;
                                    while($row=$select_query->fetch_assoc())
                                    { ?>
                                    <tr class="gradeX" id="fare-<?php echo $row['id'];?>">
                                      <td><?php echo $i; ?></td>
                                      <td style="display: none;"><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['name']; ?></td>
                                      <td><?php echo $row['code']; ?></td>
                                      <td><?php echo $row['price']; ?></td>
                                      <td><?php echo $row['present']; ?></td>
                                      <td><?php echo $row['expire_date']; ?></td>
                                       
                                      <td> <?php if($row['image']){ ?>  <img src="<?php echo $row['image'];  ?>" width="50" height="50"> <?php }  ?></td>
                                      <td class="center" id="user-fare-<?php echo $row['id'];?>"> 
                                      
                                          <a title="Delete" href="offers-info.php?id=<?php echo $row['id'];?>" ><i class="far fa-trash-alt"></i></a>
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
