<?php include 'header.php'; 

 if($_GET['submit']){
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];
  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC ");
 // echo "SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC ";
//exit;
     
 } else {
  $getstart = '';
  $getend = '';
 // $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id ORDER BY id DESC ");
  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (DATE_FORMAT(m.pass_issued_date ,'%Y-%m-%d')) = (DATE_FORMAT(NOW(),'%Y-%m-%d')) ORDER BY id DESC ");
//  echo "SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.mobile_number as vendor_mobile, v.parking_name, CONCAT_WS(' ', v.address,v.state,v.city) as vendor_address FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id LEFT JOIN `pa_users` as v on m.vendor_id = v.id WHERE (DATE_FORMAT(m.pass_issued_date ,'%Y-%m-%d')) = (DATE_FORMAT(NOW(),'%Y-%m-%d')) ORDER BY id DESC ";
  

}
  

 ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Vehicle Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Vehicle Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <form action="" method="get" style="width: 30%;"> 
                            <div class="form-group">
                              <div>
                                <div class="input-daterange input-group" id="date-range">
                                  <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                  <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                            </div>
                          </form>
                           
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                      <th>S.No.</th>
                                      <th style="display: none;">ID</th>
                                      <th>Vehicle No</th>
                                      <th>Customer Name</th>
                                      <th>Vendor Name</th>   
                                       
                                      <th>Start / End Date</th>
                                      <th>Issuing Date</th>
                                      <th>Amount</th>
                                      <th>Payment Type</th>
                                      <th>Parking Name</th>
                                      <th>Vendor Address</th>
                                      <th>Status</th>
                                      <th>Images</th>
                                      <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  while($row=$select_query->fetch_assoc())
                                  {
                                    $start_date = '';
                                    $end_date = '';
                                    if($row['start_date']){
                                       //$explode_start_date = explode('-',$row['start_date']);
                                      // $start_date = $explode_start_date[2].'-'.$explode_start_date[1].'-'.$explode_start_date[0];
                                       $start_date = date('d-m-Y', strtotime($row['start_date']));
                                    }
                                    if($row['end_date']){
                                       //$explode_end_date = explode('-',$row['end_date']);
                                       //$end_date = $explode_end_date[2].'-'.$explode_end_date[1].'-'.$explode_end_date[0];
                                       $end_date = date('d-m-Y', strtotime($row['end_date']));
                                    }
                                   
                                     
                                    $MONTHLY_TEMP_DIR = SITE_URL.'/vendor/monthlypass/'.$row['vendor_id'].'/'; ?>
                                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                      <td><?php echo $i; ?></td>
                                      <td style="display: none;"><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['vehicle_number'].'<br/>('.$row['vehicle_type'].')'; ?></td>
                                      <td><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                                      <td><?php echo $row['vendor_name'].'<br/>('.$row['vendor_mobile'].')'; ?></td>
                                      
                                      <td><?php echo 'Start : '.$start_date.'<br/> To : '.$end_date; ?></td>
                                      <td><?php echo date('d-m-Y',$row['pass_issued_date']); ?></td>
                                      <td><?php echo $row['amount']; ?></td>
                                      <td><?php echo $row['payment_type']; ?></td>
                                      <td><?php echo $row['parking_name']; ?></td>
                                      <td><?php echo $row['vendor_address']; ?></td>
                                      <td><?php if($row['status']==1){ echo 'Active'; } else if($row['status']==2){ echo 'Applied'; } else {  echo 'Expire'; } ?></td>
                                      <td>
                                        <?php if($row['user_image']){ ?>
                                        <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['user_image']; ?>" title="View User Image"><i class="icon-user"></i></a>  &nbsp;&nbsp; 
                                      <?php } ?>
                                      <?php if($row['vehicle_image']){ ?>
                                        <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['vehicle_image']; ?>" title="View Vehicle Image"><i class="fa fa-motorcycle"></i></a>
                                        <?php } ?>
                                      </td>
                                      <td class="center" id="user-action-<?php echo $row['id'];?>"> 
                                      <?php if($row['status']==1){ ?>
                                        <a class="" title="Expire" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=0"><i class="fas fa-eye-slash" style="color: red;"></i> </a>
                                      <?php } else { ?>
                                        <a class="" title="Active" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=1"><i class="far fa-eye" style="color: green;"></i> </a>
                                      <?php } ?> &nbsp;&nbsp;

                                      <a title="Edit" href="edit-monthly-pass.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="far fa-edit"></i></a> &nbsp;&nbsp;

                                        <?php  $select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where vehicle_number='".$row['vehicle_number']."'");
                                          $qr_code_row = $select_qr->fetch_assoc();
                                          $qr_code = $qr_code_row['qr_code'].'.png';

                                        $QR_FILE_DIR = CUSTOMER_QR_DIR.$qr_code;
                                            if(file_exists($QR_FILE_DIR)){ ?>
                                          <a title="QR Code" href="<?php echo CUSTOMER_QR_URL.$qr_code; ?>" target="_blank"><i class="fas fa-qrcode"></i></a>
                                        <?php }  ?>

                                        <!-- <a title="Edit" href="add-monthly-pass.php?action=edit&id=<?php echo $row['id'];?>" ><i class="far fa-edit"></i></a>&nbsp;&nbsp; -->
                                        <!-- <a title="Delete" href="all-monthly-pass.php?action=delete&id=<?php //echo $row['id'];?>" id="<?php //echo $row['id'];?>"><i class="far fa-trash-alt"></i></a> -->
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
<?php include 'datatablescript.php'; ?>
 <?php include 'formscript.php'; ?>
  <!--main content end-->
  <?php include 'footer.php' ?>