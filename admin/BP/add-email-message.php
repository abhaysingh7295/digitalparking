<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Add Message </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="save-email-message.php" enctype="multipart/form-data">
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Subject</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="subject" name="subject" type="text" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-2">Message</label>
                    <div class="col-sm-10">
                      <textarea class="form-control ckeditor" name="message" rows="6"></textarea>
                    </div>
                  </div>
                  
                   <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Status</label>
                    <div class="col-lg-10">
                    <lable class="col-lg-2">
                      <input class="" id="status" name="status" type="radio" value="1" /> Enable
                      </lable>
                      <lable class="col-lg-2">
                      <input class="" id="status" name="status" type="radio" value="0" /> Disable
                      </lable>
                    </div>
                  </div>
                 
                   
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit">Submit</button>
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