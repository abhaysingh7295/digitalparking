<?php include 'header.php'; 

 $currentdate = date('Y-m-d');
 
if(isset($_GET['action']) == 'status'){
  $id = $_GET['id'];
  $status = $_GET['status'];
  $aqled =  $con->query("update `monthly_pass` SET status = '".$status."' where id = ".$id);
  $con->query("update `vehicle_qr_codes` SET status = '".$status."' where ref_type = 'monthly_pass' AND ref_id = ".$id);

  header('location:all-monthly-pass.php');
} else if(isset($_GET['action']) == 'delete'){
  $id = $_GET['id'];
  $con->query("DELETE FROM `monthly_pass` WHERE id='".$id."'");
  $con->query("DELETE FROM `vehicle_qr_codes` WHERE ref_id='".$id."'");
  header('location:all-monthly-pass.php');
}
if($_GET['submit']){
 
       $vehicle_no= $_GET['vehicle_no'];
       $select_query = $con->query("SELECT * FROM `monthly_pass` WHERE vehicle_number =  '". $vehicle_no."'");
       $row=$select_query->fetch_assoc();
       $monthly_pass_id=$row['id'];
       $start_date = $row['start_date'];
       $end_date = $row['end_date'];
       $grace_date = $row['grace_date'];
       
   
       
 if($monthly_pass_id=="") 
 {
      $msg1 = "Vehicle not found.";
     // header('location:new-renewpass.php');
 }
/** else if ($currentdate < $grace_date)
 {
      $msg1 = "not able to renew pass it is already not expired";
 }**/
 else
 {
      header('location:pass-renew.php?vehicle_no='.$vehicle_no.'&submit=submit');
 }
  

$vehicle_no = $_GET['vehicle_no'];


  //$select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");
   $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id. " ORDER BY id DESC");

} else {

  if($active_plans_row['report_export_capacity'] > 0){
  //  $getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
  //  $getend = $currentdate;
  } else {
 //   $getstart = $currentdate;
 //   $getend = $currentdate;
  }

 //$select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");

  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE start_date = DATE_FORMAT(NOW(),'%Y-%m-%d') AND vendor_id = ".$current_user_id." AND (FROM_UNIXTIME(m.pass_issued_date, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(m.pass_issued_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");

}


?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Renew Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Renew Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <?php
            if($msg1!='')
            {
                echo $msg1;
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <form action="" method="get" class="filterform"> 
                            <div class="form-group">
                              <div>
                               
                                  <input type="text" class="form-control" name="vehicle_no" placeholder="Vehicle Number" value="<?php echo $vehicle_no; ?>"/>
                                  
                                  <!--<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>-->
                                  <button style="margin-top:20px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
                               
                            </div>
                            </div>
                          </form>
                          

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
  <?php include '../administration/formscript.php'; ?>

   <?php if($active_plans_row['report_export_capacity'] > 0){
    $calstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $calend = $currentdate;
  } else {
    $calstart = $currentdate;
    $calend = $currentdate;
  } ?>
<script type="text/javascript">
  $(document).ready(function(){
      $('#vdate-range').datepicker({
            format: 'yyyy-mm-dd',
            toggleActive: true,
            startDate: new Date('<?php echo $calstart; ?>'),
            endDate: new Date('<?php echo $calend; ?>')
      });
  })
</script>


  <?php include 'footer.php' ?>