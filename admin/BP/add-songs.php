<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Add Song </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form songfrm" id="signupForm" method="post" action="save-songs.php" enctype="multipart/form-data">
               
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Name</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="name" name="name" type="text" required="required"/>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Image</label>
                    <div class="col-lg-10">
                      <select class="form-control" id="image" name="image">
			<?php $select_song_image = $con->query("SELECT * FROM `songs_images` where status=1 ORDER BY date DESC");
			while($row_song_image=$select_song_image->fetch_assoc())
			{
			echo '<option value="'.$row_song_image['slug'].'">'.$row_song_image['name'].'</option>';
			} ?>
		    </select>
                    </div>
                  </div>
                  
 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Audio Type</label>
                    <div class="col-lg-10">
 			<lable class="col-lg-2">
                      <input type="radio" value="both" name="audio_type" id="audio_type" class="select_audio_type" required> Both
                      </lable>
                    <lable class="col-lg-2">
                      <input type="radio"value="acc" name="audio_type" id="audio_type" class="select_audio_type" required> AAC
                      </lable>
                      <lable class="col-lg-2">
                      <input type="radio" value="mp3" name="audio_type" id="audio_type" class="select_audio_type" required> MP3
                      </lable>
                    </div>
                  </div>

                  <div class="form-group facc-file" style="display:none;">
                    <label for="title" class="control-label col-lg-2">AAC File</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="audio_file" name="audio_file" type="file" />
                    </div>
                  </div>
                  
                  <div class="form-group fmp3-file" style="display:none;">
                    <label for="title" class="control-label col-lg-2">Mp3 Android File</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="mp3_audio_file" name="mp3_audio_file" type="file" />
                    </div>
                  </div>
                  

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Language</label>
                    <div class="col-lg-10">
                     <select class="form-control" name="language" required="required">
                      <option value="">Select Language</option>
			<option value="hindi">Hindi</option>
			<option value="sanskrit">Sanskrit</option>
                      </select>
                    </div>
                  </div>

		 <fieldset class="songfrmle">
		  <legend>Section 1:</legend>
 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Base Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="base_category[]"  class="form-control song_base_category" required="required">
                      <option value="">Select Category</option>
                       <?php
                       $select_base_category = $con->query("SELECT * FROM `base_category` WHERE status=1 ORDER BY id DESC");
                       while($row_base_category=$select_base_category->fetch_assoc())
                       { ?>
                        <option value="<?php echo $row_base_category['id']; ?>"><?php echo $row_base_category['name']; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>

 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Sub Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="sub_category[]"  class="form-control song_sub_category" >
                      <option>Select Category</option>
                       
                      </select>
                    </div>
                  </div>

 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song SKU</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="song_sku" name="song_sku[]" type="text" />
                    </div>
                  </div>

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Type</label>
                    <div class="col-lg-10">
                     <select class="form-control" name="song_types[]" required="required">
                      <option value="">Select Song Type</option>
			<option value="free">Free</option>
			<option value="paid">Paid</option>
                      </select>
                    </div>
                  </div>
                   
                   <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Price</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="song_price" name="songe_price[]" type="number" value="0.00" />
                    </div>
                  </div>

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Order No.</label>
                    <div class="col-lg-10">
                    <select name="orderid[]" class="form-control">
		         <?php
		         for($c=1;$c<=10;$c++){
		         echo '<option value="'.$c.'">'.$c.'</option>';
		         }
		          ?>
		</select>
                    </div>
                  </div>

</fieldset>
<div id="appenddivs"></div>
	 <br/><br/>
<div id="addloaddiv"></div>
<a href="javascript:void(0)" id="addnewfrm" class="btn btn-success" style="float:right"> Add More </a>
                  
                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button class="btn btn-danger" type="submit" name="submit" style="height: 50px; width: 20%;">Submit</button>
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