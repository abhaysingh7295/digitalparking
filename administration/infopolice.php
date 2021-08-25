<?php include 'header.php'; ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Inform to Controle</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Inform to Controle</li>
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
                                  <th>Customer Name</th>
                                  <th>Vehicle Number</th>
                                  <th>Vehicle Type</th>
                                  <th>Vehicle Category</th>
                                  <th>Remark</th>
                                  <th>Latitude</th>
                                  <th>Longitude</th>
                                  <th> Photo</th>
                                  <th>Added Date</th> 
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $select_query = $con->query("SELECT p.*, CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, u.mobile_number FROM `info_police`as p LEFT JOIN `pa_users`as u ON p.user_id = u.id ORDER BY id DESC");
                                  $i = 1;
                                  while($row=$select_query->fetch_assoc())
                                  {
                                   $upload_image = '../police-info-upload/'.$row['upload_image']; ?>
                                  <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                    
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td> 
                                     <td><?php echo $row['customer_name'].'<br>('.$row['mobile_number'].')'; ?></td>
                                    <td><?php echo $row['vechicle_no']; ?></td>
                                    <td><?php echo $row['vechicle_type']; ?></td>
                                    <td><?php echo $row['vechicle_category']; ?></td>
                                    <td><?php echo $row['remark']; ?></td>
                                    <td><?php echo $row['latitude']; ?></td>
                                    <td><?php echo $row['longitude']; ?></td>
                                    <td><?php  if($row['upload_image']){ ?>
                                      <a href="<?php echo $upload_image; ?>" target="_blank"><i class="far fa-file-image"></i></a>
                                    <?php } ?></td>
                                  <td><?php echo date('d-m-Y',$row['submit_date']); ?> <br/><?php echo date('h:i A',$row['submit_date']); ?></td>
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