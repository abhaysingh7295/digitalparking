<?php
include 'header.php';
$currentdate = date('Y-m-d');
$user_id = $_SESSION["current_user_ID"];
$limit = 10;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$query_string = "";
if ($_GET['submit']) {
    $getstart = $_GET['start_date'];
    $getend = $_GET['end_date'];
    $query_string = "&start_date=$getstart&end_date=$getend&submit=submit";
    $vs = "SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where (FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_in_date_time, '%Y-%m-%d') <= '" . $getend . "' OR FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') >= '" . $getstart . "' AND FROM_UNIXTIME(b.vehicle_out_date_time, '%Y-%m-%d') <= '" . $getend . "') AND b.vendor_id = '" . $user_id . "' ORDER BY b.serial_number DESC";

    $vehicle_book_query = $con->query($vs . ' LIMIT ' . $start_from . ',' . $limit);
    $vendor_details = $con->query("SELECT CONCAT_WS(' ', u.first_name,u.last_name) as vendor_name, u.user_email, u.mobile_number as vendor_mobile, u.address, u.city, u.state from pa_users as u where u.id = '" . $user_id . "'");
} else if ($_GET['vehicle_number']) {
    $vehicle_number = $_GET['vehicle_number'];
    $query_string = "&vehicle_number=$vehicle_number";
    $vs = "SELECT b.*, CONCAT_WS(' ', u.first_name,u.last_name) as vendor_name, u.user_email, u.mobile_number as vendor_mobile, u.address, u.city, u.state, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where b.vendor_id = '" . $user_id . "' AND b.vehicle_number LIKE '%" . $vehicle_number . "%' ORDER BY b.serial_number DESC";
    $vehicle_book_query = $con->query($vs . ' LIMIT ' . $start_from . ',' . $limit);
} else {
    if ($active_plans_row['report_export_capacity'] > 0) {
        $getstart = date('Y-m-d', strtotime('-' . $active_plans_row['report_export_capacity'] . ' months'));
        $getend = $currentdate;
    } else {
        $getstart = $currentdate;
        $getend = $currentdate;
    }
    $query_string = "&start_date=$getstart&end_date=$getend";
    $vs = "SELECT b.*, sdin.staff_name as in_staff_name, sdout.staff_name as out_staff_name, u.first_name, b.serial_number FROM `vehicle_booking` as b LEFT JOIN pa_users as u ON b.customer_id = u.id LEFT JOIN staff_details as sdin ON b.staff_in = sdin.staff_id LEFT JOIN staff_details as sdout ON b.staff_out = sdout.staff_id where FROM_UNIXTIME(`vehicle_in_date_time`, '%Y-%m-%d') = (DATE_FORMAT(NOW(),'%Y-%m-%d')) AND b.vendor_id = '" . $user_id . "' ORDER BY b.serial_number DESC";

    $vehicle_book_query = $con->query($vs . ' LIMIT ' . $start_from . ',' . $limit);
    $vendor_details = $con->query("SELECT CONCAT_WS(' ', u.first_name,u.last_name) as vendor_name, u.user_email, u.mobile_number as vendor_mobile, u.address, u.city, u.state from pa_users as u where u.id = '" . $user_id . "'");
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Parking History</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                        <li class="breadcrumb-item active">Parking History</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <?php if ($active_plans_row['report_export_capacity'] > 0) { ?>
                            <form action="" method="get" class="filterform"> 
                                <div class="form-group" style="width:500px !important;">
                                    <div>
                                        <div class="input-daterange input-group" id="vdate-range">
                                            <input type="text" class="form-control start_date" name="start_date" placeholder="Start Date" id="start_date" value="<?php echo $getstart; ?>" />
                                            <input type="text" class="form-control end_date" name="end_date" placeholder="End Date" id="end_date" value="<?php echo $getend; ?>"/>
                                            <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Submit</button>

                                            <br>
                                            <a href="export.php?action=parking_history&start_date=<?php echo $getstart; ?>&end_date=<?php echo $getend; ?>" style="margin-left:10px;" class="btn btn-success">Export CSV</a>

                                            <br>
                                            <button style="margin-left:10px;" type="button" name="submit" id="searchreceipt" value="submit" class="btn btn-danger">Export PDF</button>
<!--                                            <button style="margin-left:10px;" type="submit" name="submit" value="submit" class="btn btn-danger">Export PDF</button>-->

                                            <!--- <a href="javascript:window.print()" style="margin-left:10px;" class="btn btn-success">Export PDF</a>-->

                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }

                        while ($row1 = $vendor_details->fetch_assoc()) {
                            ?>
                            <div class="col-6 vendor_det">
                                <address>

                                    <?php echo $row1['vendor_name']; ?><br>
                                    <?php echo $row1['user_email']; ?><br>
                                    <?php echo $row1['address']; ?><br>
                                    <?php echo $row1['city'] . ', ' . $row['state']; ?><br>
                                    <?php echo $row1['vendor_mobile']; ?>
                                </address>
                            </div>
                        <?php } ?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="t1">S.No.</th>
                                    <th style="display: none;">ID</th>
                                    <th class="t1">Booking ID</th>
                                    <th class="t1">Vehicle Number</th>
                                    <th class="t1">Customer</th> 
                                    <th class="t1">In</th>
                                    <th class="t1">Out</th>
                                    <th class="t1">Duration</th>
                                    <th class="t1">Amount</th>
                                    <th class="t1">Staffs</th>
                                    <th class="t1">Book Type</th>
                                    <th class="t1">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_vendor_amount = 0;
                                if ($vehicle_book_query->num_rows > 0) {
                                    while ($row = $vehicle_book_query->fetch_assoc()) {
                                        $id = $row['id'];
                                        $vehicle_status = $row['vehicle_status'];
                                        ?>
                                        <tr class="gradeX">
                                            <td><?php echo $row['serial_number']; ?></td>
                                            <td style="display: none;"><?php echo $id; ?></td>
                                            <td><?php echo $id; ?></td>
                                            <td><?php
                                                echo $row['vehicle_number'] . '<br/> (' . $row['vehicle_type'] . ')';
                                                if ($row['staff_vehicle_type'] == 'yes') {
                                                    echo ' (Staff)';
                                                }
                                                ?></td>
                                            <td><?php echo $row['first_name'] . '<br>' . $row['mobile_number']; ?></td>

                                            <td><?php echo date('d-m-Y', $row['vehicle_in_date_time']) . ' <br/>' . date('h:i A', $row['vehicle_in_date_time']); ?></td>
                                            <td><?php echo date('d-m-Y', $row['vehicle_out_date_time']) . ' <br/>' . date('h:i A', $row['vehicle_out_date_time']); ?></td>
                                            <td><?php
                                                if ($vehicle_status == 'In') {
                                                    $currentTime = time();
                                                    $diff = abs($currentTime - $row['vehicle_in_date_time']);
                                                } else {
                                                    $diff = abs($row['vehicle_out_date_time'] - $row['vehicle_in_date_time']);
                                                }

                                                $fullDays = floor($diff / (60 * 60 * 24));
                                                $fullHours = floor(($diff - ($fullDays * 60 * 60 * 24)) / (60 * 60));
                                                $fullMinutes = floor(($diff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60)) / 60);
                                                $totalDuration = '';
                                                if ($fullDays > 0) {
                                                    $totalDuration .= $fullDays . ' Day ';
                                                }
                                                if ($fullHours > 0) {
                                                    $totalDuration .= $fullHours . ' Hrs ';
                                                }
                                                //if($fullMinutes > 0){
                                                $totalDuration .= $fullMinutes . ' Mins';
                                                //}

                                                echo $totalDuration;
                                                ?></td>
                                            <td><?php
                                                $vehicle_book_payment = $con->query("SELECT IF(SUM(amount) > 0, SUM(amount), 0) as total_amount FROM `payment_history` where booking_id = '" . $id . "'");
                                                $row_payment = $vehicle_book_payment->fetch_assoc();
                                                $total_amount = $row_payment['total_amount'];
                                                echo $total_amount;
                                                $total_vendor_amount = $total_amount + $total_vendor_amount;
                                                ?></td>
                                            <td><?php
                                                if ($row['in_staff_name']) {
                                                    echo '<strong>In : </strong>' . $row['in_staff_name'] . '<br/>';
                                                } if ($row['out_staff_name']) {
                                                    echo '<strong>Out : </strong>' . $row['out_staff_name'];
                                                }
                                                ?></td>
                                            <td><?php
                                                echo $row['parking_type'];
                                                if ($row['qr_type'] == 'monthly_pass') {
                                                    echo '<br/> (Pass)';
                                                }
                                                ?></td>
                                            <td><?php echo $row['vehicle_status']; ?></td>
                                            <td><a href="payment-history.php?id=<?php echo $row['id']; ?>" title="View Payment History"> <i class="fas fa-history"></i> </a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total Amount </td>
                                    <td><i class="fas fa-rupee-sign"></i> <?php echo $total_vendor_amount; ?></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php
                        $vehicle_tos_query = $con->query($vs);
                        $total_records = $vehicle_tos_query->num_rows;
                        $total_pages = ceil($total_records / $limit);

                        $pagLink = "<ul class='pagination abc'>";
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $pagLink .= "<li class='page-item'><a class='page-link' href='parking-history.php?page=" . $i . "$query_string'>" . $i . "</a></li>";
                        }
                        echo $pagLink . "</ul>";
						
						?>

                      
						
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

<?php
if ($active_plans_row['report_export_capacity'] > 0) {
    $calstart = date('Y-m-d', strtotime('-' . $active_plans_row['report_export_capacity'] . ' months'));
    $calend = $currentdate;
} else {
    $calstart = $currentdate;
    $calend = $currentdate;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
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
        var vendor_id = '<?php echo $user_id ;?>';
		var startDate= $('#start_date').val();
         var   endDate=$('#end_date').val();
        $.ajax({
            url: 'parking-histtory-pdf.php',
            type: 'get',
            data: {'vendor_id': vendor_id,startDate:startDate,endDate:endDate},
            success: function (response) {
                Popup(response);
            }
        });
    });

</script>
<style>


    ul.pagination {
    }

    li#datatable_previous {
        display: none;
    }

    li.paginate_button.page-item.active {
        display: none;
    }

    li#datatable_next {
        display: none;
    }

    .vendor_det{
        display:none;
    }
    .t1{
        width:10px !important;
    }
    @media print {
        .filterform,.start_date, .end_date{
            display:none;
        }
        .vendor_det{
            display:block;
        }
        .table,.nowrap,.dataTable{
            width:30% !important;
        }
        .dataTables_filter, .dataTables_length,.breadcrumb,.dataTables_info,.dataTables_paginate{
            display:none;
        }
        #datatable{
            width:60% !important;
        }
        .t1{
            width:10px !important;
        }
    }
</style>


<?php include 'footer.php' ?>