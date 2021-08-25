<?php include 'header.php';
$select_query = $con->query("SET NAMES utf8");

$select_query = $con->query("select * from `pujan_samagri` where id = '".$_REQUEST['edit_id']."'");
$row=$select_query->fetch_assoc();
if($row['image']==''){
$rowimg = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';	
} else {
$rowimg = '../pujan_samagri_image/'.$row['image'];
}
 ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Edit Pujan Samagri </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form" id="signupForm" method="post" action="update-pujan-samagri.php" enctype="multipart/form-data">
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Hindi Name</label>
                    <div class="col-lg-10">
                     <input class="form-control" id="id" name="id" type="hidden" value="<?php echo $row['id']; ?>" />
                      <input class="form-control" id="hindi_name" name="hindi_name" type="text" value="<?php echo $row['hindi_name']; ?>" />
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-2">Hindi Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control ckeditor" name="hindi_description" rows="6"><?php echo $row['hindi_description']; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">English Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="english_name" name="english_name" type="text" value="<?php echo $row['english_name']; ?>" />
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-2">English Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control ckeditor" name="english_description" rows="6"><?php echo $row['english_description']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Sub Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="sub_category"  class="form-control" required="required">
                      <option>Select Category</option>
                       <?php
                       $select_sub_category = $con->query("SELECT * FROM `sub_category` WHERE status=1 ORDER BY id DESC");
                       while($row_sub_category=$select_sub_category->fetch_assoc())
                       { ?>
                        <option <?php if($row_sub_category['id']==$row['sub_category_id']) { echo "selected"; }?> value="<?php echo $row_sub_category['id']; ?>"><?php echo $row_sub_category['name']; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group last">
                    <label class="control-label col-md-3">Image Upload</label>
                    <div class="col-md-9">
                      <div data-provides="fileupload" class="fileupload fileupload-new">
                        <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail"> <img alt="" src="<?php echo $rowimg; ?>"> </div>
                        <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                        <div> <span class="btn btn-white btn-file"> <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span> <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                          <input type="file" class="default" name="file">
                          </span> <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#"><i class="icon-trash"></i> Remove</a> </div>
                      </div>
                      <span class="label label-danger">NOTE!</span> <span> Attached image thumbnail is
                      supported in Latest Firefox, Chrome, Opera,
                      Safari and Internet Explorer 10 only </span> </div>
                  </div>
                 
                 <div class="form-group ">
                    <label for="quantity" class="control-label col-lg-2">Quantity</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="quantity" name="quantity" type="text" value="<?php echo $row['quantity']; ?>" />
                    </div>
                  </div>
                   
                   <div class="form-group ">
                    <label for="status" class="control-label col-lg-2">Status</label>
                    <div class="col-lg-10">
                    <lable class="col-lg-2">
                      <input class="" id="status" name="status" type="radio" value="1" <?php if($row['status']==1) { echo "checked"; } ?>  /> Enable
                      </lable>
                      <lable class="col-lg-2">
                      <input class="" id="status" name="status" type="radio" value="0" <?php if($row['status']==0) { echo "checked"; } ?> /> Disable
                      </lable>
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="update">Update</button>
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