<?php include 'header.php';
$select_query = $con->query("SELECT * FROM `detail` where id = '".$_REQUEST['edit_id']."' ");
$row=$select_query->fetch_assoc();

 ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> Edit Song </header>
            <div class="panel-body">
              <div class="form">
                <form class="cmxform form-horizontal tasi-form songfrm" id="signupForm" method="post" action="update-song.php" enctype="multipart/form-data">
               
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Name</label>
                    <div class="col-lg-10">
			<input class="form-control" id="id" name="id" type="hidden" value="<?php echo $row['id']; ?>" />
                      <input class="form-control" id="name" name="name" type="text" value="<?php echo $row['name']; ?>" />
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Image</label>
                    <div class="col-lg-10">
                      <select class="form-control" id="image" name="image">
			<?php $select_song_image = $con->query("SELECT * FROM `songs_images` where status=1 ORDER BY date DESC");
      while($row_song_image=$select_song_image->fetch_assoc())
      {
        if($row['image']==$row_song_image['slug']) { $selected = 'selected'; } else { $selected = ''; }
      echo '<option '.$selected.' value="'.$row_song_image['slug'].'">'.$row_song_image['name'].'</option>';
      } ?>
        </select>
                    </div>
                  </div>
                  
 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Audio Type</label>
                    <div class="col-lg-10">
 			<lable class="col-lg-2">
                      <input type="radio" value="both" name="audio_type" id="audio_type" class="select_audio_type" <?php if(!empty($row['url']) && !empty($row['mp3_url'])) { echo "checked"; } ?>> Both
                      </lable>
                    <lable class="col-lg-2">
                      <input type="radio"value="acc" name="audio_type" id="audio_type" class="select_audio_type" <?php if(!empty($row['url']) && empty($row['mp3_url'])) { echo "checked"; } ?>> AAC
                      </lable>
                      <lable class="col-lg-2">
                      <input type="radio" value="mp3" name="audio_type" id="audio_type" class="select_audio_type" <?php if(!empty($row['mp3_url']) && empty($row['url'])) { echo "checked"; } ?>> MP3
                      </lable>
                    </div>
                  </div>

                  <div class="form-group facc-file" <?php if($row['url']!='') { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; } ?> >
                    <label for="title" class="control-label col-lg-2">AAC File</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="audio_file" name="audio_file" type="file" />
<?php if($row['url']!='') { echo '<a target="_blank" href="../'.$row['url'].'">Play</a>'; } ?>
                    </div>
                  </div>
                  
                  <div class="form-group fmp3-file" <?php if($row['mp3_url']!='') { echo 'style="display:block;"'; } else { echo 'style="display:none;"'; } ?>>
                    <label for="title" class="control-label col-lg-2">Mp3 Android File</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="mp3_audio_file" name="mp3_audio_file" type="file" />
		<?php if($row['mp3_url']!='') { echo '<a target="_blank" href="../'.$row['mp3_url'].'">Play</a>'; } ?>
                    </div>
                  </div>
                  

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Language</label>
                    <div class="col-lg-10">
                     <select class="form-control" name="language">
                      <option value="">Select Language</option>
			<option <?php if($row['language']=='hindi') { echo 'selected'; } ?> value="hindi">Hindi</option>
			<option <?php if($row['language']=='sanskrit') { echo 'selected'; } ?> value="sanskrit">Sanskrit</option>
                      </select>
                    </div>
                  </div>

		 <fieldset class="">
		  <legend>Section Deatils:</legend>
 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Base Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="base_category"  class="form-control song_base_category" required="required">
                      <option>Select Category</option>
                       <?php
                       $select_base_category = $con->query("SELECT * FROM `base_category` WHERE status=1 ORDER BY id DESC");
                       while($row_base_category=$select_base_category->fetch_assoc())
                       { ?>
                        <option <?php if($row['section']==$row_base_category['id']) { echo 'selected'; } ?> value="<?php echo $row_base_category['id']; ?>"><?php echo $row_base_category['name']; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>

 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Sub Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="sub_category"  class="form-control song_sub_category" required="required">
                      <option>Select Category</option>
                       <?php
                    $select_sub_category = $con->query("SELECT * FROM `sub_category` WHERE base_category_id='".$row['section']."' AND status=1 ORDER BY id DESC");
                       while($row_sub_category=$select_sub_category->fetch_assoc())
                       { ?>
                        <option <?php if($row['sub_category']==$row_sub_category['id']) { echo 'selected'; } ?>  value="<?php echo $row_sub_category['id']; ?>"><?php echo $row_sub_category['name']; ?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>

 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song SKU</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="song_sku" name="song_sku" type="text" value="<?php echo $row['song_sku']; ?>" />
                    </div>
                  </div>

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Type</label>
                    <div class="col-lg-10">
                     <select class="form-control" name="song_types">
                      <option value="">Select Song Type</option>
			<option <?php if($row['song_type']=='free') { echo 'selected'; } ?> value="free">Free</option>
			<option <?php if($row['song_type']=='paid') { echo 'selected'; } ?> value="paid">Paid</option>
                      </select>
                    </div>
                  </div>
                   
                   <div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Price</label>
                    <div class="col-lg-10">
                      <input class="form-control" id="song_price" name="songe_price" type="number" value="<?php echo $row['song_price']; ?>"/>
                    </div>
                  </div>

		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Song Order No.</label>
                    <div class="col-lg-10">
                    <select name="orderid" class="form-control">
		         <?php
		         for($c=1;$c<=10;$c++){
			if($row['orderid']==$c){
			$selectc = "selected";
			} else {
			$selectc = "";
			}

		         echo '<option '.$selectc.' value="'.$c.'">'.$c.'</option>';
		         }
		          ?>
		</select>
                    </div>
                  </div>

</fieldset>

	         <br/>         
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