<?php
  require_once('../../../wp-load.php');
  $status = $_POST['status'];
  echo '#'.$order_id = $_POST['orderid'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $order = new WC_Order($order_id);
  if (!empty($order)) {
     $order->update_status( 'completed' );
  }

?>