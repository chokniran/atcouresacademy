<?php

require_once('../../../wp-load.php');
$email = $_POST['email'];
$orderid = $_POST['orderid'];
global $wpdb;
$SQL1 = "SELECT u.`display_name` ,p.`post_id` AS PID
            FROM `wp_users` u ,`wp_postmeta` p , `wp_posts` m
            WHERE p.`meta_key` = '_customer_user'
            AND p.`meta_value` = u.`ID`
            AND m.`ID` = p.`post_id`
            AND m.`ID` = '" . $orderid . "'
            AND m.`post_type` = 'shop_order'
            AND m.`post_status` = 'wc-completed' 
            AND u.`user_email` = '" . $email . "' 
            ORDER BY p.`post_id` DESC";
$results1 = $wpdb->get_results($SQL1, OBJECT);
$i = 0;
foreach ($results1 as $result1) {
    $orderidSystem = $result1->PID;
}

if(!empty($orderidSystem)){
    echo '1';
}else{
    echo '2';
}
?>