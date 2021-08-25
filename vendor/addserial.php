<?php include 'header.php';

 $select_query = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor' ORDER BY id DESC");
                                
while($row=$select_query->fetch_assoc())
{
	$query=$con->query("select * from vehicle_booking where vendor_id='".$row['id']."'");
		if($query->num_rows > 0){
			$i=1;
			while($booking=$query->fetch_assoc()){
				$update=$con->query('update vehicle_booking SET serial_number="'.$i.'" where id='.$booking["id"].' order by created_at asc');
				echo $update;
				$i++;
			}
		}

	
}