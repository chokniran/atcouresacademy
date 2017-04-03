<?php
   require_once('../../../wp-load.php');
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    $args = array(
        'post_type' => 'webinar',
        'date_query' => array(
            array(
              'year'  => $year,
              'month' => $month,
              'day'   => $day,
            ),   
          ),
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) : $the_query->the_post(); 
                echo $content = get_the_content();
            endwhile;
        }
?>