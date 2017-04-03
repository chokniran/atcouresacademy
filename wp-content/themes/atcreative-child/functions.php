<?php
function thim_child_enqueue_styles() {
	if ( is_multisite() ) {
		wp_enqueue_style( 'thim-child-style', get_stylesheet_uri() );
	} else {
		wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'my_child_styles', get_stylesheet_directory_uri().'/assets/css/custom-themes.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 100 );

function get_related_courses($atts) {
    ?>
    <div class="related_courses_sidebar">
        <?php thim_related_courses(); ?>
    </div>
    <?php
}

add_shortcode('related_courses', 'get_related_courses');

function about_author($atts) {
    ?>
    <div class="about_author_sidebar">
        <div class="container-author_image">
    <?php learn_press_course_instructor(); ?>
        </div>
        <div class="container-author">
            <div class="content-author"><?php echo get_the_author_meta('description'); ?></div>
        </div>
    </div>
    <?php
}

add_shortcode('about_author', 'about_author');

function update_wc_order_status($posted) {
    $order_id = isset($posted['invoice']) ? str_replace('WC-', '', $posted['invoice']) : '';
    if (!empty($order_id)) {
        $order = new WC_Order($order_id);
        $order->update_status('completed');
    }
}

add_action('paypal_ipn_for_wordpress_payment_status_completed', 'update_wc_order_status', 10, 1);

add_action('user_register', 'myplugin_user_register');

function myplugin_user_register($user_id) {
    if (!empty($_POST['lineid'])) {
        update_user_meta($user_id, 'lineid', trim($_POST['lineid']));
    }

    if (!empty($_POST['billing_first_name'])) {
        update_user_meta($user_id, 'billing_first_name', trim($_POST['billing_first_name']));
    }

    if (!empty($_POST['billing_last_name'])) {
        update_user_meta($user_id, 'billing_last_name', trim($_POST['billing_last_name']));
    }
}

function mysite_woocommerce_order_status_completed($order_id) {
   $learn_press_order_id = get_post_meta( $order_id, '_learn_press_order_id', true );
   $customer_user = get_post_meta( $order_id, '_customer_user', true );
   global $wpdb;
   $order_item = $wpdb->get_results ("SELECT `order_item_id` FROM `wp_learnpress_order_items` WHERE `order_id` = '$learn_press_order_id'");
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
       
        foreach ($coures_res as $coures_val) {
            $coures_id = $coures_val->meta_value;                 
        }
    } 
   $listcoures = get_post_meta( $coures_id, 'courses_promotion', true );
   if(!empty($listcoures[0])){
   	  foreach ($listcoures as $cid) {
   	  	 crateCouresOrder( $cid, '0', $customer_user);
   	  }

   }else{}
}

add_action('woocommerce_order_status_completed', 'mysite_woocommerce_order_status_completed');

// create posttype gallery
    function create_post_types_webinar() {
     register_post_type( 'Webinar',array(            
          'labels' => array(                
                  'name' => __( 'Webinar', 'Wordpress Gallery' ),                
                  'singular_name' => __( 'webinar', 'Wordpress Gallery' ),                
                  'add_new' => __( 'Add New Webinar', 'Wordpress Gallery' ),                
                  'add_new_item' => __( 'Add New Webinar', 'Wordpress Gallery' ),                
                  'edit' => __( 'Edit', 'Webinar' ),                
                  'edit_item' => __( 'Edit Webinar', 'Wordpress Gallery' ),                
                  'new_item' => __( 'New Webinar', 'Wordpress Gallery' ),                
                  'view' => __( 'View Webinar', 'Wordpress Gallery' ),                
                  'view_item' => __( 'View Webinar', 'Wordpress Gallery' ),                
                  'search_items' => __( 'Search Webinar', 'Wordpress Gallery' ),                
                  'not_found' => __( 'No Webinar', 'Wordpress Gallery' ),                
                  'not_found_in_trash' => __( 'No Webinar in the Trash', 'Wordpress Gallery' ),),            
                  'hierarchical' => false,'public' => true,            
                                          'menu_position' => 10,     
                                          'menu_icon' => get_template_directory_uri().'/images/webminar.png',                 
                                          'has_archive' => 'webinar',            
                                          'rewrite' => array('slug' => 'webinar'),                  
                                          'description' => "Create Webinar"
           )); 
     }

add_action( 'init', 'create_post_types_webinar' );
?>