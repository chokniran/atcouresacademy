<?php 

add_action( 'admin_menu', 'create_menu_bank_report' );
    
    function create_menu_bank_report(){
       add_submenu_page( 
        'courses-report', 
        'Bank', 
        'Bank',
        'manage_options', 
        'bank-report',
        'bankReport');
    }

    function bankReport()
     {
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
  
    <div class="main_container">
        <div class="panel panel-success">
            <div class="panel-heading">
            <h3 class="panel-title">รายงานการสั่งซื้อคอร์ส <span class="label label-info">โอนเงิน</span>
                     <?php
                        if(empty($_GET['date_start'])){
                            echo 'วันที่ '.date("Y-m-d");
                        $querydate1 = date("Y-m-d").' 00:00:00';
                        }else{
                            echo 'จากวันที่ '.$_GET['date_start'];
                        $querydate1 = $_GET['date_start'].' 00:00:00';
                        }
                        ?>
                        <?php
                        if(empty($_GET['date_end'])){
                        //echo ' ถึงวันที่ '.date("Y-m-d");
                          $querydate2 = date("Y-m-d").' 23:59:59';
                        }else{
                           echo ' ถึงวันที่ '.$_GET['date_end'];
                            $querydate2 = $_GET['date_end'].' 23:59:59';
                        }
                        ?>
                </h3>
            </div>
            <div class="panel-body">
            <?php  
            global $wpdb;
            $SQL = "SELECT od.`ID`,od.`post_modified`,odt.`meta_key`,odt.`meta_value`
                                FROM `wp_postmeta` odt,`wp_posts` od
                                WHERE od.`ID` = odt.`post_id`
                                AND od.`post_type` = 'lpr_order'
                                AND od.`post_status` = 'lp-completed'
                                AND od.`post_modified` >= '$querydate1'
                                AND od.`post_modified` <= '$querydate2'
                                ORDER BY od.`ID` DESC";
            $results = $wpdb->get_results($SQL, OBJECT );
             
            ?>
              <div class="row">
                  <div class="col-md-6"> 
                  <span class="label label-success">จำนวนการสั่งซื้อ<span class="res-num"></span></span>
                     <span class="label label-primary">จำนวนเงินรวม<span class="res-money"></span></span>
                  </div>
                  <div class="col-md-6">
                    <div class="row-search">
                      <input type="text" id="date-start" name="date-start" class="form-pay" placeholder="จากวันที่">
                      <input type="text" id="date-end" name="date-end" class="form-pay" placeholder="ถึงวันที่">
                      <a href="javascript:void(0)" type="button" class="btn btn-primary view_report">ค้นหา</a>
                    </div>
                  </div>
              </div>
               <table class="table table-hover">
                   <thead> 
                      <tr> 
                         <th>ลำดับ</th> 
                         <th>เลขที่สั่งซื้อ</th> 
                         <th>วันที่ชำระเงิน</th> 
                         <th>ลูกค้า</th> 
                         <th>คอร์ส</th>
                         <th>จำนวนเงิน</th>
                      </tr> 
                  </thead>
                  <tbody> 
                    <tr>
                   <?php 
                  
                  $i=0;
                  foreach( $results as $result ) {
                  	 $payment = learn_press_payment_method_from_slug($result->ID);
                     if($payment == "โอนเงินเข้าบัญชีธนาคาร" ){
                     $key = $result->meta_key;
                     $value = $result->meta_value;
                      if($key == '_learn_press_customer_id'){
                          $i++;
                          $user_id = $value;
                          $first_name = 'first_name';
                          $last_name = 'last_name';
                          $single = true;
                          $last_name_data = get_user_meta( $user_id, $first_name, $single );
                          $first_name_data = get_user_meta( $user_id, $last_name, $single );
                   ?>
                    
                         <td><?php echo $i ?></td>
                         <td><?php echo $result->ID ?></td>
                         <td>
                          <?php 
                              $date = getPaymentDate($result->ID);
                              if(!empty($date)){
                                   echo getPaymentDate($result->ID);
                               }else{
                                   echo 'ไม่มีการแจ้งผ่านระบบ';
                               } ?>
                         </td>
                         <td><?php echo $first_name_data .' '.$last_name_data ?></td>
                  <?php 
                    
                    }

                    if($key == '_learn_press_order_items'){
                                     
                        $str = $value;
                        $data = unserialize($str);
                        echo '<td>'.$data->description.'</td>';
                        echo '<td>'.$data->total.'</td>';
                        echo '</tr>';
                        $sum = $sum+$data->total;    
                      }
                     }
                    }
                  ?>
                  </tbody>
                </table>

                <?php if(empty($sum)){
                  echo '<span class="label label-danger">ไม่พบการสั่งซื้อคอร์ส</span>';
                }?>

                 <script  type="text/javascript">
                    var total = "<?php echo $sum ?>";
                    var count = "<?php echo $i ?>";
                    jQuery('.res-num').text(" "+count+" ครั้ง");
                    if(total==""){
                      jQuery('.res-money').text(" 0 บาท");
                    }else{
                       jQuery('.res-money').text(" "+total+" บาท");
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
    <?php $url = get_site_url().'/wp-admin/admin.php?page=bank-report/'; ?>
     <script>
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
      
    </script>
      <?php
       
     }

 ?>