<?php include 'header.php';
$id = $_GET['id'];
$user_id = $_SESSION["current_user_ID"];

$my_subscription = $con->query("select vs.*, vs.id as vsid, sp.plan_name, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state from `vendor_subscriptions` as vs JOIN subscriptions_plans AS sp on vs.subscription_plan_id = sp.id JOIN pa_users as v ON vs.vendor_id = v.id WHERE vs.id=".$id." AND vs.vendor_id = ".$user_id." ORDER BY vs.id DESC");

$row = $my_subscription->fetch_assoc();

$subscription_amount = $row['subscription_amount'];
$GSTAmount = $subscription_amount * 18 / 100;
$SubtotalAmount = $subscription_amount - $GSTAmount;
 ?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Invoice</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-16"><strong>Order #<?php echo $id; ?></strong></h4>
                                        <h3 class="m-t-0">
                                        	<?php if($site_settings_row['dashboard_logo']==''){
													echo $site_settings_row['site_name'];    
													} else {
														echo '<img style="width: 100px;" alt="'.$site_settings_row['site_name'].'" title="'.$site_settings_row['site_name'].'" src="'.ADMIN_URL.$site_settings_row['dashboard_logo'].'" />';
													} ?>
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                <strong>Billed To:</strong><br>
                                                <?php echo $row['vendor_name']; ?><br>
                                                <?php echo $row['user_email']; ?><br>
                                                <?php echo $row['address']; ?><br>
                                                <?php echo $row['city'].', '.$row['state']; ?><br>
                                                <?php echo $row['vendor_mobile']; ?>
                                            </address>
                                        </div>
                                        <div class="col-6 text-right">
                                            <address>
                                                <strong>Billing From:</strong><br>
                                                The Digital Parking<br>
                                                <!-- 1234 Main<br>
                                                Apt. 4B<br>
                                                Springfield, ST 54321 -->
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 m-t-30">
                                            <address>
                                                <strong>Payment Method:</strong><br>
                                                <?php echo $row['payment_type']; ?>
                                            </address>
                                        </div>
                                        <div class="col-6 m-t-30 text-right">
                                            <address>
                                                <strong>Order Date:</strong><br>
                                                <?php echo date('d-m-Y', $row['date_time']); ?><br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="panel panel-default">
                                        <div class="p-2">
                                            <h3 class="panel-title font-20"><strong>Order summary</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>Plan</strong></td>
                                                        
                                                        <td class="text-right"><strong>Price</strong></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><?php echo $row['plan_name']; ?> <br/>
                                                        	<strong>Start Date :</strong> <?php echo date('d-m-Y',$row['subscription_start_date']); ?><br/>
                                                        	<strong>End Date :</strong> <?php echo date('d-m-Y',$row['subscription_end_date']); ?>
                                                        </td>
                                                        
                                                        <td class="text-right"><i class="fas fa-rupee-sign"></i><?php echo number_format($SubtotalAmount,2); ?></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        
                                                        <td class="thick-line text-right">
                                                            <strong>Subtotal</strong></td>
                                                        <td class="thick-line text-right"><i class="fas fa-rupee-sign"></i><?php echo number_format($SubtotalAmount,2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td class="no-line text-right">
                                                            <strong>GST (18%)</strong></td>
                                                        <td class="no-line text-right"><i class="fas fa-rupee-sign"></i><?php echo number_format($GSTAmount,2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td class="no-line text-right">
                                                            <strong>Total</strong></td>
                                                        <td class="no-line text-right"><h4 class="m-0"><i class="fas fa-rupee-sign"></i><?php echo number_format($subscription_amount,2); ?></h4></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none mo-mt-2">
                                                <div class="float-right">
                                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                    <!-- <a href="#" class="btn btn-primary waves-effect waves-light">Send</a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->  

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->

<?php include 'footer.php' ?>