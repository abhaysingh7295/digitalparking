<?php include 'header.php' ?>

  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Songs <span style="float: right;"><a href="add-songs.php" class="btn-info btn">Add New</a></span> </header>
            <div class="panel-body">
              <div class="clearfix">
              
              <div class="adv-table table-responsive">
<div class="col-lg-2">
<select name="languagefilter" id="languagefilter">
<option value="">Filter By Language</option>
<option value="hindi">Hindi</option>
<option value="sanskrit">Sanskrit</option>
</select>
</div>
<div class="col-lg-2">
<select name="songtypes" id="songtypes">
<option value="">Filter By Song Types</option>
<option value="paid">Paid</option>
<option value="free">Free</option>
</select>


                      
          
</div>
<!--<div class="col-lg-2 songfrm">
 <select name="base_category"  class="song_base_category" id="filterbycategroy" >
 <option value="" name="">Select Category</option>
  <?php $select_base_category = $con->query("SELECT * FROM `base_category` WHERE status=1 ORDER BY id DESC");
              while($row_base_category=$select_base_category->fetch_assoc()) { ?>
               <option value="<?php echo $row_base_category['id']; ?>" name="<?php echo $row_base_category['name']; ?>"><?php echo $row_base_category['name']; ?></option>
              <?php } ?>
                      </select></div>
                      <div class="col-lg-2 songfrm">
                      <select name="sub_category[]"  class="song_sub_category"  id="filterbysubcategroy" >
           <option value="">Select Sub Category</option>
          </select></div>-->

                <table  class="display table table-bordered table-striped" id="songsexample">
                  <thead>
                    <tr>
                      <th>Name</th>
<th>Base Category</th>
<th>Sub Category</th>
<th>Language</th>
                      <th>SKU</th>
                      <th>Song Type</th>
                      <th>Song Price</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

$select_query = $con->query("SELECT * FROM `detail` ORDER BY date DESC");
while($row=$select_query->fetch_assoc())
{
?>
                    <tr class="gradeX">
                      <td><?php echo $row['name']; ?></td>
<td><?php  $select_base_category = $con->query("SELECT * FROM `base_category` where id='".$row['section']."'");

$row_base_category=$select_base_category->fetch_assoc();
echo $row_base_category['name']; ?></td>

 <td><?php 
$select_sub_category = $con->query("SELECT * FROM `sub_category` where id='".$row['sub_category']."'");

$row_sub_category=$select_sub_category->fetch_assoc();
echo $row_sub_category['name']; ?></td>
 <td><?php echo $row['language']; ?></td>
                      <td><?php echo $row['song_sku']; ?></td>
                      <td><?php echo $row['song_type']; ?></td>
                      <td><?php echo $row['song_price']; ?></td>
                     
                      <td class="center"><a href="edit-song.php?edit_id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp;
                   
                      <a href="delete-song.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                     <th>Name</th>
<th>Base Category</th>
<th>Sub Category</th>
<th>Language</th>
                      <th>SKU</th>
                      <th>Song Type</th>
                      <th>Song Price</th>
                      <th class="">Action</th>
                    </tr>
                  </tfoot>
                </table>


<style> #example22 th, #example22 td, #songsexample th, #songsexample td { width:400px !important; }</style>
<div id="getsongsresuts">
</div>




              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end--> 
    </section>
  </section>
  
  <!--main content end-->
  <?php include 'footer.php' ?>