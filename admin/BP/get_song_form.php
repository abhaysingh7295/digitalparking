<?php include('config.php'); 
$newform = $_POST['newform']+1;
?>
 <fieldset class="songfrmle" id="songfrmle-<?php echo $newform; ?>"> 
		  <legend>Section <?php echo $newform; ?>: <a class="removesection" id="<?php echo $newform; ?>" href="javascript:void(0)">X</a></legend>
 		<div class="form-group ">
                    <label for="title" class="control-label col-lg-2">Base Caegory</label>
                    <div class="col-lg-10">
                     
                      <select name="base_category[]"  class="form-control" id="song_base_category_<?php echo $newform; ?>" required="required">
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
                     
                      <select name="sub_category[]"  class="form-control" id="song_sub_category_<?php echo $newform; ?>">
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
<!--<script src="js/jquery.js"></script>-->
<script>
jQuery(document).ready(function(){
	jQuery('.songfrm #song_base_category_<?php echo $newform; ?>').on('change', function() {
	 var bas_cat_val = jQuery(this).val();
	jQuery('.songfrm #song_sub_category_<?php echo $newform; ?>').html('<option>loading...</option>');
	jQuery.ajax({
		url:'get_sub_cats.php',
		type:'POST',
		data:{sbcatval:bas_cat_val},
		success:function(data){
		jQuery('.songfrm #song_sub_category_<?php echo $newform; ?>').html(data);
		
		}
	
	});

	});
jQuery('.removesection').click(function(e){
	var get_id = jQuery(this).attr('id');
	
	jQuery('#songfrmle-'+get_id).remove();
	
});
});
</script>

</fieldset>

