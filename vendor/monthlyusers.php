<?php
include '../config.php';
$query=$con->query('SELECT DISTINCT(vendor_id) FROM vendor_subscriptions WHERE subscription_plan_id IN(3,4)');
if ($query->num_rows>0) {
	while ($result=$query->fetch_assoc()) {
		$currentdate = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('last day of last month')); 
        $start_date = date('Y-m-d', strtotime('first day of last month'));
        // $end_date = '2021-04-30';
        // $start_date = '2021-01-01';
        $select_query = $con->query("select v.id, CONCAT_WS(' ', v.first_name,v.last_name) as vendor_name, v.user_email, v.mobile_number as vendor_mobile, v.address, v.city, v.state from pa_users as v where  v.user_status=1 and v.user_role='vandor' and id='".$result['vendor_id']."'");
		if ($select_query->num_rows > 0) {
			$vendor_id = $result['vendor_id'];

       $select_vehicle = $con->query("SELECT sum(case when vb.vehicle_status='In' then 1 else 0 end) as vin, sum(case when vb.vehicle_status='Out' then 1 else 0 end) as vout, count(vb.vehicle_type) as total_vehicles, vb.parking_type, vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id) as ph ON ph.booking_id = vb.id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') GROUP BY vb.vehicle_type, vb.parking_type");
        $numrows_vehicle = $select_vehicle->num_rows;
        
        $select_staff_vehicle = $con->query("SELECT sum(case when vb.staff_in=ph.staff_id then 1 else 0 end) as vin, sum(case when staff_out=ph.staff_id then 1 else 0 end) as vout, count(ph.staff_id) as total_vehicles, ph.staff_id, sd.staff_name, vb.parking_type,vb.vehicle_type, sum(ph.booking_amount) as total_booking_amount FROM `vehicle_booking` as vb LEFT JOIN (select booking_id, staff_id, sum(amount) as booking_amount from payment_history WHERE FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(payment_date_time, '%Y-%m-%d') <= '".$end_date."' GROUP BY booking_id, staff_id) as ph ON ph.booking_id = vb.id AND (ph.staff_id = vb.staff_in OR ph.staff_id = vb.staff_out) LEFT JOIN staff_details as sd ON sd.staff_id = ph.staff_id Where vb.vendor_id=".$vendor_id." AND (FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_in_date_time, '%Y-%m-%d') <= '".$end_date."' OR FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') >= '".$start_date."' AND FROM_UNIXTIME(vb.vehicle_out_date_time, '%Y-%m-%d') <= '".$end_date."') AND ph.staff_id IS NOT NULL AND ph.staff_id != 0 GROUP BY ph.staff_id, vb.parking_type ORDER BY ph.staff_id");

            $select_query = $con->query("SELECT m.* , CONCAT_WS(' ', u.first_name,u.last_name) as customer_name FROM `monthly_pass` as m LEFT JOIN `pa_users` as u on m.customer_id = u.id  WHERE vendor_id = ".$vendor_id." AND (STR_TO_DATE(m.start_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.start_date, '%Y-%m-%d') <= '".$end_date."' OR STR_TO_DATE(m.end_date, '%Y-%m-%d') >= '".$start_date."' AND STR_TO_DATE(m.end_date, '%Y-%m-%d') <= '".$end_date."') ORDER BY id DESC");
                                            
            
            if ($numrows_vehicle > 0 || $select_staff_vehicle->num_rows > 0 || $select_query->num_rows > 0){
            	#echo 'http://localhost:8080/vehicalepe/vendor/allovervehiclereport.php?vendor_id='.$result['vendor_id'].'<br>';
				echo '<a href="'.SITE_URL.'vendor/allovervehiclereport.php?vendor_id='.$result['vendor_id'].'" target="blank">'.SITE_URL.'vendor/allovervehiclereport.php?vendor_id='.$result['vendor_id'].'</a><br>';
            }
		}
	}
}
?>