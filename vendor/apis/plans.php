<?php

include '../../config.php';
$regi = json_decode(file_get_contents("php://input"));
$subscriptions_plans = $con->query("SELECT * FROM `subscriptions_plans` Where  status=1 order by id asc");
$numrows_plan = $subscriptions_plans->num_rows;

if ($numrows_plan > 0) {
    $finalArray['error_code'] = 200;
    $finalArray['message'] = 'Sucess';
   $final=array();
    while ($row = $subscriptions_plans->fetch_assoc()) {
        $Array=array();
        $Array['id'] = $row['id'];
        $Array['plan_name'] = $row['plan_name'];
        $Array['plan_amount'] = $row['plan_amount'];
        $final[]=$Array;
    }
    $finalArray['plans']=$final;
} else {
    $finalArray['error_code'] = 400;
    $finalArray['message'] = 'Record not found!';
}
$resparray['response'] = $finalArray;
echo json_encode($resparray);
?>

