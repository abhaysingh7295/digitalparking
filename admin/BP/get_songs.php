<?php

include('config.php');

$language = $_REQUEST['id'];

/*$select_query = $con->query("SELECT * FROM `detail` where language ='$language' ORDER BY date DESC");
while($row=$select_query->fetch_assoc())
{

$arrapss['name'] = $row['name'];


$select_base_category = $con->query("SELECT * FROM `base_category` where id='".$row['section']."'");

$row_base_category=$select_base_category->fetch_assoc();

$arrapss['cat_name'] = $row_base_category['name'];
$arrapss['language'] = $row['language'];
$arrapss['song_sku'] = $row['song_sku'];
$arrapss['song_type'] = $row['song_type'];
$arrapss['song_price'] = $row['song_price'];
$arraysend[] = $arrapss;
}

echo json_encode($arraysend);
*/

?>
<table  class="display table table-bordered table-striped" id="example222">
                  <thead>
                    <tr>
                      <th>Name</th>
<th>Base Category</th>
<th>Sub Category</th>
<th>Language</th>
                      <th>SKU</th>
                      <th>Song Type</th>
                      <th>Song Price</th>
                      <th class="hidden-phone">Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
                   $select_query = $con->query("SELECT * FROM `detail` where language ='$language' ORDER BY date DESC");
while($row=$select_query->fetch_assoc())
{
?>
                    <tr class="gradeX">
                      <td><?php echo $row['name']; ?></td>
<td><?php 
$select_base_category = $con->query("SELECT * FROM `base_category` where id='".$row['section']."'");

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
                      <td class="center hidden-phone"><!--<a href="edit-song.php?edit_id=<?php //echo $row['id'];?>" ><i class="icon-edit"></i></a>&nbsp;&nbsp; -->
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
                      <th class="hidden-phone">Action</th>
                    </tr>
                  </tfoot>
                </table>

<script src="js/jquery.js"></script>

<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf-8">

          $(document).ready(function() {

 


              $('#example222').dataTable( {
                  //"aaSorting": [[ 0, "desc" ]]
columnDefs: [
  { targets: 'no-sort', orderable: true }
]
              } );

			    
          } );

      </script>
              