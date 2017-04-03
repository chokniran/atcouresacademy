<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package thim
 */
if ( !is_active_sidebar( 'sidebar_courses' ) ) {
	return;
}
$theme_options_data = get_theme_mods();
$sticky_sidebar     = ( !isset( $theme_options_data['thim_sticky_sidebar'] ) || $theme_options_data['thim_sticky_sidebar'] === true ) ? ' sticky-sidebar' : '';
?>

<div id="sidebar" class="widget-area col-sm-3<?php echo esc_attr( $sticky_sidebar ); ?>" role="complementary">
	<aside  class="widget widget_text">
	  <h4 class="widget-title"><?php esc_html_e( 'About Author', 'eduma' ); ?></h4>			
	  <div class="textwidget">
	     <?php echo do_shortcode('[about_author]'); ?>
	  </div>
	</aside>

	<aside  class="widget widget_text">
	  <h4 class="widget-title"><?php esc_html_e( 'Related Course', 'eduma' ); ?></h4>			
	  <div class="textwidget">
	     <?php echo do_shortcode('[related_courses]'); ?>
	  </div>
	</aside>
</div><!-- #secondary -->
