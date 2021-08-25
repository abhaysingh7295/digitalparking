<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Send IOS Notification </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="send-notifications-ios.php" enctype="multipart/form-data">
<input type="hidden" name="os" id="opratingsystems" value="ios">
<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Select Users Alfa</label>
                    <div class="col-lg-10" id="selectuseralpha">
			<?php  foreach (range('A', 'Z') as $column){
			echo '<div class="col-lg-2 col-xs-2" style="padding:1px">';
			         echo '<a class="btn btn-success" href="#" id="'.$column .'">'.$column .'</a>';
			       
			     echo '</div>';
			   } ?>
 
                    
                    </div>
                  </div>

 <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Select Users</label>
<div id='loaddiv'></div>
                    <div class="col-lg-10" id="userselect" style="height:250px; background:#ececec; overflow-y: scroll; padding: 20px;">
 No User Selected
 
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-2">Message</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="message" rows="6"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit">Send</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </section>
  <!--main content end-->
  <?php include 'footer.php' ?>