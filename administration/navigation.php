 <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <?php if (in_array("index.php", $admin_access_permission)){ ?>
                                <li class="has-submenu">
                                    <a href="index.php"><i class="icon-accelerator"></i> Dashboard</a>
                                </li>
                            <?php } ?>

                            <?php if ((in_array("infopolice.php", $admin_access_permission)) || (in_array("all-police-stations.php", $admin_access_permission)) || (in_array("add-police-station.php", $admin_access_permission)) || (in_array("add-sensitive-vehicle.php", $admin_access_permission)) || (in_array("all-sensitive-vehicles.php", $admin_access_permission))  ){ ?>


                                <li class="has-submenu">
                                <a href="#"><i class="far fa-star"></i> Police <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <?php if (in_array("infopolice.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="infopolice.php"> Inform to Controle </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array("all-police-stations.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="all-police-stations.php"> Police Stations </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array("all-sensitive-vehicles.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="all-sensitive-vehicles.php"> Sensitive Vehicles </a>
                                        </li>
                                    <?php }  ?>

                                     
                                </ul>
                            </li>

                            <?php } ?>



                            <?php if ((in_array("all-monthly-pass.php", $admin_access_permission)) || (in_array("digital-card-pre-payment.php", $admin_access_permission)) ){ ?>

                                <li class="has-submenu">
                                    <a href="#"><i class="far fa-address-card"></i> Vehicle Pass <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                       <?php if (in_array("all-pass.php", $admin_access_permission)){ ?>
                                       <li>
                                          
                                            <a href="all-pass.php">All Passes</a>
                                        </li>
                                        <?php } ?>
                                    <?php if (in_array("all-monthly-pass.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="all-monthly-pass.php">Vehicle Pass</a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array("digital-card-pre-payment.php", $admin_access_permission)){ ?>
                                         <li>
                                            <a href="digital-card-pre-payment.php">Digital Card Pre Payment</a>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if ((in_array("all-entity.php", $admin_access_permission)) || (in_array("pre-bookings.php", $admin_access_permission)) ){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="fas fa-parking"></i> Parking</a>
                                 <ul class="submenu">
                                    <?php if (in_array("all-entity.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="all-entity.php"> Parking Entity </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array("pre-bookings.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="pre-bookings.php"> Online Bookings </a>
                                        </li>
                                    <?php } ?>
                                 </ul>
                            </li>
                            <?php } ?>

                            <?php if ((in_array("vendor-wallet-history.php", $admin_access_permission)) || (in_array("add-vendor-wallet.php", $admin_access_permission)) ){ ?>

                            <li class="has-submenu">
                                <a href="#"><i class="fas fa-wallet"></i> Wallet History <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <?php if (in_array("vendor-wallet-history.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="vendor-wallet-history.php"> All Vendors Wallet (H)</a>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array("add-vendor-wallet.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="add-vendor-wallet.php"> Add Vendor Wallet </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ((in_array("all-vendors.php", $admin_access_permission)) || (in_array("all-customers.php", $admin_access_permission)) || (in_array("all-admins.php", $admin_access_permission)) ){ ?>
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-user"></i> All Users <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <?php if (in_array("all-vendors.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="all-vendors.php"> All Vendors </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array("all-customers.php", $admin_access_permission)){ ?>
                                     <li>
                                        <a href="all-customers.php"> All Customers </a>
                                    </li>
                                    <?php } ?>

                                    <?php if (in_array("all-admins.php", $admin_access_permission)){ ?>
                                    <li>
                                        <a href="all-admins.php"> All Admins </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                            </li>
                            <?php } ?>

                            <?php if ((in_array("subscriptions-plan.php", $admin_access_permission)) || (in_array("add-subscription-plan.php", $admin_access_permission)) || (in_array("vendor-subscriptions.php", $admin_access_permission)) ){ ?>

                                <li class="has-submenu">
                                <a href="#"><i class="far fa-paper-plane"></i> Subscriptions <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <?php if (in_array("add-subscription-plan.php", $admin_access_permission)){ ?>
                                     <li>
                                        <a href="add-subscription-plan.php"> Add Subscription Plan </a>
                                    </li>
                                    <?php } ?>

                                    <?php if (in_array("subscriptions-plan.php", $admin_access_permission)){ ?>
                                        <li>
                                            <a href="subscriptions-plan.php"> All Subscription Plans </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array("vendor-subscriptions.php", $admin_access_permission)){ ?>
                                    <li>
                                        <a href="vendor-subscriptions.php"> View Vendor Subscriptions </a>
                                    </li>
                                    <?php } ?>
                                 </ul>
                            </li>
                            <?php } ?> 
                            <li class="has-submenu">
                                <a href="#"><i class="far fa-suns"></i> Account <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li> <a href="profile.php"> Profile </a> </li>
                                    <li> <a href="admin-password-change.php"> Password Change </a> </li>
                                    <?php if (in_array("all-admins.php", $admin_access_permission)){ ?>
                                        <li> <a href="settings.php"> Settings </a> </li>
                                    <?php } ?>
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