<?php include('config.php');


$sbcatval = $_POST['sbcatval'];
?>
<option value="" name=" ">Select Sub Category</option>
<?php
$select_sub_category = $con->query("SELECT * FROM `sub_category` WHERE base_category_id='".$sbcatval."' AND status=1 ORDER BY id DESC");
                       while($row_sub_category=$select_sub_category->fetch_assoc())
                       { 
                        echo "<option name='" . $row_sub_category['name'] ."' value='" . $row_sub_category['id'] ."'>" . $row_sub_category['name']  . "</option>";
                       }
                       