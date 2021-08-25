<?php include 'header.php' ?>
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading"> All Sub Categories <span style="float: right;"><a class="btn-info btn" href="add-sub-category.php">Add New</a></span></header>
            <div class="panel-body">
              <div class="clearfix">
                 
              <div class="adv-table">
              <div class="table-responsive">
                <table  class="display table table-bordered table-striped" id="example">
                  <thead>
                    <tr>
<th>ID</th>
                      <th>Name</th>
			 <th>Base Category</th>
			<th>Hindi SKU</th>
			<th>Hindi Price</th>
			<th>Sanskrit SKU</th>
			<th>Sanskrit Price</th>
                     	<th>Status</th>
                     
                      <th class="">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

$select_query = $con->query("SELECT * FROM `sub_category` ORDER BY id DESC");
while($row=$select_query->fetch_assoc())
{
?>
            <tr class="gradeX">
		<td><?php echo $row['id']; ?></td>
                 <td><?php echo $row['name']; ?></td>
 		<td><?php  $select_base_category = $con->query("SELECT * FROM `base_category` where id='".$row['base_category_id']."'");
		$row_base_category=$select_base_category->fetch_assoc();
		echo $row_base_category['name']; ?></td>
		 <td><?php echo $row['hindi_sku']; ?></td>
		 <td><?php echo $row['hindi_price']; ?></td>
		 <td><?php echo $row['sanskrit_sku']; ?></td>
		 <td><?php echo $row['sanskrit_price']; ?></td>
                      <td><?php if($row['status']==1) { echo "Enable";} else { echo "Disable"; } ?></td>
                   
                      <td class="center"><a href="edit-subcategory.php?edit_id=<?php echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp; 
                   
                      <a href="delete-subcategory.php?delete=<?php echo $row['id'];?>" onClick="return confirm('Are You Sure')"><i class="icon-remove"></i></a>
                   
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr><th>ID</th>
                          <th>Name</th>
			 <th>Base Category</th>
			<th>Hindi SKU</th>
			<th>Hindi Price</th>
			<th>Sanskrit SKU</th>
			<th>Sanskrit Price</th>
                      <th>Status</th>
                     
                      <th class="">Action</th>
                    </tr>
                  </tfoot>
                </table>
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