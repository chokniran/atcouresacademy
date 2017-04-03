<?php 

add_action( 'admin_menu', 'create_menu_summary_report' );
    
    function create_menu_summary_report(){
       add_submenu_page( 
        'courses-report', 
        'Summary', 
        'Summary',
        'manage_options', 
        'summary-report',
        'summaryReport');
    }

    function summaryReport()
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
            <h3 class="panel-title"><span class="label label-info">ยอดขายของแต่ละคอร์ส</span> 
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
                         <th>รหัสคอร์ส</th> 
                         <th>รายการ</th> 
                         <th>จำนวนสี่งซื้อ</th> 
                         <th>ราคา</th> 
                         <th>ยอดขาย</th>
                      </tr> 
                  </thead>
                  <tbody> 
               
                  <?php 
                 
                  $arr_coures = array();
                  foreach( $results as $result ) {
	 
                     $key = $result->meta_key;
                     $value = $result->meta_value;
                     $detail = get_post_meta($result->ID, '_learn_press_order_items' );      
                     $coures = $detail[0]->products;
                     $keyid = array_keys($coures);
                     $couresid =  $keyid[0];
                   
                    if($key == '_learn_press_order_items'){    
                        array_push($arr_coures,$couresid);
                     }
                   }
                  ?>
                <?php
             
                $list_Courres = array_count_values($arr_coures);
                 $i = 0;
                foreach ($list_Courres as $key => $value) {            	
                   	$price = get_post_meta($key,'_lpr_course_price', true );
                	      if($key !='8226'){
                        echo '<tr>';  
                        $i++;
                        echo '<td>'.$i.'</td>';
                        echo '<td>'.$key.'</td>';
                        echo '<td>'.get_the_title($key).'</td>';
                        echo '<td>'.$value.'</td>';
                        echo '<td>'.$price.'</td>';
                        echo '<td>'.($price*$value).'</td>';
                        echo '</tr>';
                        $sum = $sum+($price*$value); 
                      }
                }

			    ?>
			      </tbody>
                </table>
                <?php if($i == 0){
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
    <?php $url = get_site_url().'/wp-admin/admin.php?page=summary-report/'; ?>
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