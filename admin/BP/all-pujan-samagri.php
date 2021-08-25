<?php include 'header.php'; ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Pujan Samagri <span style="float: right;"><a href="add-pujan-samagri.php" class="btn-info btn">Add New</a></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table table-responsive">
                <table  class="display table table-bordered table-striped" id="example">
                  <thead>
                    <tr>
                    <th>Images</th>
                      <th>Hindi Name</th>
                      <th>English Name</th>
                      <th>Category</th>
                      <th>Quantity</th>
                       <th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$select_query  = $con->query("SET NAMES utf8");
$select_query = $con->query("SELECT * FROM `pujan_samagri` ORDER BY id DESC");
while($row=$select_query->fetch_assoc())
{
if($row['image']==''){
$rowimg = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';	
} else {
$rowimg = '../pujan_samagri_image/'.$row['image'];
}
?>
                    <tr class="gradeX">
                    <td><a href="#" class="" data-toggle="modal" data-target="#lightbox"><img title="<?php echo $row['english_name']; ?>" src="<?php echo $rowimg; ?>" height="70" width="80"/></td>
                      <td><?php echo $row['hindi_name']; ?></td>
                      <td><?php echo $row['english_name']; ?></td>
                      <td><?php  //echo "SELECT * FROM `sub_category` where id='".$row['sub_category_id']."'"; 
$select_sub_category = $con->query("SELECT * FROM `sub_category` where id='".$row['sub_category_id']."'");

$row_sub_category=$select_sub_category->fetch_assoc();
echo $row_sub_category['name']; ?>
                      
                      
                      </td>
                       <td><?php echo $row['quantity']; ?></td>
                       <td><?php if($row['status']==1) { echo "Enable";} else { echo "Disable";} ?></td>
                     
                      <td class="center"><a href="edit-pujan-samagri.php?edit_id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp; 
                   
                      <a href="delete-pujan-samagri.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                    <th>Images</th>
                      <th>Hindi Name</th>
                      <th>English Name</th>
                      <th>Category</th>
                      <th>Quantity</th>
                       <th>Status</th>
                      <th class="">Action</th>
                    </tr>
                  </tfoot>
                </table>
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