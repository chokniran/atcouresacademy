<?php
   require_once('../../../wp-load.php');
  
   echo '#row-'.$orderid = $_POST['orderid'];
   global $wpdb;
   $wpdb->delete('wp_payment',array( 'payment_id' => $orderid ));
 
?>