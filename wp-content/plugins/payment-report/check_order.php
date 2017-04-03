<?php
   require_once('../../../wp-load.php');
   $email = $_POST['email'];
   $orderid = $_POST['orderid'];
   global $wpdb;
   $SQL1 = "SELECT u.`display_name` ,p.`post_id` as PID
            FROM `wp_users` u ,`wp_postmeta` p , `wp_posts` m
            WHERE p.`meta_key` = '_customer_user'
            AND p.`meta_value` = u.`ID`
            AND m.`ID` = p.`post_id`
            AND m.`post_type` = 'shop_order'
            AND m.`post_status` != 'trash' 
            AND u.`user_email` = '".$email."' 
            ORDER BY p.`post_id` DESC";

    $results1 = $wpdb->get_results($SQL1, OBJECT );
        $i = 0 ;
        foreach( $results1 as $result1 ) {
                 $orderidSystem =  $result1->PID ;
           
                 if($orderidSystem == $orderid ){
                      	$result = 1;
                    }
        }

        echo $result 
?>