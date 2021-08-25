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
  $getstart = $_GET['start_date'];
  $getend = $_GET['end_date'];

  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");
 //  $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id." AND (FROM_UNIXTIME(m.pass_issued_date, '%Y-%m-%d') >= '".$getstart."' AND FROM_UNIXTIME(m.pass_issued_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC");
 //echo "SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$current_user_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$getend."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$getstart."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$getend."') ORDER BY id DESC";
 //exit;


} else {

  if($active_plans_row['report_export_capacity'] > 0){
    $getstart = date('Y-m-d',strtotime('-'.$active_plans_row['report_export_capacity'].' months'));
    $getend = $currentdate;
  } else {
    $getstart = $currentdate;
    $getend = $currentdate;
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
                        <h4 class="page-title">All Monthly Pass</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Monthly Pass</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <form action="" method="get" class="filterform"> 
                            <div class="form-group">
                              <div>
                                <div class="input-daterange input-group" id="vdate-range">
                                  <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo $getstart; ?>" />
                                  <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" value="<?php echo $getend; ?>"/>
                                  <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>
								   <button style="margin-left:10px;" type="button" name="submit" id="searchreceipt" value="submit" class="btn btn-danger">Export PDF</button>
                                 <!--  <a href="add-monthly-pass.php">   -->
                                 <!--<button style="margin-left:5px;" type="button" name="submit1" value="Add Pass" class="btn btn-danger">Monthly Pass</button></a>-->
                                 <!-- <a href="new-renewpass.php">                                                                 <button style="margin-left:5px;" type="button" name="submit2" value="Add Pass" class="btn btn-danger">Renew Vehicle Pass</button>-->
                                  </a>
                                 
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
                                  <th>Company</th>    
                                  <th>Start / End Date</th>
                                  <th>Issuing Date</th>
                                  <th>Grace Date</th>
                                  <th>Amount</th>
                                  <th>Payment Type</th>
                                  <th>Status</th>
                                  <!--<th>Images</th>-->
                                  <!--<th class="">Action</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  $total_amount = 0;
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


                                    $select_qr = $con->query("SELECT * FROM `vehicle_qr_codes` Where ref_id=".$row['id']." AND ref_type='monthly_pass'");
                                    $qr_code_row = $select_qr->fetch_assoc();
                                    $qr_code = $qr_code_row['qr_code'].'.png';

                                    $MONTHLY_TEMP_DIR = 'monthlypass/'.$row['vendor_id'].'/';?>
                                    <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                      <td><?php echo $i; ?></td>
                                      <td style="display: none;"><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['vehicle_number'].'<br/>('.$row['vehicle_type'].')'; ?></td>
                                      <td><?php echo $row['customer_name'].'<br/>('.$row['mobile_number'].')'; ?></td>
                                      <td><?php echo $row['company_name']; ?></td>
                                      <td><?php echo 'Start : '.$start_date.'<br/> To : '.$end_date; ?></td>
                                      <td><?php echo date('d-m-Y',$row['pass_issued_date']); ?></td>
                                       <td><?php  echo $row['grace_date']; ?></td>
                                      
                                       <td><?php echo $row['amount']; ?></td>
                                      <td><?php echo $row['payment_type']; ?></td>
                                      <?php
                                       $today=date("Y-m-d");
                                         $curdate=strtotime($today);
                                          $edate=strtotime($end_date);
                                        ?>
                                      <td><?php  if($row['status']==1 || $edate>$curdate){ echo 'Active'; } else if($row['status']==2){ echo 'Applied'; } else if($row['status']==4){ echo 'Grace'; } else {  echo 'Expire'; } ?></td>
                                      <!--<td> -->
                                      <!--  <?php if($row['user_image']){ ?>-->
                                      <!--    <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['user_image']; ?>" title="View User Image"><i class="fas fa-user"></i></a>  &nbsp;&nbsp; -->
                                      <!--  <?php } ?>-->
                                      <!--  <?php if($row['vehicle_image']){ ?>-->
                                      <!--    <a target="_blank" href="<?php echo $MONTHLY_TEMP_DIR.$row['vehicle_image']; ?>" title="View Vehicle Image"><i class="fas fa-motorcycle"></i></a>-->
                                      <!--  <?php } ?>-->
                                      <!--</td>-->
                                      <!--<td class="center" id="user-action-<?php echo $row['id'];?>"> -->
                                      <!--  <?php if($row['status']==1){ ?>-->
                                      <!--    <a class="" title="Expire" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=0"><i class="far fa-eye-slash" style="color: red;"></i> </a>-->
                                      <!--  <?php } else { ?>-->
                                      <!--    <a class="" title="Active" href="all-monthly-pass.php?action=status&id=<?php echo $row['id'];?>&status=1"><i class="far fa-eye" style="color: green;"></i> </a>-->
                                      <!--  <?php } ?> &nbsp;&nbsp;-->
                                      <!--    <a title="Edit" href="add-monthly-pass.php?action=edit&id=<?php echo $row['id'];?>" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;-->
                                      <!--    <?php if($row['status']!=1){ ?>-->
                                        <!--  <a title="Renew Pass" href="pass-renew.php?id=<?php echo $row['id'];?>"><i class="mdi mdi-reload"></i></a> !-->
                                      <!--    <?php } ?>-->
                                          <?php /*$QR_FILE_DIR = CUSTOMER_QR_DIR.$qr_code;
                                            if(file_exists($QR_FILE_DIR)){ ?>
                                         <a title="QR Code" href="<?php echo CUSTOMER_QR_URL.$qr_code; ?>" target="_blank"><i class="fas fa-qrcode"></i></a>
                                        <?php } */ ?>
                                      <?php /* ?><a title="Delete" href="all-monthly-pass.php?action=delete&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="far fa-trash-alt"></i></a> <?php */ ?>
                                      <!--</td>-->
                                    </tr>
                                  <?php $total_amount = $total_amount + $row['amount'];
                                  $i++; } ?>
                                </tbody>

                                <tfoot>
                                  <tr>
                                    <th colspan="7"> Total Amount</th>
                                    <th><i class="fas fa-rupee-sign"></i> <?php echo $total_amount; ?></th>
                                    <th colspan="8"></th>
                                    
                                  </tr>
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
<script type="text/javascript">
    function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title>Report</title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write(data);
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
    $(document).on('click', '#searchreceipt', function () {
        var vendor_id = '<?php echo $current_user_id ;?>';
		var startDate= $('#start_date').val();
         var   endDate=$('#end_date').val();
        $.ajax({
            url: 'all-monthly-pass-pdf.php',
            type: 'get',
            data: {'vendor_id': vendor_id,startDate:startDate,endDate:endDate},
            success: function (response) {
                Popup(response);
            }
        });
    });

</script>

  <?php include 'footer.php' ?>