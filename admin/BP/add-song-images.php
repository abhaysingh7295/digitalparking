<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Add Image </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="save-song-image.php" enctype="multipart/form-data">
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Image Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="image_name" name="image_name" type="text" required />
                    </div>
                  </div>
                  
                   
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Image Slug</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="image_slug" name="image_slug" type="text" required />
                    </div>
                  </div>
                  
                  
               
                  <div class="form-group last">
                    <label class="control-label col-md-3">Image Upload</label>
                    <div class="col-md-9">
                      <div data-provides="fileupload" class="fileupload fileupload-new">
                        <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail"> <img alt="" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"> </div>
                        <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                        <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                          <input type="file" class="default" name="file">
                          </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                      </div>
                      <span class="label label-danger">NOTE!</span> <span> Only upload Image 600 X 600 </span> </div>
                  </div>
                 
                
                   <div class="form-group ">
                    <label for="status" class="control-label col-lg-2">Status</label>
                    <div class="col-lg-10">
                    <lable class="col-lg-2">
                      <input class="" id="status" name="status" type="radio" value="1" checked /> Enable
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