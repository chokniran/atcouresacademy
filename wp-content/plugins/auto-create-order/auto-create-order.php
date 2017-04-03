<?php 
/*  Plugin Name: Auto create order
    Description: Auto create order
    Version: 1.0  
    Author: Chokniran Chongsomchit
*/  
?>
<?php

function learn_press_create_order_import( $order_data,$subtotal ) {
  $order_data_defaults = array(
    'ID'          => 0,
    'post_author' => '1',
    'post_parent' => '0',
    'post_type'   => LP()->order_post_type,
    'post_status' => 'lp-' . apply_filters( 'learn_press_default_order_status', 'pending' ),
    'ping_status' => 'closed',
    'post_title'  => __( 'Order on', 'learnpress' ) . ' ' . current_time( "l jS F Y h:i:s A" )
  );
  $order_data_defaults = apply_filters( 'learn_press_defaults_order_data', $order_data_defaults );
  $order_data          = wp_parse_args( $order_data, $order_data_defaults );

  if ( $order_data['status'] ) {
    if ( !in_array( 'lp-' . $order_data['status'], array_keys( learn_press_get_order_statuses() ) ) ) {
      return new WP_Error( 'learn_press_invalid_order_status', __( 'Invalid order status', 'learnpress' ) );
    }
    $order_data['post_status'] = 'lp-' . $order_data['status'];
  }

  if ( !is_null( $order_data['user_note'] ) ) {
    $order_data['post_excerpt'] = $order_data['user_note'];
  }

  if ( $order_data['ID'] ) {
    $order_data = apply_filters( 'learn_press_update_order_data', $order_data );
    wp_update_post( $order_data );
    $order_id = $order_data['ID'];
  } else {
    $order_data = apply_filters( 'learn_press_new_order_data', $order_data );
    $order_id   = wp_insert_post( $order_data );
  }


  if ( $order_id ) {
    $order = LP_Order::instance( $order_id );

    update_post_meta( $order_id, '_order_currency', learn_press_get_currency() );
    update_post_meta( $order_id, '_prices_include_tax', 'no' );
    update_post_meta( $order_id, '_user_ip_address', learn_press_get_ip() );
    update_post_meta( $order_id, '_user_agent', isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' );
    update_post_meta( $order_id, '_user_id', $order_data['user_id'] );
    update_post_meta( $order_id, '_order_subtotal', $subtotal );
    update_post_meta( $order_id, '_order_total', $subtotal );
    update_post_meta( $order_id, '_order_key', apply_filters( 'learn_press_generate_order_key', uniqid( 'order' ) ) );
    update_post_meta( $order_id, '_payment_method', 'โอนเงินผ่านธนาคาร' );
    update_post_meta( $order_id, '_payment_method_title', '' );
    update_post_meta( $order_id, '_order_version', '1.0' );
    update_post_meta( $order_id, '_created_via', !empty( $order_data['created_via'] ) ? $order_data['created_via'] : 'checkout' );
  }

  return LP_Order::instance( $order_id, true );
}

function crateCouresOrder($couresid, $subtotal, $userid){
global $wpdb;
$sql_lastid = "SELECT MAX(ID) AS maxid FROM `wp_posts`";
$result = $wpdb->get_results($sql_lastid);
$maxid =  $result[0]->maxid+1;
$order_data = array(
        'status'      => apply_filters( 'learn_press_default_order_status', 'pending' ),
        'user_id'     => $userid,
        'user_note'   => isset( $_REQUEST['order_comments'] ) ? $_REQUEST['order_comments'] : '',
        'created_via' => 'checkout'
      );

      // Insert or update the post data
      //$order_id = absint( LP()->session->order_awaiting_payment );
      $order_id = $maxid;
      // Resume the unpaid order if its pending
      if ( $order_id > 0 && ( $order = learn_press_get_order( $order_id ) ) && $order->has_status( array( 'pending', 'failed' ) ) ) {

        $order_data['ID'] = $order_id;
        $order            = learn_press_update_order( $order_data );

        if ( is_wp_error( $order ) ) {
          throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'learnpress' ), 401 ) );
        } else {
          $order->remove_order_items();
          //do_action( 'learn_press_resume_order', $order_id );
        }

      } else {
        $order = learn_press_create_order_import( $order_data,$subtotal );
        if ( is_wp_error( $order ) ) {
          throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'learnpress' ), 400 ) );
        } else {
          $order_id = $order->id;
          do_action( 'learn_press_new_order', $order_id );
        }
      }

      $dataCoures = Array($couresid => Array(
                               'item_id' => $couresid,
                               'quantity' => '1',
                               'subtotal' => $subtotal,
                               'total' => $subtotal
                               )
      );

      foreach ( $dataCoures as $item ) {
        if ( empty( $item['order_item_name'] ) && !empty( $item['item_id'] ) && ( $course = LP_Course::get_course( $item['item_id'] ) ) ) {
          $item['order_item_name'] = $course->get_title();
        } else {
          throw new Exception( sprintf( __( 'Item does not exists!', 'learnpress' ), 402 ) );
        }
        $item_id = $order->add_item( $item );

        if ( !$item_id ) {
          throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'learnpress' ), 402 ) );
        }
        // Allow plugins to add order item meta
        do_action( 'learn_press_add_order_item_meta', $item_id, $item );
        learn_press_update_order_status( $order_id, 'lp-completed' );
      }
}

function getOrderbyUser($num1,$num2){
  $link = mysqli_connect("localhost", "onlinebd_db", "bbED17Tz", "onlinebd_db");
          mysqli_set_charset($link,"utf8");            
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }else{

          $sql_status = "SELECT p.`ID` AS order_id ,pm.`meta_value` AS user_id
                         FROM `wp_posts` p, `wp_postmeta` pm 
                         WHERE p.`post_status` = 'lp-completed' 
                         AND pm.`post_id` = p.`ID`
                         AND pm.`post_id` >= $num1
                         AND pm.`post_id` <= $num2
                         AND pm.`meta_key` = '_learn_press_customer_id'
                         ORDER BY p.`ID` ASC";
          $result_status = mysqli_query($link, $sql_status);
          while($row = mysqli_fetch_array($result_status)){
          $order_id = $row['order_id'];
          $user_id =  $row['user_id'];
          $sql_coures = "SELECT `meta_value` 
                         FROM `wp_postmeta` 
                         WHERE `meta_key` = '_learn_press_order_items' 
                         AND `post_id` = $order_id"; 

          $result_coures = mysqli_query($link, $sql_coures);
          $row_coures = mysqli_fetch_array($result_coures);
          $detail = $row_coures[0];
          $data = unserialize($detail);
          $ArrData = json_decode(json_encode($data), True);
          $coures = $ArrData['products'];
          $subtotal = $ArrData['sub_total'];
          $key = array_keys($coures);
          $couresid =  $key[0];     
          if($couresid == '12490') {
              $cid = '13515';
          }else if($couresid == '12478'){
              $cid = '13513';
          }else if($couresid == '12466'){
              $cid = '13511';
          }else if($couresid == '11984'){
              $cid = '13509';
          }else if($couresid == '11810'){
              $cid = '13507';
          }else if($couresid == '11624'){
              $cid = '13505';
          }else if($couresid == '11583'){
              $cid = '13503';
          }else if($couresid == '9875'){
              $cid = '13501';
          }else if($couresid == '9869'){
              $cid = '13499';
          }else if($couresid == '9862'){
              $cid = '13497';
          }else if($couresid == '9061'){
              $cid = '13495';
          }else if($couresid == '7512'){
              $cid = '13493';
          }else if($couresid == '7495'){
              $cid = '13491';
          }else if($couresid == '7487'){
              $cid = '13489';
          }else if($couresid == '7480'){
              $cid = '13487';
          }else if($couresid == '7466'){
              $cid = '13460';
          }else if($couresid == '7458'){
              $cid = '13451';
          }else if($couresid == '7448'){
              $cid = '13442';
          }else if($couresid == '7398'){
              $cid = '13433';
          }else if($couresid == '7389'){
              $cid = '13424';
          }else if($couresid == '7365'){
              $cid = '13414';
          }else if($couresid == '7358'){
              $cid = '13405';
          }else if($couresid == '7281'){
              $cid = '13395';
          }else if($couresid == '7277'){
              $cid = '13386';
          }else if($couresid == '7271'){
              $cid = '13378';
          }else if($couresid == '7267'){
              $cid = '13369';
          }else if($couresid == '7261'){
              $cid = '13362';
          }else if($couresid == '7200'){
              $cid = '13353';
          }else if($couresid == '7190'){
              $cid = '13344';
          }else if($couresid == '7181'){
              $cid = '13335';
          }else if($couresid == '7173'){
              $cid = '13326';
          }else if($couresid == '7104'){
              $cid = '13317';
          }else if($couresid == '7092'){
              $cid = '13308';
          }else if($couresid == '7084'){
              $cid = '13300';
          }else if($couresid == '7076'){
              $cid = '13290';
          }else if($couresid == '7068'){
              $cid = '13281';
          }else if($couresid == '6803'){
              $cid = '13270';
          }else if($couresid == '6797'){
              $cid = '13261';
          }else if($couresid == '6790'){
              $cid = '13251';
          }else if($couresid == '6784'){
              $cid = '13242';
          }else if($couresid == '6777'){
              $cid = '13233';
          }else if($couresid == '6769'){
              $cid = '13223';
          }else if($couresid == '6763'){
              $cid = '13214';
          }else if($couresid == '6751'){
              $cid = '13026';
          }else if($couresid == '6745'){
              $cid = '13197';
          }else if($couresid == '4362'){
              $cid = '13186';
          }else if($couresid == '5611'){
              $cid = '13177';
          }else if($couresid == '5241'){
              $cid = '13168';
          }else if($couresid == '4801'){
              $cid = '13154';
          }else if($couresid == '4363'){
              $cid = '13144';
          }else if($couresid == '4238'){
              $cid = '13134';
          }else if($couresid == '3138'){
              $cid = '13125';
          }else if($couresid == '3363'){
              $cid = '13108';
          }else if($couresid == '3361'){
              $cid = '13099';
          }else if($couresid == '3316'){
              $cid = '13090';
          }else if($couresid == '1773'){
              $cid = '13081';
          }else if($couresid == '2460'){
              $cid = '13009';
          }else if($couresid == '2462'){
              $cid = '12995';
          }else if($couresid == '2412'){
              $cid = '12979';
          }else{
           echo 'ไม่พบรายการ เก่า ='.$couresid .' ใหม่ = '.$cid;
          }      
           crateCouresOrder($cid, $subtotal,$user_id);
           echo 'order = '.$order_id.' สำเร็จ';
           echo '<br>';
          }           
        }
      }

function mainLoad( $atts ) { 
   $num1 = '12685';   
   $num2 = '12685';             
   getOrderbyUser($num1,$num2); 
}
add_shortcode( 'ato', 'mainLoad' ); 
?> 
       
   