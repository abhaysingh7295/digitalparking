 <!-- MENU Start -->

            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <li class="has-submenu">
                                <a href="index.php"><i class="icon-accelerator"></i> Dashboard</a>
                            </li>

                             <?php if($active_plans_row['fare_info']==1 && (
                             (in_array("add-fare.php",$staff_access_permission))||
                             (in_array("fare-info.php",$staff_access_permission)
                             ))){ ?>
                             <li class="has-submenu">
                                <a href="#"><i class="fas fa-rupee-sign"></i> Fare Info <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <?php
                                   if((in_array("add-fare.php",$staff_access_permission)
                             )){
                             ?><li> <a href="add-fare.php"> Add New Fare </a> </li>
                             <?php } ?>
                              <?php
                                   if((in_array("fare-info.php",$staff_access_permission)
                             )){
                             ?>
                                    <li> <a href="fare-info.php"> All Fare </a> </li>
                                    <?php } ?>
                                 </ul>
                            </li>
                            <?php } ?>
                            <?php if($active_plans_row['monthly_pass']==1 && 
							((in_array("new-renewpass.php",$staff_access_permission))||
                             (in_array("add-monthly-pass.php",$staff_access_permission))||
							 (in_array("all-monthly-pass.php",$staff_access_permission))
							 )){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-address-card"></i> Monthly Pass <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                 <?php   if((in_array("new-renewpass.php",$staff_access_permission)
                             )){ ?>						 
                                    <li> <a href="new-renewpass.php">Renew Vehicle Pass </a> </li>
							 <?php } ?>
							  <?php   if((in_array("add-monthly-pass.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="add-monthly-pass.php"> Add Monthly Pass </a> </li>
                                     <?php } ?>
									  <?php   if((in_array("all-monthly-pass.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="all-monthly-pass.php"> All Monthly Pass </a> </li>
									 <?php } ?>
                                    <!-- <li> <a href="monthly-pass-import.php"> Import Monthly Pass </a> </li> -->
                                 </ul>
                            </li>
                            <?php } ?>
							 <?php if(
							(in_array("vehicle-in.php",$staff_access_permission))||
                             (in_array("vehicle-out.php",$staff_access_permission))||
							 (in_array("pre-bookings.php",$staff_access_permission))||
							 (in_array("parking-history.php",$staff_access_permission))||
							 (in_array("payment-history.php",$staff_access_permission))
							 ){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="fas fa-parking"></i> Check-IN <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
								 <?php   if((in_array("vehicle-in.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="vehicle-in.php"> Vehicle In </a> </li>
							 <?php } ?>
									 <?php   if((in_array("vehicle-out.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="vehicle-out.php"> Vehicle Out </a> </li>
							 <?php } ?>
                                    <?php if($active_plans_row['pre_booking']==1 && in_array("pre-bookings.php",$staff_access_permission)){ ?>
                                       <li> <a href="pre-bookings.php"> Pre Bookings </a> </li>
                                    <?php } ?>
									 <?php   if((in_array("parking-history.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="parking-history.php"> Parking History </a> </li>
									<?php } ?>
									 <?php   if((in_array("payment-history.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="payment-history.php"> Parking Payment Received </a> </li>
									<?php } ?>
                                 </ul>
                            </li>
							 <?php } ?>
							
                            <?php if($active_plans_row['block_vehicle']==1 && ((in_array("block-vehicles.php",$staff_access_permission))||
                             (in_array("add-block-vehicle.php",$staff_access_permission)))
							 ){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-car"></i> Block Vehicles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
									 <?php   if((in_array("block-vehicles.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="block-vehicles.php"> All Block Vehicles </a> </li>
							 <?php } ?>
									 <?php   if((in_array("add-block-vehicle.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="add-block-vehicle.php"> Add Block Vehicle </a> </li> 
							 <?php } ?>
                                 </ul>
                                </li>
                             <?php }  ?>

                             <?php if($active_plans_row['Wanted_vehicle']==1 && ((in_array("wanted-vehicles.php",$staff_access_permission))||
                             (in_array("add-wanted-vehicle.php",$staff_access_permission)))){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-car"></i> Wanted Vehicles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
									 <?php   if((in_array("wanted-vehicle.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="wanted-vehicles.php"> All Wanted Vehicles </a> </li>
							 <?php } ?>
							  <?php   if((in_array("add-wanted-vehicle.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="add-wanted-vehicle.php"> Add Wanted Vehicle </a> </li> 
							 <?php } ?>
                                 </ul>
                                </li>
                             <?php } ?>


                            <?php //if($active_plans_row['wallet']==1){ ?>
							<?php if((in_array("wallet-history.php",$staff_access_permission))||
                             (in_array("add-wallet.php",$staff_access_permission))){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-wallet"></i> My Wallet <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
									 <?php   if((in_array("wallet-history.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="wallet-history.php"> Wallet History </a> </li>
							 <?php } ?>
									 <?php   if((in_array("add-wallet.php",$staff_access_permission)
                             )){ ?>
                                    <li> <a href="add-wallet.php"> Add Wallet Amount </a> </li>
							 <?php } ?>
                                 </ul>

                                </li>
                            <?php } ?>
                            <!--<?php //if($active_plans_row['monthly_report']==1){ ?>-->
							
							<?php if((in_array("add-staff.php",$staff_access_permission))||
                             (in_array("all-staff.php",$staff_access_permission)) ||
							 (in_array("staff-wise-report.php",$staff_access_permission))||
                             (in_array("vehicle-type-wise-report.php",$staff_access_permission))){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-user"></i> All Staffs <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
								 <?php   if((in_array("add-staff.php",$staff_access_permission)
                             )){ ?>
                                    <li>
                                        <a href="add-staff.php"> Add Staff </a>
                                    </li>
							 <?php } ?>
									 <?php   if((in_array("all-staff.php",$staff_access_permission)
                             )){ ?>
                                     <li>
                                        <a href="all-staffs.php"> All Staffs </a>
                                    </li>
									 <?php } ?>
								<?php   if((in_array("staff-wise-report.php",$staff_access_permission)
                             )){ ?>
                                    <li>
                                        <a href="staff-wise-report.php"> All Staff Wise Report </a>
                                    </li>
									 <?php } ?>
                                        <?php   if((in_array("vehicle-type-wise-report.php",$staff_access_permission)
                             )){ ?> 
                                         <li>
                                    <a href="vehicle-type-wise-report.php"> Vehicle Type Wise Report </a> 
                                    
                                    </li>
									 <?php } ?>
                                 </ul>
                            </li>
 						    <?php } ?>
							<?php if((in_array("profile.php",$staff_access_permission))||
                             (in_array("my-qrcode.php",$staff_access_permission)) ||
							 (in_array("subscriptions.php",$staff_access_permission))||
                             (in_array("my-subscriptions.php",$staff_access_permission)) ||
							 (in_array("my-password-change.php",$staff_access_permission))){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-user"></i> Account <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
								  <?php   if((in_array("profile.php",$staff_access_permission)
                             )){ ?> 
                                    <li> <a href="profile_staff.php"> Profile </a> </li>
							 <?php } ?>
									  <?php   if((in_array("my-qrcode.php",$staff_access_permission)
                             )){ ?> 
                                    <li> <a href="my-qrcode.php"> My QR Code </a> </li>
							 <?php } ?>
									  <?php   if((in_array("subscriptions.php",$staff_access_permission)
                             )){ ?> 
                                   <li> <a href="subscriptions.php">Subscriptions </a> </li>
							 <?php } ?>
								     <?php   if((in_array("my-subscriptions.php",$staff_access_permission)
                             )){ ?> 
                                    <li> <a href="my-subscriptions.php"> My Subscriptions </a> </li>
							 <?php } ?>
									  <?php   if((in_array("my-password-change.php",$staff_access_permission)
                             )){ ?> 
                                    <li> <a href="my-password-change-staff.php"> Password Change </a> </li>
							 <?php } ?>
                                 </ul>
                            </li>
							 <?php } ?>
                        </ul>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->