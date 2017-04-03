<?php
 
/**
 * Register menu report
 */
function report_profit(){
    add_menu_page( 
        __( 'report profit', 'textdomain' ),
        'รายงานยอดขาย',
        'manage_options',
        'report-profit',
        'report_menu_profit',
        get_template_directory_uri().'/learnpress-v1/report/image/report.png',6
    ); 
}
add_action( 'admin_menu', 'report_profit' );

function submenu_blank() {
    add_submenu_page(
        'report-profit',
        'report-bank',
        'โอนเงินผ่านธนาคาร',
        'manage_options',
        'report-bank',
        'report_menu_profit_bank' );
}
add_action('admin_menu', 'submenu_blank');

function submenu_paypal() {
    add_submenu_page(
        'report-profit',
        'report-paypal',
        'paypal',
        'manage_options',
        'report-paypal',
        'report_menu_profit_paypal' );
}
add_action('admin_menu', 'submenu_paypal');

function submenu_all_profit() {
    add_submenu_page(
        'report-profit',
        'report-all-profit',
        'รวมยอดขายทุกช่องทาง',
        'manage_options',
        'report-all-profit',
        'report_menu_all_profit' );
}
add_action('admin_menu', 'submenu_all_profit');

function submenu_2c2p() {
    add_submenu_page(
        'report-profit',
        'report-2c2p',
        '2c2p',
        'manage_options',
        'report-2c2p',
        'report_menu_profit_2c2p' );
}
add_action('admin_menu', 'submenu_2c2p');
function submenu_coures() {
    add_submenu_page(
        'report-profit',
        'report-coures',
        'คอร์ส',
        'manage_options',
        'report-coures',
        'report_menu_profit_coures' );
}
add_action('admin_menu', 'submenu_coures');

function submenu_author() {
    add_submenu_page(
        'report-profit',
        'report-author',
        'อาจารย์',
        'manage_options',
        'report-author',
        'report_menu_profit_author' );
}
add_action('admin_menu', 'submenu_author');

 //rander report main report
function report_menu_profit(){
  report_menu_page('bacs');
}
//rander report bank
function report_menu_profit_bank(){
  report_menu_page('bacs');
}
//rander report paypal
function report_menu_profit_paypal(){
  report_menu_page('paypal');
}
//rander report 2c2p
function report_menu_profit_2c2p(){
  report_menu_page('2c2p');
}

//rander report all
function report_menu_all_profit(){
  report_menu_page('all');
}

//rander report author
function report_menu_profit_author(){
  report_menu_author('author');
}
//rander report coures
function report_menu_profit_coures(){
  report_menu_coures_view();
}
//get date payment
function getPayment($order_id){
   global $wpdb;
           $result = $wpdb->get_results (
           "
           SELECT  date  FROM `wp_payment` WHERE `order_id` =  $order_id
           "
           );
   foreach ($result as $key) {
    $date = $key->date;
}
  return  $date;
}
//report payment method
function report_menu_page($payment_met){
   ?>
     <div id="wpbody_main" role="main">
      <?php 
      //include style and script
      echo includeScriptAndStyle();
    ?>

    <div id="wpbody-content" aria-label="Main content" tabindex="0">
     <h2>รายงานยอดขาย</h2>
     <div class="row-search">
        <input type="text" id="date-start" name="date-start" class="form-pay" placeholder="จากวันที่">
        <input type="text" id="date-end" name="date-end" class="form-pay" placeholder="ถึงวันที่">
        <a href="javascript:void(0)" type="button" class="btn btn-primary view_report">ค้นหา</a>
     </div>
     <nav id="main_nav" class="navbar navbar-default">
       <div class="container-fluid">
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <?php 
                  if($payment_met == 'bacs'){
                      $url = get_site_url().'/wp-admin/admin.php?page=report-bank/';
                      ?>
                         <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
                      <?php
                  }else if($payment_met == 'paypal'){
                        $url = get_site_url().'/wp-admin/admin.php?page=report-paypal/';
                        ?>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                         <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
                      <?php
                  }else if($payment_met == '2c2p'){
                       $url = get_site_url().'/wp-admin/admin.php?page=report-2c2p/';
                       ?>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                         <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
                       <?php
                  }else if($payment_met == 'all'){
                       $url = get_site_url().'/wp-admin/admin.php?page=report-all-profit/';
                       ?>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                         <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
                       <?php
                  }
               ?>
              
            </ul>
            <div class="display_date">
               <span class="label label-default">
               <?php
                  if(empty($_GET['date_start'])){
                      echo 'วันที่ '.date("Y-m-d");
                      $querydate1 = date("Y-m-d").' 00:00:00';
                  }else{
                      echo 'จากวันที่ '.$_GET['date_start'];
                      $querydate1 = $_GET['date_start'].' 00:00:00';
                  }
    
                  if(empty($_GET['date_end'])){
                      echo ' ถึงวันที่ '.date("Y-m-d");
                      $querydate2 = date("Y-m-d").' 23:59:59';
                  }else{
                      echo ' ถึงวันที่ '.$_GET['date_end'];
                      $querydate2 = $_GET['date_end'].' 23:59:59';
                  }
                  ?>
                </spna>
            </div>
            <div class="total">
               <ul>
			       <li><strong>จำนวนการสั่งซื้อ </strong><span class="label label-info res-num"><?php echo get_total_order($querydate1, $querydate2,$payment_met); ?> ครั้ง</span></li>
                   <li><strong>ยอดรวม </strong><span class="label label-success res-money"></span></li>
               </ul>
            </div>
         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
     <div class="content-report">
        <?php 
           global $wpdb;
           $result = $wpdb->get_results (
           "
           SELECT id,post_modified FROM `wp_posts` 
           WHERE `post_type` = 'shop_order'
           AND `post_status` = 'wc-completed'
           AND `post_date` >= '$querydate1'
           AND `post_date` <= '$querydate2'
           ORDER BY id DESC
           "
           );
           ?>
             <table class="table table-striped">
                <thead>
                  <tr>
                      <th width="60">ลำดับ</th>
                      <th width="100">เลขที่สั่งซื้อ</th>
					  <th width="50">จำนวน</th>
					  <th width="350">รายการ</th>
                      <th width="150">วันที่ชำระเงิน</th>
                      <th>ลูกค้า</th>
                      <th>ช่งทางการชำระเงิน</th>
                      <th>จำนวนเงิน</th>
                  </tr>
                </thead>
                <tbody>
           <?php
           $i = 1;
           foreach ($result as $key) {
             $order_id = $key->id;
             $post_modified = $key->post_modified;
             $payment_method = get_post_meta( $key->id,'_payment_method', true);
             $first_name = get_post_meta( $key->id,'_shipping_first_name', true);
             $last_name = get_post_meta( $key->id,'_shipping_last_name', true);
             $order_total = get_post_meta( $key->id,'_order_total', true);
			       $_learn_press_order_id = get_post_meta( $key->id,'_learn_press_order_id', true);

             if($payment_method == $payment_met){
                ?>
                <tr>
                      <td><?php echo $i ?></td>
                      <td><a target="blank_" href="<?php echo get_site_url().'/wp-admin/post.php?post='.$order_id.'&action=edit'?>"><?php echo $order_id ?></a></td>
                      <td><?php echo get_product_amount_in_order($_learn_press_order_id) ?></td>
					            <td><?php echo get_product_name_in_order($order_id); ?></td>
					            <?php $date_pay = getPayment($order_id); 
                         if($payment_met == 'bacs'){
                            if(empty($date_pay)){
                               ?>
                                <td class="danger">ไม่มีการแจ้งผ่านระบบ</td>
                               <?php 
                             }else{
                               ?>
                                 <td><?php echo $date_pay ?></td>
                               <?php 
                             }
                         }else{
                            ?>
                              <td><?php echo $post_modified ?></td>
                            <?php 
                         }
                      ?>
                      <td><?php echo $first_name.' '.$last_name ?></td>
                      <td><?php echo getPaymentText($payment_method) ?></td>
                      <td><?php echo $order_total ?></td>
                  </tr>
                <?php
               $i++;
               $sum = $sum+$order_total; 
             }else if($payment_met == 'all'){
                ?>
                <tr>
                      <td><?php echo $i ?></td>
                      <td><a target="blank_" href="<?php echo get_site_url().'/wp-admin/post.php?post='.$order_id.'&action=edit'?>"><?php echo $order_id ?></a></td>
                      <td><?php echo get_product_amount_in_order($_learn_press_order_id) ?></td>
                      <td><?php echo get_product_name_in_order($order_id); ?></td>
                      <?php $date_pay = getPayment($order_id); 
                         if($payment_met == 'bacs'){
                            if(empty($date_pay)){
                               ?>
                                <td class="danger">ไม่มีการแจ้งผ่านระบบ</td>
                               <?php 
                             }else{
                               ?>
                                 <td><?php echo $date_pay ?></td>
                               <?php 
                             }
                         }else{
                            ?>
                              <td><?php echo $post_modified ?></td>
                            <?php 
                         }
                      ?>
                      <td><?php echo $first_name.' '.$last_name ?></td>
                      <td><?php echo getPaymentText($payment_method) ?></td>
                      <td><?php echo $order_total ?></td>
                  </tr>
                <?php
                $i++;
                $sum = $sum+$order_total; 
             }
           }
       ?>
         </tbody>
        </table>

        <?php 
        if($i<=1){
           echo '<div class="alert alert-danger" role="alert">ไม่พบข้อมูล</div>';
        }?>
     </div>
    </div><!-- wpbody-content -->
    </div>
     <script>
    var total = "<?php echo $sum ?>";
    var count = "<?php echo $i ?>";
    jQuery('.res-num').text(" "+(count-1)+" ครั้ง");
      if(total==""){
        jQuery('.res-money').text(" 0 บาท");
      }else{
        jQuery('.res-money').text(" "+total+" บาท");
      }

       jQuery(function(){
          jQuery('#date-start').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
          jQuery('#date-end').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
       })
       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });

       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });
      
    </script>
   <?php 
}
//report payment author
function report_menu_author($payment_met){
 ?>
    <div id="wpbody_main" role="main">

    <?php 
      //include style and script
      echo includeScriptAndStyle();
    ?>
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
     <h2>รายงานยอดขาย</h2>
     <div class="row-search">
          <input type="text" id="date-start" name="date-start" class="form-pay" placeholder="จากวันที่">
          <input type="text" id="date-end" name="date-end" class="form-pay" placeholder="ถึงวันที่">
          <a href="javascript:void(0)" type="button" class="btn btn-primary view_report">ค้นหา</a>
     </div>
     <nav id="main_nav" class="navbar navbar-default">
       <div class="container-fluid">
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <?php 
                  if($payment_met == 'author'){
                       $url = get_site_url().'/wp-admin/admin.php?page=report-author/';
                       ?>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                         <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                         <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
                       <?php
                   }
               ?>
            </ul>
            <div class="display_date">
               <span class="label label-default">
               <?php
                  if(empty($_GET['date_start'])){
                      echo 'วันที่ '.date("Y-m-d");
                      $querydate1 = date("Y-m-d").' 00:00:00';
                  }else{
                      echo 'จากวันที่ '.$_GET['date_start'];
                      $querydate1 = $_GET['date_start'].' 00:00:00';
                  }
    
                  if(empty($_GET['date_end'])){
                      echo ' ถึงวันที่ '.date("Y-m-d");
                      $querydate2 = date("Y-m-d").' 23:59:59';
                  }else{
                      echo ' ถึงวันที่ '.$_GET['date_end'];
                      $querydate2 = $_GET['date_end'].' 23:59:59';
                  }
                  ?>
                </spna>
            </div>
            <div class="total">
               <ul>
			      <li><strong>จำนวนการสั่งซื้อ </strong><span class="label label-info"><?php echo get_total_order($querydate1, $querydate2); ?> ครั้ง</span></li>
                  <li><strong>จำนวนการสั่งซือ </strong><span class="label label-info res-num">500 ครั้ง</span></li>
                  <li><strong>ยอดรวม </strong><span class="label label-success res-money">บาท</span></li>
               </ul>
            </div>
         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
     <div class="content-report">
        <?php 
           global $wpdb;
           $result = $wpdb->get_results (
           "
           SELECT um.`user_id` AS userid
           FROM `wp_users` u, `wp_usermeta` um
           WHERE u.`ID` = um.`user_id`
           AND um.`meta_key` = 'wp_user_level'
           AND um.`meta_value` = '10'
           AND um.`user_id`  NOT IN (57,285)
           
           "
           );
           ?>
             <table class="table table-striped">
                <thead>
                  <tr>
                      <th width="75">ลำดับ</th>
                      <th width="200">ชื่ออาจารย์</th>
                      <th width="200">จำนวนการสั่งซื้อ</th>
                      <th>รวม</th>
                  </tr>
                </thead>
                <tbody>
           <?php
           $i = 1;
           foreach ($result as $key) {
             $userid = $key->userid;
             $user_info = get_userdata($userid);
             $fullname = $user_info->first_name .' '.$user_info->last_name;
             ?>
              <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $fullname ?></td>
                  <td><?php echo $count = getOrderCountbyAuthor($userid,$querydate1,$querydate2); ?></td>
                  <td><?php echo $total = getOrderTotalbyAuthor($userid,$querydate1,$querydate2); ?></td>
              </tr>
              <?php
               $count_all = $count_all + $count;
               $sum = $sum + $total; 
               $i++;
           }
       ?>
         </tbody>
        </table>

        <?php 
        if($i<=1){
           echo '<div class="alert alert-danger" role="alert">ไม่พบข้อมูล</div>';
        }?>
     </div>
    </div><!-- wpbody-content -->
    </div>
     <script>
    var total = "<?php echo $sum ?>";
    var count = "<?php echo $count_all ?>";
    jQuery('.res-num').text(" "+(count)+" ครั้ง");
      if(total==""){
        jQuery('.res-money').text(" 0 บาท");
      }else{
        jQuery('.res-money').text(" "+total+" บาท");
      }

       jQuery(function(){
          jQuery('#date-start').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
          jQuery('#date-end').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
       })
       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });

       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });
      
    </script>
   <?php 
}

//main in script and style
function includeScriptAndStyle(){
  ?>
    <link href="<?php echo get_template_directory_uri().'/learnpress-v1/report/css/style.css'; ?>" rel="stylesheet">
     <link href="<?php echo get_template_directory_uri().'/learnpress-v1/report/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
     <link href="<?php echo get_template_directory_uri().'/learnpress-v1/report/dist/css/bootstrap-theme.min.css'; ?>" rel="stylesheet">
     <script src="<?php echo get_template_directory_uri().'/learnpress-v1/report/dist/js/bootstrap.min.js'; ?>"></script>
     <script src="<?php echo get_template_directory_uri().'/learnpress-v1/report/jquery-ui/jquery-1.12.4.js'; ?>"></script>
     <link href="<?php echo get_template_directory_uri().'/learnpress-v1/report/datepicker/css/bootstrap-material-datetimepicker.css'; ?>" rel="stylesheet">
     <link rel="stylesheet" href="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/css/material.min.css" />
     <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
     <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
     <script src="<?php echo get_template_directory_uri().'/learnpress-v1/report/datepicker/js/bootstrap-material-datetimepicker.js'; ?>"></script>
  <?php
}

function ca_custom_meta() {
    add_meta_box( 'authordiv', __('อาจารย์'), 'ca_meta_callback', 'lp_course', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ca_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function ca_meta_callback( $post ) {
  global $user_ID;
?>
<label class="screen-reader-text" for="post_author_override"><?php _e('Author'); ?></label>
<?php
  wp_dropdown_users( array(
    'name' => 'post_author_override',
    'selected' => empty($post->ID) ? $user_ID : $post->post_author,
    'include_selected' => true
  ) );
}

function getOrderTotalbyAuthor($userid,$querydate1,$querydate2){
         global $wpdb;
         $result = $wpdb->get_results (
         "
         SELECT id,post_modified FROM `wp_posts` 
         WHERE `post_type` = 'shop_order'
         AND `post_status` = 'wc-completed'
         AND `post_date` >= '$querydate1'
         AND `post_date` <= '$querydate2'
         ORDER BY id DESC
         "
         );
           //get all order complate
           foreach ($result as $key) {
               $order_id = $key->id;
               $learn_press_order_id = get_post_meta( $order_id,'_learn_press_order_id', true);
               $order_item = $wpdb->get_results (
                 "
                  SELECT `order_item_id` FROM `wp_learnpress_order_items` WHERE `order_id` = '$learn_press_order_id'
                 "
               );
               //get list coures in order item
               foreach ($order_item as $order_item_val) {
                  $item_id = $order_item_val->order_item_id;
                     $coures_res = $wpdb->get_results (
                     "
                       SELECT `meta_value`
                       FROM `wp_learnpress_order_itemmeta`
                       WHERE `learnpress_order_item_id` = '$item_id'
                       AND `meta_key` = '_course_id'
                     "
                    );
                    //get couresid in author
                    foreach ($coures_res as $coures_val) {
                        $coures_id = $coures_val->meta_value;
                        $post_tmp = get_post($coures_id);
                        $author_id = $post_tmp->post_author;
                         if($author_id == $userid){
                         	//get price of coures
                  	        $coures_price = get_post_meta($coures_id,'_lp_price', true);
                            $sum = $sum + $coures_price; 
                  	           
                         }
                    } 
               }  
           }

      if($sum<=0){
        return 0;
      }else {
        return $sum;
    } 
}

function getOrderCountbyAuthor($userid,$querydate1,$querydate2){
  global $wpdb;
         $result = $wpdb->get_results (
         "
         SELECT id,post_modified FROM `wp_posts` 
         WHERE `post_type` = 'shop_order'
         AND `post_status` = 'wc-completed'
         AND `post_date` >= '$querydate1'
         AND `post_date` <= '$querydate2'
         ORDER BY id DESC
         "
         );
           //get all order complate
           foreach ($result as $key) {
               $order_id = $key->id;
               $learn_press_order_id = get_post_meta( $order_id,'_learn_press_order_id', true);
               $order_item = $wpdb->get_results (
                 "
                  SELECT `order_item_id` FROM `wp_learnpress_order_items` WHERE `order_id` = '$learn_press_order_id'
                 "
               );
               //get list coures in order item
               foreach ($order_item as $order_item_val) {
                  $item_id = $order_item_val->order_item_id;
                     $coures_res = $wpdb->get_results (
                     "
                       SELECT `meta_value`
                       FROM `wp_learnpress_order_itemmeta`
                       WHERE `learnpress_order_item_id` = '$item_id'
                       AND `meta_key` = '_course_id'
                     "
                    );
                    //get couresid in author
                    foreach ($coures_res as $coures_val) {
                        $coures_id = $coures_val->meta_value;
                        $post_tmp = get_post($coures_id);
                        $author_id = $post_tmp->post_author;
                         if($author_id == $userid){
                         	//get price of coures
                  	        $sum++;
                  	           
                         }
                    } 
               }  
           }

      if($sum<=0){
        return 0;
      }else {
        return $sum;
    } 
}

function getTotalbyCoures($post_id,$querydate1,$querydate2){
  global $wpdb;
         $result = $wpdb->get_results (
         "
         SELECT id,post_modified FROM `wp_posts` 
         WHERE `post_type` = 'shop_order'
         AND `post_status` = 'wc-completed'
         AND `post_date` >= '$querydate1'
         AND `post_date` <= '$querydate2'
         ORDER BY id DESC
         "
         );
           //get all order complate
           foreach ($result as $key) {
               $order_id = $key->id;
               $learn_press_order_id = get_post_meta( $order_id,'_learn_press_order_id', true);
               $order_item = $wpdb->get_results (
                 "
                  SELECT `order_item_id` FROM `wp_learnpress_order_items` WHERE `order_id` = '$learn_press_order_id'
                 "
               );
               //get list coures in order item
               foreach ($order_item as $order_item_val) {
                     $item_id = $order_item_val->order_item_id;
                     $coures_res = $wpdb->get_results (
                     "
                       SELECT `meta_value`
                       FROM `wp_learnpress_order_itemmeta`
                       WHERE `learnpress_order_item_id` = '$item_id'
                       AND `meta_key` = '_course_id'
                     "
                    );
                    //get couresid in author
                    foreach ($coures_res as $coures_val) {
                        $coures_id = $coures_val->meta_value;
                        $post_tmp = get_post($coures_id);
                        $author_id = $post_tmp->post_author;
                          if($coures_id == $post_id){
                         	//get price of coures                          
                  	        $sum++;                         
                           }
                    } 
               }  
           }

      if($sum<=0){
        return 0;
      }else {
        return $sum;
    } 
}

function report_menu_coures_view(){
   ?>
    <div id="wpbody_main" role="main">

    <?php 
      //include style and script
      echo includeScriptAndStyle();
    ?>
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
     <h2>รายงานยอดขายของแต่ล่ะคอร์ส</h2>
     <div class="row-search">
          <input type="text" id="date-start" name="date-start" class="form-pay" placeholder="จากวันที่">
          <input type="text" id="date-end" name="date-end" class="form-pay" placeholder="ถึงวันที่">
          <a href="javascript:void(0)" type="button" class="btn btn-primary view_report">ค้นหา</a>
     </div>
     <nav id="main_nav" class="navbar navbar-default">
       <div class="container-fluid">
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                 <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-bank' ?>"><strong>โอนเงินผ่านธนาคาร</strong></a></li>
                 <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-paypal' ?>"><strong>paypal</strong></a></li>
                 <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-2c2p' ?>"><strong>2c2p</strong></a></li>
                 <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-author' ?>"><strong>อาจารย์</strong></a></li>
                 <li><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-all-profit' ?>"><strong>รวมยอดขายทุกช่องทาง</strong></a></li>
                 <li class="active"><a href="<?php echo get_site_url().'/wp-admin/admin.php?page=report-coures' ?>"><strong>คอร์ส</strong></a></li>
            </ul>
            <div class="display_date">
               <span class="label label-default">
               <?php
                  $url = get_site_url().'/wp-admin/admin.php?page=report-coures/';
                  if(empty($_GET['date_start'])){
                      echo 'วันที่ '.date("Y-m-d");
                      $querydate1 = date("Y-m-d").' 00:00:00';
                  }else{
                      echo 'จากวันที่ '.$_GET['date_start'];
                      $querydate1 = $_GET['date_start'].' 00:00:00';
                  }
    
                  if(empty($_GET['date_end'])){
                      echo ' ถึงวันที่ '.date("Y-m-d");
                      $querydate2 = date("Y-m-d").' 23:59:59';
                  }else{
                      echo ' ถึงวันที่ '.$_GET['date_end'];
                      $querydate2 = $_GET['date_end'].' 23:59:59';
                  }
                   
                   
                  ?>
                </span>
            </div>
            <div class="total">
               <ul>
                  <li><strong>จำนวนการสั่งซื้อ </strong><span class="label label-info"><?php echo get_total_order($querydate1, $querydate2); ?> ครั้ง</span></li>
                  <li><strong>จำนวนคอร์ส </strong><span class="label label-info res-num">500 ครั้ง</span></li>
                  <li><strong>ยอดรวม </strong><span class="label label-success "><?php echo  get_total_price_order($querydate1, $querydate2,$payment_met);?>  บาท</span></li>
               </ul>
            </div>
         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

     <div class="content-report">
        <?php 
           global $wpdb;
           $result = $wpdb->get_results (
           "
           SELECT `post_title`,ID FROM `wp_posts` WHERE `post_type` = 'lp_course' AND `post_status` = 'publish'
           "
           );
           ?>
             <table class="table table-striped">
                <thead>
                  <tr>
                      <th width="75">ลำดับ</th>
                      <th width="400">ชื่อคอร์ส</th>
                      <th width="200">จำนวนการสั่งซื้อ</th>
                      <th width="200">ราคา</th>
                      <th width="200">หน่วย</th>
                      <th>รวม</th>
                  </tr>
                </thead>
                <tbody>
           <?php
           $i = 1;
           foreach ($result as $key) {
           $post_id = $key->ID;
             ?>
              <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $key->post_title ?></td>
                  <td><?php echo $count = getTotalbyCoures($post_id,$querydate1,$querydate2); ?></td>
                  <td><?php echo $price = get_post_meta($post_id,'_lp_price',true); ?></td>
                  <td><?php echo 'บาท'; ?></td>
                  <td><?php echo $total = (getTotalbyCoures($post_id,$querydate1,$querydate2)*$price); ?></td>
              </tr>
              <?php
               $count_all = $count_all + $count;
               $sum = $sum + $total; 
               $i++;
           }
       ?>
         </tbody>
        </table>

        <?php 
        if($i<=1){
           echo '<div class="alert alert-danger" role="alert">ไม่พบข้อมูล</div>';
        }?>
     </div>
    </div><!-- wpbody-content -->
    </div>
     <script>
    var total = "<?php echo $sum ?>";
    var count = "<?php echo $count_all ?>";
    jQuery('.res-num').text(" "+(count)+" คอร์ส");
      if(total==""){
        jQuery('.res-money').text(" 0 บาท");
      }else{
        jQuery('.res-money').text(" "+total+" บาท");
      }

       jQuery(function(){
          jQuery('#date-start').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
          jQuery('#date-end').bootstrapMaterialDatePicker({ format : ' YYYY-MM-DD',time: false });
       })
       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });

       var url = "<?php echo $url ?>";
       jQuery('.view_report').click(function(event) {
        var date_start = jQuery('#date-start').val();
        var date_end = jQuery('#date-end').val();
        
        if(date_start =="" || date_end =="" ){
           alert('กรุณาใส่วันที่ให้ครบถ้วน');
        }else{
           window.location.href = url+'&date_start='+date_start+'&date_end='+date_end;
        }
       });
      
    </script>
   <?php 
}

function get_total_order($querydate1, $querydate2,$payment_met){
        global $wpdb;
        $result_total_order = $wpdb->get_results (
            "
                SELECT `id` FROM `wp_posts` 
                WHERE `post_status` = 'wc-completed' 
                AND `post_type` = 'shop_order' 
                AND `post_date` >= '$querydate1'
                AND `post_date` <= '$querydate2'
            "
         );

        foreach ($result_total_order as $val) {
			$payment_method = get_post_meta( $val->id,'_payment_method', true);
            if(!empty($payment_met)){
				 if($payment_method == $payment_met){
					   $order_id =$val->id;
					   $total_order++;
				 }
			}else{
				   $total_order++;
			}
		}

    if($total_order<1){
       $sum = 0;
    }else{
       $sum = $total_order;

    }
        	   
	    return $sum;
}

function get_total_price_order($querydate1, $querydate2,$payment_met){
        global $wpdb;
        $result_total_order = $wpdb->get_results (
            "
                SELECT `id` FROM `wp_posts` 
                WHERE `post_status` = 'wc-completed' 
                AND `post_type` = 'shop_order' 
                AND `post_date` >= '$querydate1'
                AND `post_date` <= '$querydate2'
            "
         );

        foreach ($result_total_order as $val) {
			 $payment_method = get_post_meta( $val->id,'_payment_method', true);
			 $order_total = get_post_meta( $val->id,'_order_total', true);
			 if(!empty($payment_met)){
				 if($payment_method == $payment_met){
					$total = $total + $order_total;  			
				 }
			 }else{
				$total = $total + $order_total;  	
			 }
		}

    if($total<1){
       $sum = 0;
    }else{
       $sum = $total;

    }
        	   
	 return $sum;
}

function get_product_name_in_order($order_id){
	global $wpdb;
        $result = $wpdb->get_results (
            "
                SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE `order_id` = '$order_id'
            "
         );
       
		$i = 0;
        foreach ($result as $val) {

		  if($i == 0){
			$coures_name = '<p class="sec">'.$val->order_item_name.'</p>';
		  }else{
			$coures_name = $coures_name.'<p class="sec">'.$val->order_item_name.'<p>';
		  }
		  $i++;
		}
	return $coures_name;
}

function get_product_amount_in_order($order_id){
	global $wpdb;
        $result = $wpdb->get_results (
            "
                SELECT `order_item_name` FROM `wp_learnpress_order_items` WHERE `order_id` = '$order_id'
            "
         );
        
		$i = 0;
        foreach ($result as $val) {
		  $total++;
		}
	return $total;
}

function getPaymentText($payment_method){
  if($payment_method == 'paypal'){
      $text = 'paypal';
  }else if($payment_method == '2c2p'){
      $text = '2c2p';
  }else if($payment_method == 'bacs'){
      $text = 'โอนเงินผ่านธนาคาร';
  }

  return $text;

}

?>

