<?php include 'header.php' ?>

  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Songs Images <span style="float: right;"><a href="add-song-images.php" class="btn-info btn">Add New</a></span> </header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table table-responsive">

                <table  class="display table table-bordered table-striped" id="songsexample">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Image Name</th>
                      <th>Image Slug</th>
                        <th>Date</th>
<th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

$select_query = $con->query("SELECT * FROM `songs_images` ORDER BY date DESC");
while($row=$select_query->fetch_assoc())
{

if($row['image']==''){
$rowimg = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';	
} else {
$rowimg = '../'.$row['image'];
}


?>
                    <tr class="gradeX">
                      <td><a href="#" class="" data-toggle="modal" data-target="#lightbox"><img title="<?php echo $row['name']; ?>" src="<?php echo $rowimg; ?>" height="70" width="80"/> </a>
</td>
                       <td><?php echo $row['name']; ?></td>
 			<td><?php echo $row['slug']; ?></td>
                      <td><?php echo $row['date']; ?></td>
 <td><?php if($row['status']==1) { echo "Enable";} else { echo "Disable"; } ?></td>
                                         
                      <td class="center"><a href="edit-song-image.php?edit_id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp;
                   
                      <a href="delete-song-image.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                    <th>Image</th>
                      <th>Image Name</th>
                      <th>Image Slug</th>
                        <th>Date</th>
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