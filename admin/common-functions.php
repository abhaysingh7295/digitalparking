<?php 

 /* Site Settings Querys */

$site_settings_query = $con->query("select * from `settings` where id = '1'");
$site_settings_row=$site_settings_query->fetch_assoc();
