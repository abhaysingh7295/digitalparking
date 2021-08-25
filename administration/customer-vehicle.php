<?php include 'header.php';
$user_id = $_GET['user_id']; ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Customer Vehicles</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Customer Vehicles</li>
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
                                  <th>Vehicle Number</th>
                                  <th>Vehicle Type</th>
                                  <th>Vehicle Photo / RC</th> 
                                  <th>Added Date</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $select_query = $con->query("SELECT * FROM `customer_vehicle` WHERE customer_id = ".$user_id." ORDER BY id DESC");
                                $i = 1;
                                while($row=$select_query->fetch_assoc())
                                {  
                                    /*$select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where ref_id=".$row['id']." AND ref_type='customer_vehicle'");
                                    $qr_code_row = $select_qr->fetch_assoc();
                                    $qr_code = $qr_code_row['qr_code'].'.png';*/

                                    $vehicle_photo_DIR = '../uploads/'.$row['vehicle_photo'];
                                   $vehicle_rc_DIR = '../uploads/'.$row['vehicle_rc']; ?>
                                  <tr class="gradeX" >                                   
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['vehicle_number']; ?></td>
                                    <td title=""><?php echo $row['vehicle_type']; ?></td>
                                    <td><?php 
                                    if(file_exists($vehicle_photo_DIR)){ ?>
                                      <a href="<?php echo $vehicle_photo_DIR; ?>" target="_blank" title="View Vehicle Photo"><i class="fas fa-car-side"></i></a>
                                    <?php } ?> &nbsp;&nbsp;
                                    <?php 
                                    if(file_exists($vehicle_rc_DIR)){ ?>
                                      <a href="<?php echo $vehicle_rc_DIR; ?>" target="_blank" title="View Vehicle RC"><i class="far fa-credit-card"></i></a>&nbsp;&nbsp;
                                    <?php } ?>

                                    <?php /* $QR_FILE_DIR = CUSTOMER_QR_DIR.$qr_code;
                                            if(file_exists($QR_FILE_DIR)){ ?>
                                          <a title="QR Code" href="<?php echo CUSTOMER_QR_URL.$qr_code; ?>" target="_blank"><i class="fas fa-qrcode"></i></a>
                                        <?php } */ ?>

                                    </td>
                                    <td><?php echo date('d-m-Y',$row['date_time']); ?></td>
                                    <td><a title="Edit" href="edit-customer-vehicle.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $user_id; ?>" id="<?php echo $row['id']; ?>"><i class="far fa-edit"></i></a></td>
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


    

<?php include 'datatablescript.php'; ?>
 
  <!--main content end-->
  <?php include 'footer.php' ?>