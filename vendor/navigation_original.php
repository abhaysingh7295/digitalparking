 <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <li class="has-submenu">
                                <a href="index.php"><i class="icon-accelerator"></i> Dashboard</a>
                            </li>

                             <?php if($active_plans_row['fare_info']==1 ){ ?>
                             <li class="has-submenu">
                                <a href="#"><i class="fas fa-rupee-sign"></i> Fare Info <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                   <li> <a href="add-fare.php"> Add New Fare </a> </li>
                            
                                    <li> <a href="fare-info.php"> All Fare </a> </li>
                                  
                                 </ul>
                            </li>
                            <?php } ?>
                            <!--<li class="has-submenu">
                                <a href="#"><i class="fas fa-rupee-sign"></i> Offers <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li> <a href="add-offers.php"> Add New Offers </a> </li>
                            
                                    <li> <a href="offers-info.php"> All Offers </a> </li>
                                  
                                 </ul>
                            </li>-->
                            <?php if($active_plans_row['monthly_pass']==1){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-address-card"></i> Monthly Pass <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    
                                    <li> <a href="new-renewpass.php">Renew Vehicle Pass </a> </li>
                                    
                                    <li> <a href="add-monthly-pass.php"> Add Monthly Pass </a> </li>
                                    
                                    <li> <a href="all-monthly-pass.php"> All Monthly Pass </a> </li>
                                    <!-- <li> <a href="monthly-pass-import.php"> Import Monthly Pass </a> </li> -->
                                 </ul>
                            </li>
                            <?php } ?>

                            <li class="has-submenu">
                                <a href="#"><i class="fas fa-parking"></i> Check-IN <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li> <a href="vehicle-in.php"> Vehicle In </a> </li>
                                    <li> <a href="vehicle-out.php"> Vehicle Out </a> </li>
                                    <?php if($active_plans_row['pre_booking']==1){ ?>
                                       <li> <a href="pre-bookings.php"> Pre Bookings </a> </li>
                                    <?php } ?>
                                    <li> <a href="parking-history.php"> Parking History </a> </li>
                                    <li> <a href="payment-history.php"> Parking Payment Received </a> </li>
                                 </ul>
                            </li>

                            <?php if($active_plans_row['block_vehicle']==1){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-car"></i> Block Vehicles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                    <li> <a href="block-vehicles.php"> All Block Vehicles </a> </li>
                                    <li> <a href="add-block-vehicle.php"> Add Block Vehicle </a> </li> 
                                 </ul>
                                </li>
                             <?php } ?>

                             <?php if($active_plans_row['Wanted_vehicle']==1){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-car"></i> Wanted Vehicles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                    <li> <a href="wanted-vehicles.php"> All Wanted Vehicles </a> </li>
                                    <li> <a href="add-wanted-vehicle.php"> Add Wanted Vehicle </a> </li> 
                                 </ul>
                                </li>
                             <?php } ?>


                            <?php //if($active_plans_row['wallet']==1){ ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-wallet"></i> My Wallet <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                    <li> <a href="wallet-history.php"> Wallet History </a> </li>
                                    <li> <a href="add-wallet.php"> Add Wallet Amount </a> </li>
									<li> <a href="add-offers.php"> Add New Offers </a> </li>
                            
                                    <li> <a href="offers-info.php"> All Offers </a> </li>
                                 </ul>

                                </li>
                            <?php //} ?>
                            <!--<?php //if($active_plans_row['monthly_report']==1){ ?>-->

                            <li class="has-submenu">
                                <a href="#"><i class="far fa-user"></i> All Staffs <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li>
                                        <a href="add-staff.php"> Add Staff </a>
                                    </li>
                                     <li>
                                        <a href="all-staffs.php"> All Staffs </a>
                                    </li>

                                    <li>
                                        <a href="staff-wise-report.php"> All Staff Wise Report </a>
                                    </li>
                                        
                                         <li>
                                    <a href="vehicle-type-wise-report.php"> Vehicle Type Wise Report </a> 
                                    
                                    </li>
                                 </ul>
                            </li>
 						    <!--<?php// } ?>-->

                            <li class="has-submenu">
                                <a href="#"><i class="far fa-user"></i> Account <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li> <a href="profile.php"> Profile </a> </li>
                                    <li> <a href="my-qrcode.php"> My QR Code </a> </li>
                                   <li> <a href="subscriptions.php">Subscriptions </a> </li>
                                    <li> <a href="my-subscriptions.php"> My Subscriptions </a> </li>
                                    <li> <a href="my-password-change.php"> Password Change </a> </li>
                                 </ul>
                            </li>

                        </ul>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->