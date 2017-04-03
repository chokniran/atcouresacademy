<?php
/**
 * Template for displaying the price of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

if ( learn_press_is_enrolled_course() ) {
	return;
}

$is_required = $course->is_required_enroll();

?>
<div class="course-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <?php $soon = get_post_meta( $course->id, 'message_soon', true );  
      if(!empty($soon)){
        ?>
          <div class="value"><?php echo $soon;?></div>
        <?php 
      }else{
    ?>
	<?php if ( $course->is_free() || ! $is_required ) : ?>
		<div class="value free-course" itemprop="price" content="<?php esc_attr_e( 'Free', 'eduma' ); ?>">
			<?php esc_html_e( 'Free', 'eduma' ); ?>
		</div>
	<?php else: $price = learn_press_format_price( $course->get_price(), true ); ?>
          <?php $fullprice = get_post_meta( get_the_id(), 'full_price', true );
             
             if(!empty($fullprice)){
                 ?>
                  <div class="value sale_price" itemprop="price" content="<?php echo esc_attr( $price ); ?>">
                   		<?php echo esc_html( $price ); ?>
		          </div>
		          <div class="fullprice"><?php echo get_post_meta( get_the_id(), 'full_price', true );?><?php echo learn_press_get_currency_symbol(); ?></div>
                 <?php
             }else{
             	?>
                   <div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
                   	  <?php echo esc_html( $price ); ?>
		          </div>
                  <?php
             }
     ?>
	<?php endif; ?>
	<meta itemprop="priceCurrency" content="<?php echo learn_press_get_currency_symbol(); ?>" />
    <?php } ?>
</div> 