<?php
   require_once('../../../wp-load.php');
   $orderid = $_POST['orderid'];
   global $wpdb;
   $SQL = "SELECT  *  FROM `wp_payment` WHERE order_id ='".$orderid."' ";
   $results = $wpdb->get_results($SQL, OBJECT );
        foreach( $results as $result ) {
            $val  = $result->order_id;
        }

      if(!empty($val)){
         echo '1';
      }else{
         echo '2';
      }
?>