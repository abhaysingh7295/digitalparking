<?php include 'header.php'; ?>
 
<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--state overview start-->
              <div class="row state-overview">
                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                          
                              <h1 class="count">
                                <?php 
                 $select_all_user = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor'"); 
                echo $select_all_user->num_rows;
                ?>
                                </h1>
                              <p><a href="all-users.php" class="dashboard-links">Total Vendors</a></p>
                          </div>
                      </section>
                  </div>

                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                          
                              <h1 class="count">
                                <?php 
                 $select_all_customer = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'customer'"); 
                echo $select_all_customer->num_rows;
                ?>
                                </h1>
                              <p><a href="all-customers.php" class="dashboard-links">Total Customers</a></p>
                          </div>
                      </section>
                  </div>
                 
              </div>
              <!--state overview end-->
          </section>
      </section>
      <!--main content end-->
      <?php include 'footer.php' ?>