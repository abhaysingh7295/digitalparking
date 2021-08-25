<?php
include '../config.php'; 
$state_id = $_POST["state_id"];
$city= $con->query("SELECT * FROM `city` WHERE status ='Active' and state_id='".$state_id."' order by name asc");
?>
<option value="">City</option>
<?php
while($row = $city->fetch_assoc()) {
?>
<option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
<?php
}
?>
