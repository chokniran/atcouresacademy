<?php
/*
Plugin Name: Payment Report
Version: 1.0
Author: chokniran
License: GPL2
Description: Report Coures Online.
*/
include('courses-report.php');
if(!class_exists('Payment Report'))
{
    class paymentReport
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
        } // END public function __construct
    
        /**
         * Activate the plugin
         */
        public static function activate()
        {
            
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate
    } 
} 
if(class_exists('paymentReport'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Seed_Social', 'activate'));
    register_deactivation_hook(__FILE__, array('Seed_Social', 'deactivate'));
    add_shortcode( 'payment_form', 'payment_form' );
    add_action( 'admin_menu', 'create_menu_payment' );
    add_shortcode( 'check_order', 'check_order' );
    
    function check_order($attb){
        $button_text = $attb['button_text'];
        $code = $attb['success_message']; 
        $current_user = wp_get_current_user();
  
        ?>
          <form id="payment_check" method="get"">
              <div class="row">
              <div class="col-lg-6">
                <div class="input-group">
                  <input type="text" id="customer_order_id" class="form-control" placeholder="ใส่เลขที่สั่งซื้อคอร์ส">
                  <input type="hidden" id="user_email" val="<?php echo $current_user->user_email ?>">
                  <span class="input-group-btn">
                    <button class="btn btn-success" id="btn_get_oreder" type="button"><?php echo $button_text ?></button>
                  </span>
                </div>
              </div>
            </div>
          <div class="alert alert-success found" style="display:none">
              <strong><?php echo $code ?></strong>
          </div>

          <div class="content_webminar"></div>

          <div class="alert alert-danger not_found" style="display:none">
              <strong>ผิดพลาด!</strong> ไม่พบการสั่งซื้อของคุณที่ชำระเงินแล้ว
          </div>
          <div class="load_icon"></div>
          </form>

          <script type="text/javascript" >
             var load = '<div id="floatingCirclesG">'+
                        '<div class="f_circleG" id="frotateG_01"></div>'+
                        '<div class="f_circleG" id="frotateG_02"></div>'+
                        '<div class="f_circleG" id="frotateG_03"></div>'+
                        '<div class="f_circleG" id="frotateG_04"></div>'+
                        '<div class="f_circleG" id="frotateG_05"></div>'+
                        '<div class="f_circleG" id="frotateG_06"></div>'+
                        '<div class="f_circleG" id="frotateG_07"></div>'+
                        '<div class="f_circleG" id="frotateG_08"></div>'+
                  '</div>';

             jQuery('#btn_get_oreder').click(function(event) {
                  customer_order_id = jQuery('#customer_order_id').val();
                  couresid = jQuery('#coures_id').val();
                  user_email = "<?php echo $current_user->user_email ?>";
                  jQuery('.load_icon').html(load);
                  jQuery.ajax({
                         type: "POST",
                         url: "<?php echo plugins_url('check_order2.php', __FILE__); ?>",    
                         cache: false,             
                         data: {orderid:customer_order_id, email:user_email, couresid:couresid},
                         success: function (data) {
                          jQuery('.load_icon').css('display','none');
                          var result = parseInt(data);
                          if(result == '1'){
                            jQuery('.found').css('display','block');
                            jQuery('.content_webminar').load( "<?php echo plugins_url('load_content.php', __FILE__); ?>" );
                            jQuery('.not_found').css('display','none');
                            jQuery('.content_webminar').css('display','block');
          
                          }else{
                            jQuery('.found').css('display','none');
                            jQuery('.not_found').css('display','block');
                            jQuery('.content_webminar').css('display','none');

                          } 

                        }
                 });
                
             });
          </script>
        <?php
    }

    function create_menu_payment()
    {
        add_menu_page(
            'Courses Payment',     
            'Courses Payment',     
            'manage_options',   
            'courses-payment',    
            'randerLayout' 
        );
    }

    function payment_form() {
       $url = get_permalink();
       ?>
       <link href="<?php echo plugins_url('dist/css/bootstrap.min.css', __FILE__) ?>" rel="stylesheet">
       <link href="<?php echo plugins_url('dist/css/bootstrap-theme.min.css', __FILE__) ?>" rel="stylesheet">
       <link href="<?php echo plugins_url('dist/css/custom.css', __FILE__) ?>" rel="stylesheet">
       <script src="<?php echo plugins_url('jquery-ui/jquery-1.12.4.js', __FILE__); ?>"></script>
       <script src="<?php echo plugins_url('dist/js/bootstrap.min.js', __FILE__); ?>"></script>
       <link href="<?php echo plugins_url('datepicker/css/bootstrap-material-datetimepicker.css', __FILE__) ?>" rel="stylesheet">
       <link rel="stylesheet" href="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/css/material.min.css" />
       <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       <script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
       <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
       <script src="<?php echo plugins_url('datepicker/js/bootstrap-material-datetimepicker.js', __FILE__); ?>"></script>
       <script src="<?php echo plugins_url('datepicker/DateTimePicker.js', __FILE__); ?>"></script>
       <link href="<?php echo plugins_url('datepicker/DateTimePicker.css', __FILE__) ?>" rel="stylesheet">
       

      <script>
       jQuery(function(){
          jQuery('#date-format').bootstrapMaterialDatePicker({ format : ' DD/MM/YYYY',time: false });
          jQuery("#dtBox").DateTimePicker({
            titleContentTime: "ระบุเวลา",
            setButtonContent: "ตกลง",
            clearButtonContent: "ยกเลิก",
          });
       })

    </script>

       <div class="panal-payment">
        <h1>ฟอร์มแจ้งชำระเงิน</h1>
        <div class="payment-form_">
            <div style="display:none" class="alert alert-success">
               <strong>ส่งข้อความแล้ว</strong> เราได้รับข้อมูลแจ้งชำระเงินเรียบร้อยแล้วทางทีมงานจะเร่งตรวจสอบและเปิดให้เข้าดูได้อย่างเร็วที่สุด
          </div>
          <div style="display:none" class="alert alert-danger fade in err-name">
            
             <strong>ผิดพลาด!</strong> ชื่อ-สกุล จำเป็นต้องกรอก
          </div>

          <div style="display:none" class="alert alert-danger fade in err-order">
            
             <strong>ผิดพลาด!</strong> เลขที่สั่งซื้อ นี้ไม่ใช่ของคุณ กรุณาตรวจสอบข้อมูลอีเมล์และเลขที่สั่งซื้อใหม่อีกครั้ง
          </div>

          <div style="display:none" class="alert alert-danger fade in err-email">
            
             <strong>ผิดพลาด!</strong> อีเมล์ จำเป็นต้องกรอก
          </div>

          <div style="display:none" class="alert alert-danger fade in err-email-format">
             
             <strong>ผิดพลาด!</strong> รูปแบบอีเมล์ไม่ถูกต้อง
          </div>

          <div style="display:none" class="alert alert-danger fade in err-order_id">
             
             <strong>ผิดพลาด!</strong> เลขที่สั่งซื้อ จำเป็นต้องกรอก
          </div>

          <div style="display:none" class="alert alert-danger fade in err-bank">
             
             <strong>ผิดพลาด!</strong> กรุณาเลือกธนาคารที่คุณชำระเงิน
          </div>

          <div style="display:none" class="alert alert-danger fade in err-order_id_format">
             
             <strong>ผิดพลาด!</strong> เลขที่สั่งซื้อ ต้องเป็นตัวเลขเท่านั้น
          </div>

          <div style="display:none" class="alert alert-danger fade in err-amount">
             <strong>ผิดพลาด!</strong> จำนวนเงิน จำเป็นต้องกรอก
          </div>

           <div style="display:none" class="alert alert-danger fade in err-order-duplicat">
             <strong>ผิดพลาด!</strong> คุณได้แจ้งชำระเงินไปแล้ว
          </div>

          <div style="display:none" class="alert alert-danger fade in err-date">
            
             <strong>ผิดพลาด!</strong> วันที่โอนเงิน จำเป็นต้องกรอก
          </div>

           <div style="display:none" class="alert alert-danger fade in err-time">
            
             <strong>ผิดพลาด!</strong> เวลาที่โอนเงิน จำเป็นต้องกรอก
          </div>
          <div style="display:none" class="alert alert-danger fade in err-tel">
            
             <strong>ผิดพลาด!</strong> เบอร์โทร จำเป็นต้องกรอก
          </div>
           <form action="<?php echo $url ?>" method="post" accept-charset="utf-8" id="fm-payment">
               <input class="form-pay" type="text" id="customer_name" placeholder="ขื่อ-นามสกุล">
               <input class="form-pay" type="email" id="customer_email" placeholder="อีเมล์">
               <input class="form-pay" type="tel" id="customer_tel" placeholder="เบอร์โทร">
               <input class="form-pay" type="text" id="customer_order_id" placeholder="เลขที่สั่งซื้อ">
               <input class="form-pay" type="text" id="customer_amount" placeholder="จำนวนเงิน">
               <input type="text" id="date-format" class="form-pay" placeholder="วันที่โอนเงิน">  
                <select class="form-pay" id="bank">
                   <option value="">
                       กดเพื่อเลือกธนาคารที่ใช้โอนเงิน
                   </option>
                   <?php echo get_custom('bank_account'); ?>
               </select>
               <textarea id="note" placeholder="หมายเหตุ"></textarea>
               <label>สลิป</label>
               <input type="file" id="file">
               <a class="btn btn-success payment-submit" >ส่งข้อมูล</a> 
               <div id="circleG" style="display:none;">
                  <div id="circleG_1" class="circleG"></div>
                  <div id="circleG_2" class="circleG"></div>
                  <div id="circleG_3" class="circleG"></div>
                </div>
           </form>
        </div>
       </div>
       <?php 
     
     $get_order_id = $_GET[order];
     if(!empty($get_order_id)){
         $get_total = $_GET['total'];
         $Customerfirst_name = get_post_meta( $get_order_id, '_billing_first_name', true);
         $Customerlast_name = get_post_meta( $get_order_id, '_billing_last_name', true);
         $fullName = $Customerfirst_name.' '.$Customerlast_name;
         $CustomerEmail = get_post_meta( $get_order_id, '_billing_email', true);
         $CustomerPhone = get_post_meta( $get_order_id, '_billing_phone', true);
    }else if(!empty(get_current_user_id())){
         $current_user = get_current_user_id();
         $Customerfirst_name = get_user_meta( $current_user, 'billing_first_name', true);
         $Customerlast_name = get_user_meta( $current_user, 'billing_last_name', true);
         $fullName = $Customerfirst_name.' '.$Customerlast_name;
         $CustomerEmail = get_user_meta( $current_user, 'billing_email', true);
         $CustomerPhone = get_user_meta( $current_user, 'billing_phone', true);
    }else{
         $Customerfirst_name = '';
         $Customerlast_name = '';
         $fullName = '';
         $CustomerEmail = '';
         $CustomerPhone = '';

    }


       ?>
         <script>

          function validateEmail(email) {
              var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
          }
          function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); }

          jQuery('.payment-submit').click(function(event) {
             var customer_name = $('#customer_name').val();
             var customer_email = $('#customer_email').val();
             var customer_order_id = $('#customer_order_id').val();
             var customer_amount = $('#customer_amount').val();
             var customer_tel = $('#customer_tel').val();
             var date = $('#date-format').val();
             var time = '00:00';
             var bank = $('#bank').val();
             var file = $('#file').val();
             var note = $('#note').val();
             var day = date.substring(1, 3);
             var month = date.substring(4, 6);
             var year = date.substring(7, 11);
             var datetime = year+'-'+month+'-'+day+' '+time+':00';
 
             if(customer_name == ""){
                 jQuery('.err-name').css('display', 'block');
             }else{
                 jQuery('.err-name').css('display', 'none');
             }

             if(customer_email == ""){
                  jQuery('.err-email').css('display', 'block');
             }else if(validateEmail(customer_email) == false){
                  jQuery('.err-email-format').css('display', 'block');
                  jQuery('.err-email').css('display', 'none');
             }else{
                  jQuery('.err-email-format').css('display', 'none');
                  jQuery('.err-email').css('display', 'none');
             }

             if(customer_order_id == ""){
                  jQuery('.err-order_id').css('display', 'block');
             }else if(isNumber (customer_order_id) == false){
                  jQuery('.err-order_id').css('display', 'none');
                  jQuery('.err-order_id_format').css('display', 'block');
             }else{
                 jQuery('.err-order_id').css('display', 'none');
                 jQuery('.err-order_id_format').css('display', 'none');
             }

             if(date == ""){
                 jQuery('.err-date').css('display', 'block');
             }else{
                 jQuery('.err-date').css('display', 'none');
             }

             if(time == ""){
                 jQuery('.err-time').css('display', 'block');
             }else{
                 jQuery('.err-time').css('display', 'none');
             }

             if(customer_tel == ""){
                 jQuery('.err-tel').css('display', 'block');
             }else{
                 jQuery('.err-tel').css('display', 'none');
             }

             if(bank == ""){
                 jQuery('.err-bank').css('display', 'block');
             }else{
                 jQuery('.err-bank').css('display', 'none');
             }

             if( customer_amount == ""){
                 jQuery('.err-amount').css('display', 'block');
             }else{
                 jQuery('.err-amount').css('display', 'none');
             }
    
             if(customer_name != "" && customer_tel != "" && customer_email != "" && time != "" && bank != ""  && validateEmail(customer_email) != false && customer_order_id != "" && isNumber (customer_order_id) != false && date != ""  &&  
             customer_amount != "" ){

             jQuery('#circleG').css('display', 'block');
                    $.ajax({
                      type: "POST",
                      url: "<?php echo plugins_url('check_order.php', __FILE__); ?>",
                      cache: false,
                      data: {orderid:customer_order_id,email:customer_email},
                      success: function(data){
                         console.log(data)
                         var result = parseInt(data);
                         jQuery('#circleG').css('display', 'none');
                         jQuery('.alert-success').css('display', 'none');
                         jQuery('.err-order-duplicat').css('display', 'none');
                          jQuery('.err-order').css('display', 'none');
                          if(result == 1){
                            
                                  jQuery('.err-order').css('display', 'none');
                                  var form = $('#fm-payment')[0]; 
                                  var formData = new FormData(form);
                                  formData.append('file', $('#file')[0].files[0]);
                                  formData.append('name', customer_name);
                                  formData.append('email', customer_email);
                                  formData.append('amount', customer_amount);
                                  formData.append('orderid', customer_order_id);
                                  formData.append('date', datetime);
                                  formData.append('tel', customer_tel);
                                  formData.append('bank', bank);   
                                  formData.append('note', note);    
                                    jQuery('#circleG').css('display', 'block');
                                          $.ajax({
                                              type: "POST",
                                              url: "<?php echo plugins_url('saveData.php', __FILE__); ?>",
                                              contentType: false,       
                                              cache: false,             
                                              processData:false, 
                                              data: formData,
                                              success: function (data) {
                                                 console.log(data);
                                                 jQuery('#circleG').css('display', 'none');
                                                 jQuery('.alert-success').css('display', 'block');
                                                 jQuery('#fm-payment')[0].reset();
                                                 jQuery('.err-order-duplicat').css('display', 'none');
                                              }
                                        });


                         }else{
                            jQuery('.err-order').css('display', 'block');
                         }  
                      }
                   });
             }else{
               jQuery('.alert-success').css('display', 'none');
             }
          });
          
       </script>
       <script type="text/javascript">
  
    jQuery( document ).ready(function( $ ) {
      var name = "<?php echo $fullName ?>";
      var email = "<?php echo $CustomerEmail ?>";
      var orderid = "<?php echo $get_order_id ?>";
      var total = "<?php echo $get_total ?>";
      var phone = "<?php echo $CustomerPhone ?>";
      jQuery('#customer_name').val(name);
      jQuery('#customer_email').val(email);
      jQuery('#customer_order_id').val(orderid);
      jQuery('#customer_amount').val(total);
      jQuery('#customer_tel').val(phone);
      
      });

        </script>
       <?php
    }

    function randerLayout()
    {
         
    ?>
     
    <link href="<?php echo plugins_url('dist/css/bootstrap.min.css', __FILE__) ?>" rel="stylesheet">
    <link href="<?php echo plugins_url('dist/css/bootstrap-theme.min.css', __FILE__) ?>" rel="stylesheet">
    <link href="<?php echo plugins_url('dist/css/custom.css', __FILE__) ?>" rel="stylesheet">
    <link href="<?php echo plugins_url('font-awesome-4.7.0/css/font-awesome.min.css', __FILE__) ?>" rel="stylesheet">
    <script src="<?php echo plugins_url('dist/js/bootstrap.min.js', __FILE__); ?>"></script>
    <script src="<?php echo plugins_url('jquery-ui/jquery-1.12.4.js', __FILE__); ?>"></script>
    <div class="main_container">
    <div class="row">
      <div class="col-lg-6">
        <div class="input-group">
          <input type="text" class="form-control" id="keyword" placeholder="กรุณาระบุคำค้น" value="<?php echo $_GET['keyword'] ?>">
          <span class="input-group-btn">
            <button onclick="search()" class="btn btn-primary" id="search" type="button">ค้นหา</button>
          </span>
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-6">
        <button onclick="viewall()" class="btn btn-info" id="search" type="button">แสดงทั้งหมด</button>
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลการชำระเงิน</h3>
            </div>
            <div class="panel-body">
            <?php  
            $perpage = 10;
            if($_GET['datapage'] > 1 ){
                $num = ($_GET['datapage'] * $perpage)-($perpage-1);
                $i = 1;
                $number = $i+$num-1;
            }else{
                $num = 1; 
                $i = 1;
                $number = $i;
            }

            if($num>1){
               $st = $num-1;
               $en = ",".$perpage;
            }else{
               $st = $perpage;
            }

            $sql = $sql  ." limit ".$st."".$en;
            $key = $_GET['keyword'];
            global $wpdb;
            $SQLTotal = "SELECT * FROM `wp_payment` 
            WHERE `order_id` LIKE '%".$key."%' OR `customer_email` LIKE '%".$key."%' OR `customer_name` LIKE '%".$key."%' 
            ORDER BY DATE DESC ";

            $resultsTotal = $wpdb->get_results($SQLTotal, OBJECT );
            $SQL = "SELECT * FROM `wp_payment` 
            WHERE `order_id` LIKE '%".$key."%' OR `customer_email` LIKE '%".$key."%' OR `customer_name` LIKE '%".$key."%' 
            ORDER BY DATE DESC ".$sql;
            $results = $wpdb->get_results($SQL, OBJECT );

            ?>
                
               <table class="table table-hover">
                   <thead> 
                      <tr> 
                         <th width="100">ลำดับ</th> 
                         <th width="100">ชื่อ-สกุล</th> 
                         <th width="100">อีเมล์</th> 
                         <th width="100">เลขที่สั่งซื้อ</th> 
                         <th width="100">จำนวนเงิน</th> 
                         <th width="200">วันที่โอนเงิน</th> 
                         <th width="100">ธนาคาร</th> 
                         <th width="100" >หมายเหตุ</th>
                         <th width="100" >เบอร์โทร</th>
						             <th width="100">สลิบ</th>
                         <th>สถานะ</th>
                         <th></th>
                      </tr> 
                  </thead>
                  <tbody> 

                   <?php 
                   function get_order_details($id){
                    global $woocommerce;
                    $order = get_order( $id );

                }
                  
                  foreach( $results as $result ) {
                   ?>
                       <tr id="<?php echo 'row-'.$result->payment_id ?>"> 
                         <td><?php echo $number ?></td>
                         <td><?php echo $result->customer_name ?></td>
                         <td><?php echo $result->customer_email ?></td>
                         <td><a target="blank_" href="<?php echo get_site_url().'/wp-admin/post.php?post='.$result->order_id.'&action=edit'?>"><?php echo $result->order_id ?></a></td>
                         <td><?php echo $result->amount ?></td>
                         <td><?php echo $result->date ?></td>
                         <td><?php echo $result->bank ?></td>
                         <td>

                            <?php if(empty($result->note)){
                                echo '-';
                            }else{
                              echo $result->note;
                            } ?>
                             
                         </td>
                          <td><?php echo $result->tel ?></td>
                         <td>
                         <?php if(($result->slip) == 'no'){
                          
                          ?>
                           <img width="100" src="<?php echo plugins_url('image/No-Image.jpg', __FILE__); ?>">
                          <?php

                         }else{
                          ?>
                             <a href="<?php echo get_site_url().'/wp-content/uploads/payment/'.$result->slip?>" target="blank_"><img width="100" src="<?php echo get_site_url().'/wp-content/uploads/payment/'.$result->slip?>">
                          <?php 

                            }
                         ?>
                         </td>
                         <td><?php 

                           $staus = get_post_status( $result->order_id );
       
                            if($staus == 'wc-completed' || $staus == 'lp-completed'){
                              ?>
                                <a href="javascript:void(0)" id="<?php echo $result->order_id ?>" class="btn btn-success">completed</a>
                              <?php
                               
                            } else if($staus != 'wc-completed' || $staus != 'lp-completed'){
                              ?>
                               <a href="javascript:void(0)"  id="<?php echo $result->order_id ?>" onclick='update_status(id="<?php echo $result->order_id ?>",staus="<?php echo 'pending'?>" ,email="<?php echo $result->customer_email ?> ",name="<?php echo $result->customer_name ?>")' value="<?php echo $result->order_id ?>" class="btn btn-warning">pending 
                               <div style="display:none" id="floatingCirclesG">
                                  <div class="f_circleG" id="frotateG_01"></div>
                                  <div class="f_circleG" id="frotateG_02"></div>
                                  <div class="f_circleG" id="frotateG_03"></div>
                                  <div class="f_circleG" id="frotateG_04"></div>
                                  <div class="f_circleG" id="frotateG_05"></div>
                                  <div class="f_circleG" id="frotateG_06"></div>
                                  <div class="f_circleG" id="frotateG_07"></div>
                                  <div class="f_circleG" id="frotateG_08"></div>
                                 </div></a>
                              <?php
                            }

                         ?></td>
                         <td>
                           <a href="javascript:void(0)"  onclick='deletePayment(id="<?php echo $result->payment_id ?>",oid="<?php echo $result->order_id ?>")' class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                         </td>
                       </tr>
                  <?php 
                    $number++;
                    }
                  ?>
                  </tbody>
                </table>
        <?php
        if(count($resultsTotal)<1){
           echo '<p>ไม่พบรายการ</p>';
        }

        if(count($resultsTotal)>10){
        $curen_url = get_site_url().'/wp-admin/admin.php?page=courses-payment/';
        $j = 0;
        if (isset($_GET['datapage'])) {
             $page = $_GET['datapage'];
        } else {
          $page = 1;
        }
    
        $total =count($resultsTotal);
        $total_page = ceil($total / $perpage);
        if($page > 1 ){
          $num = ($perpage*($page-1))+1;
        }else{
          $num = 1; 
        }
        $start = ($num-1);
          $condition = (($num-1)+$perpage)-1;
        if($condition>$total){
          $dataToal = $total-1;
        }else{
          $dataToal = $condition;
        }
    ?>
     <ul class="pagination">
         <?php 
            if(!empty($_GET['datapage']) && $_GET['datapage']!=1){
         ?>
          <li><a href="<?php echo $curen_url.'/&datapage='.($_GET['datapage']-1).'&keyword='.$key;?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
          <?php }?>
           <?php 
           
           if(empty($_GET['datapage'])){
              $curpage = 1;
           }else{
              $curpage = $_GET['datapage'];
           }
           if($total_page<7){
               for($i=1;$i<=$total_page;$i++){ 
                 
                 if($curpage==$i ){
                  ?>
                    <li class="active"><a href="javascript:void(0)"><?php echo $i; ?></a></li>
                  <?php
                 }else if(1 == $i && empty($curpage)){
                  ?>
                      <li class="active"><a href="javascript:void(0)"><?php echo $i; ?></a></li>
                    <?php
                 }else{
                   ?>
                     <li><a href="<?php echo $curen_url.'/&datapage='.$i.'&keyword='.$key;?>"><?php echo $i; ?></a></li>
                   <?php
                 }
               }
         }else{
              if($curpage>2){
                    ?>
                      <li><a href="<?php echo $curen_url.'/&datapage=1&keyword='.$key;?>"><?php echo '1'; ?></a></li>
                      <li><a href="javcscript:void(0)">...</a></li>
                  <?php
              }

             for($i=1;$i<=$total_page;$i++){ 
                 if( $i== ($curpage)-1 ||  $i == ($curpage) ||  $i == ($curpage)+1 ){
                  if($curpage==$i ){
                     ?>
                      <li class="active"><a href="javascript:void(0)"><?php echo $i; ?></a></li>
                    <?php
                 }else{
                    ?>
                     <li><a href="<?php echo $curen_url.'/&datapage='.$i.'&keyword='.$key;?>"><?php echo $i; ?></a></li>
                   <?php
                 } 
              }              
          }
          if($curpage<($total_page-1)){
                    ?>
                      <li><a href="javcscript:void(0)">...</a></li>
                      <li><a href="<?php echo $curen_url.'/&datapage='.$total_page.'&keyword='.$key ;?>"><?php echo $total_page; ?></a></li>
                  <?php
              }
          } 
           ?>
           <?php if($curpage < $total_page){?>
            <li><a href="<?php echo $curen_url.'/&datapage='.($curpage+1).'&keyword='.$key;?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
          <?php } ?>
        </ul>
        <?php }?>
                
                 <script  type="text/javascript">
                    function viewall(){
                      var url = "<?php echo get_site_url().'/wp-admin/admin.php?page=courses-payment/&keyword=' ?>";
                      location.href = url;
                    }

                    function search(){
                      var keyword = jQuery("#keyword").val();
                      var url = "<?php echo get_site_url().'/wp-admin/admin.php?page=courses-payment/&keyword=' ?>";
                      location.href = url+keyword;
                    }

                    function deletePayment(orderid,oid){
                        var r = confirm("ยืนยันการลบการแจ้งชำระเงินเลขที่ "+oid);
                        if (r == true) {
                            $.ajax({
                            type: "POST",
                            url: "<?php echo plugins_url('delete_order.php', __FILE__); ?>",    
                            data: {orderid:orderid },
                            success: function (res) {
                              console.log(res);
                              jQuery(res).remove();
                           }
                          })
                          
                        } else {
                           
                        }
                    }

                    function update_status(orderid,status,email,name){
                     
                      jQuery('#'+orderid+' #floatingCirclesG').css( "display", "block" );
                      $.ajax({
                            type: "POST",
                            url: "<?php echo plugins_url('update_order.php', __FILE__); ?>",    
                            data: {orderid:orderid, status:status, email:email, name:name },
                            success: function (res) {
                              var className = jQuery(res).attr('class'); 
                              
                              if(className == 'btn btn-success'){
                                 jQuery('#'+orderid+' #floatingCirclesG').css( "display", "none" );
                                 jQuery(res).removeClass( "btn-success" );
                                 jQuery(res).addClass( "btn-warning" );
                                 jQuery(res).text( "pending" );
                               
                              }else if(className == 'btn btn-warning'){
                               jQuery('#'+orderid+' #floatingCirclesG').css( "display", "none" );
                                 jQuery(res).removeClass( "btn-warning" );
                                 jQuery(res).addClass( "btn-success" );
                                 jQuery(res).text( "completed" );
                              
                            }
                           }
                       })
                    }
                </script> 
            </div>
        </div>
    </div>
      <?php
       
    }
}

    