<?php include('header.php');

function getYesNoval($val){

    $arrayYesno = array('0' => 'No', '1' => 'Yes');
    /*if($val==1){
        $returnval = 'Yes';
    } else {
        $returnval = 'No';
    }*/
    return $arrayYesno[$val];
}


if(isset($_POST['submit']))
{
    $_SESSION['add_wallet'] = '';
    $_SESSION['subscription_plan'] = $_POST;
    header('location:choose-payment-method.php'); exit();
}

 ?>
<div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Subscriptions</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">Subscriptions</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                        <h5>Choose your Plan</h5>
                       
                    </div>
                </div>
            </div>

            
            <?php if(isset($error)) {
                    echo '<p style="color:red">'.$error.'</p>';
                    } ?>
            <div class="row m-t-30">
                <?php  $subscriptions_plans = $con->query("select * from `subscriptions_plans` where status = 1");
                    while($plans_row=$subscriptions_plans->fetch_assoc())
                    { 
                        extract($plans_row);
                        $plan_id = $id;
                    ?>

                    <div class="col-xl-3 col-md-6">
                        <div class="card pricing-box mt-4">
                            <div class="pricing-icon">
                                <i class="ti-shield bg-<?php echo $bgcolor; ?>"></i>
                            </div>
                            <div class="pricing-content">
                                <div class="text-center">
                                    <h5 class="text-uppercase mt-5"><?php echo $plan_name; ?></h5>
                                    <div class="pricing-plan mt-4 pt-2">
                                        <h1><sup><i class="fas fa-rupee-sign"></i> </sup><?php echo $plan_amount; ?> <small class="font-16">/ Monthly</small></h1>
                                    </div>
                                    <div class="pricing-border mt-5"></div>
                                </div>
                                <div class="pricing-features mt-4">
                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> <?php echo $duration; ?> Months </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> <?php echo $staff_capacity; ?> Staff Login  </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Self Parking : <?php echo getYesNoval($self_parking); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Data Store : <?php echo $report_export_capacity.' Months'; ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Monthly Pass : <?php echo getYesNoval($monthly_pass); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Pre Booking : <?php echo getYesNoval($pre_booking); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> SMS Notification : <?php echo getYesNoval($sms_notification); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Auto Email : <?php echo getYesNoval($auto_email); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Daily Reports : <?php echo getYesNoval($daily_report); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Monthly Reports : <?php echo getYesNoval($monthly_report); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Wanted Notification : <?php echo getYesNoval($wanted_notification); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Block Vehicle : <?php echo getYesNoval($block_vehicle); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Wallet : <?php echo getYesNoval($wallet); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Vendor Logo : <?php echo getYesNoval($vendor_logo); ?> </p>

                                    <p class="font-14 mb-2"><i class="ti-check-box text-<?php echo $bgcolor; ?> mr-3"></i> Fare Info : <?php echo getYesNoval($fare_info); ?> </p>

                                </div>
                                <div class="pricing-border mt-4"></div>
                                <div class="mt-4 pt-3 text-center">
                                    <?php if($active_plan_id!=$plan_id){ 
                                        $totalAmount = $plan_amount * $duration; ?>
                                  <form action="" method="post">
                                        <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
                                        <input type="hidden" name="vendor_id" value="<?php echo $current_user_id; ?>">
                                        <input type="hidden" name="subscription_amount" value="<?php echo $totalAmount; ?>">
                                        <button type="submit" name="submit" class="btn btn-<?php echo $bgcolor; ?> btn-lg w-100 btn-round">
                                            <?php if($active_plan_id){ echo 'Upgrade Now'; } else { echo 'Subscribe Now'; } ?>
                                        </button>
                                    </form>
                                <?php } else { ?>
                                     <button type="button" class="btn btn-<?php echo $bgcolor; ?> btn-lg w-100 btn-round">
                                            <?php echo 'Current Plan'; ?>
                                        </button>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                     <?php  } ?>
                     
                </div>

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
<?php include('footer.php'); ?>