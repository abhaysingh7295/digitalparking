<?php

include '../../config.php';
include '../../administration/functions.php';
$regi = json_decode(file_get_contents("php://input"));
if ($regi) {
    if (!isset($regi->user_login)) {
        $finalArray['error_code'] = 400;
        $finalArray['message'] = 'Please Pass Parameter : user_login';
    } elseif (empty($regi->user_login)) {
        $finalArray['error_code'] = 400;
        $finalArray['message'] = 'mobile number Must Be Required.';
    } else {
        $select_user_name = $con->query("SELECT * FROM `pa_users` Where mobile_number='" . $regi->user_login . "' AND user_role='vandor' order by id desc limit 1");
        $numrows_username = $select_user_name->num_rows;
        $otp = sent_otp($con, $regi->user_login);
        if ($numrows_username > 0) {
            $val_user = $select_user_name->fetch_assoc();
            if ($val_user['user_status'] == 1) {
                $vendor_id = $val_user['id'];
                $plan_detail=null;
               
                $select_plan = $con->query("SELECT *  FROM `vendor_subscriptions` INNER JOIN subscriptions_plans ON subscriptions_plans.id=vendor_subscriptions.subscription_plan_id  WHERE `vendor_id` = ".$vendor_id);
                $numrows_plan = $select_plan->num_rows;
                if ($numrows_plan > 0) {
                    $plan = $select_plan->fetch_assoc();
                    $plan_detail=array('planType' => $plan['plan_name'], 'planValiedStart' => $plan['subscription_start_date'], 'planValiedEnd' => $plan['subscription_end_date'], 'planAmount' => $plan['subscription_amount']);
               
                }
                $array['error_code'] = 200;
                $array['isRegister'] = true;
                $array['planSelected'] = true;
                $array['user_type'] = "Vendor";
                $array['otp'] = $otp;
                $val_user['plan'] = $plan_detail;
                 $array['result'] = $val_user;
            } else {
                $array['error_code'] = 400;
                $array['message'] = 'You are Inactive User. Please Contact to Administration.';
            }
        } else {
            $array['error_code'] = 200;
            $array['isRegister'] = false;
            $array['planSelected'] = false;
            $array['user_type'] = "Vendor";
            $array['plan'] = null;
            $array['otp'] = $otp;
            $array['result'] = null;
            $array['message'] = 'sucess';
        }
    }
} else {
    $array['error_code'] = 400;
    $array['message'] = 'Please provide request parameter';
}
$resparray['response'] = $array;
echo json_encode($resparray);
