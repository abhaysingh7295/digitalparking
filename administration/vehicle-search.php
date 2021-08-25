<?php include 'header.php'; 

$vehicle_number = $_REQUEST['vehicle_number'];

if((!isset($vehicle_number))|| ($vehicle_number==''))
{
header('location:index.php');
}
 
$select_query = $con->query("SELECT vb.*, CONCAT_WS(' ', v.first_name, v.last_name) as vendor_name, v.user_email as vendor_email, v.mobile_number as vendor_mobile, CONCAT_WS(' ', v.address, v.city,v.state) as vendor_address, v.parking_name as parking_name, CONCAT_WS(' ', c.first_name, c.last_name) as customer_name,  c.user_email as customer_email, c.mobile_number as customer_mobile, CONCAT_WS(' ', c.address, c.city,c.state) as customer_address FROM `vehicle_booking` as vb JOIN `pa_users` AS v ON vb.vendor_id = v.id JOIN `pa_users` AS c ON vb.customer_id = c.id Where vb.vehicle_number LIKE '%".$vehicle_number."%' AND vb.vehicle_status='In'");
 ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Vehicle Search</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Vehicle Search</li>
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
                                  <th>Vendor Details</th>
                                  <th style="display: none;">ID</th>
                                  <th>Vendor Address</th>
                                  <th>Customer Details</th>
                                  <th>Customer Address</th>
                                  <th>Vehicle No.</th>
                                  <th>Parking Name</th>
                                  <th>Parking Date/Time</th>
                                  <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  while($row=$select_query->fetch_assoc()) { ?>
                                  <tr class="gradeX">
                                    <td><?php echo $row['vendor_name'].' <br/>'.$row['vendor_email'].' <br/>'.$row['vendor_mobile']; ?></td>
                                    <th style="display: none;"><?php echo $row['id']; ?></th>
                                    <td><?php echo $row['vendor_address']; ?></td>
                                    <td><?php echo $row['customer_name'].' <br/>'.$row['customer_email'].' <br/>'.$row['customer_mobile']; ?></td>
                                    <td><?php echo $row['customer_address']; ?></td>
                                    <td><?php echo $row['vehicle_number']; ?></td>
                                    <td><?php echo $row['parking_name']; ?></td>
                                    <td><?php echo date('Y-m-d h:i A',$row['vehicle_in_date_time']); ?></td>
                                    <td class="center"> 
                                    <a class="" title="View Vendor Details" href="user-details.php?user_id=<?php echo $row['vendor_id'];?>" id="<?php echo $row['user_id'];?>"><i class="far fa-eye"></i> </a>&nbsp;&nbsp;
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
<?php include 'datatablescript.php'; ?>
  <!--main content end-->
  <?php include 'footer.php' ?>