<?php
/**
 * Template for displaying content of learning course
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$review_is_enable = thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' );
$student_list_enable = thim_plugin_active( 'learnpress-students-list/learnpress-students-list.php' );
?>
<?php do_action( 'learn_press_before_content_learning' );?>
<div class="course-learning-summary">
	<?php do_action( 'learn_press_content_learning_summary' ); ?>

</div>
<div id="course-learning">
        <div class="course-tabs">
            <div class="title-landing-cours"><h3><i class="fa fa-bookmark"></i> <?php esc_html_e( 'Description', 'eduma' ); ?></h3></div>
			<div class="tab-pane active" id="tab-course-description">
				<?php do_action( 'learn_press_begin_course_content_course_description' ); ?>
				    <div class="thim-course-content">
						<?php the_content(); ?>
					</div>
					<?php thim_course_info(); ?>
					<?php do_action( 'learn_press_end_course_content_course_description' ); ?>
				</div>
				<div class="title-landing-cours"><h3><i class="fa fa-cube"></i> <?php esc_html_e( 'Curriculum', 'eduma' ); ?></h3></div>
				<div class="tab-pane active" id="tab-course-curriculum">
					<?php learn_press_course_curriculum(); ?>
				</div>
                <?php 
				 $cover = get_post_meta( get_the_ID(), 'cover_image' );
		           if ( ! empty( $cover[0] ) ) {
		         ?>
				<div class="title-landing-cours"><h3><i class="fa fa-film" aria-hidden="true"></i> หน้าปก</h3></div>
				    <div class="cover-thumbnail"><?php echo $cover[0];?></div>
		        <?php }else{}?>
                <div class="title-landing-cours"><h3><i class="fa fa-commenting"></i> เสียงตอบรับจากคอร์สนี้</h3></div>
				<?php echo do_shortcode('[fbcomments  width="100%" count="off" num="3countmsg="wonderful comments!"]'); ?>
	    </div>
</div>
<?php do_action( 'learn_press_after_content_learning' );?>
