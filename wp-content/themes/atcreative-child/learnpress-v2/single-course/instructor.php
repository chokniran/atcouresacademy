<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

?>

<div class="course-author" itemscope itemtype="http://schema.org/Person">
	<div class="author-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?></div>
<div class="author-contain">
	<div class="value" itemprop="name">
			<?php
			$user_data   = get_userdata( $course->post->post_author );
			$author_name = '';
			if ( $user_data ) {
				if( !empty( $user_data->display_name ) ) {
					$author_name = $user_data->display_name;
				}else{
					$author_name = $user_data->user_login;
				}
			}
			echo $author_name;
			?>
	</div>
</div>
</div>