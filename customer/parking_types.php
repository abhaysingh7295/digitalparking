<?php 
include '../config.php';

$select_parking_types = $con->query("SELECT * FROM `parking_types` ORDER BY parking_type_name ASC");
$numrows_parking_types = $select_parking_types->num_rows;

if ($numrows_parking_types > 0) {
	$parking_types = array();
	while($row=$select_parking_types->fetch_assoc())
	{
		$parking_types[] = $row['parking_type_name'];
	}
	$finalArray['error_code'] = 200;
	$finalArray['result'] = $parking_types;
} else {
	$finalArray['error_code'] = 400;
	$finalArray['message'] = 'No Parking Types found';
}
$resparray['response'] = $finalArray;
echo json_encode($resparray);