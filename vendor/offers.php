<?php include '../config.php';

if(isset($_GET['vendor_id'])){
    $select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state, v.profile_image,v.parking_name from pa_users as v where  v.user_status=1 and v.user_role='vandor' and id='".$_GET['vendor_id']."'");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial;
}
.main {
display:flex;
  width: 100%;
}
.coupon {
  border: 5px dotted #bbb;
  width: 100%;
  border-radius: 15px;
  margin: 0 auto;
  max-width: 600px;
}

.container {
  padding: 2px 16px;
  background-color: #f1f1f1;
}

.promo {
  background: #ccc;
  padding: 3px;
}

.expire {
  color: red;
}
</style>
</head>
<body>
<div class="main">
    <?php  if ($select_query->num_rows > 0) {
    while ($rows = $select_query->fetch_assoc()) {
        $start_date = date('Y-m-d');      
         $end_date = $start_date;
        $vendor_id = $rows['id'];

    $select_querys = $con->query("SELECT * FROM `offers` WHERE  vendor_id = ".$vendor_id." and expire_date  BETWEEN '".$start_date."' AND '".$start_date."' ORDER BY expire_date DESC");
    if ($select_querys->num_rows > 0) {
                                    $i = 1;
                                    while($row=$select_querys->fetch_assoc())
                                    { ?>
<div class="coupon">
  <div class="container">
    <h3><?php echo $rows['parking_name'];?></h3>
  </div>
    <img src="<?php echo $row['image'];  ?>" alt="Avatar" width="100%" height="40%">
  <div class="container" style="background-color:white">
    <h3><b><?php echo $row['name'];  ?></b></h3> 
    <h5><b><?php echo (!empty($row['price']) && $row['price']!='0.00')?" Rs ".round($row['price'])." Off":$row['present']."% Off";  ?></b></h5> 
     <p>Use Promo Code: <span class="promo"><?php echo strtoupper($row['code']);  ?></span></p>
      <p class="expire">Expires: <?php echo date("j F Y", strtotime($row['expire_date']));  ?></p>
  </div>

     

</div>
    <?php }}?>

                                 <?php   }}else{ ?>
  
        

    <?php }?>

</div>
</body>
</html> 