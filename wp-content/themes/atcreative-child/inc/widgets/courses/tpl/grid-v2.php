<?php
global $post;

$limit             = $instance['limit'];
$columns           = $instance['grid-options']['columns'];
$view_all_course   = ( $instance['view_all_courses'] && '' != $instance['view_all_courses'] ) ? $instance['view_all_courses'] : false;
$view_all_position = ( $instance['view_all_position'] && '' != $instance['view_all_position'] ) ? $instance['view_all_position'] : 'top';
$sort              = $instance['order'];
$feature        = !empty( $instance['feature'] ) ? true : false ;

$condition = array(
	'post_type'           => 'lp_course',
	'posts_per_page'      => $limit,
	'ignore_sticky_posts' => true,
);

if ( $sort == 'category' && $instance['cat_id'] && $instance['cat_id'] != 'all' ) {
	if ( get_term( $instance['cat_id'], 'course_category' ) ) {
		$condition['tax_query'] = array(
			array(
				'taxonomy' => 'course_category',
				'field'    => 'term_id',
				'terms'    => $instance['cat_id']
			),
		);
	}
}

if ( $sort == 'popular' ) {
	global $wpdb;
	$query = $wpdb->prepare( "
	  SELECT ID, a+IF(b IS NULL, 0, b) AS students FROM(
		SELECT p.ID as ID, IF(pm.meta_value, pm.meta_value, 0) as a, (
	SELECT COUNT(*)
  FROM (SELECT COUNT(item_id), item_id, user_id FROM {$wpdb->prefix}learnpress_user_items GROUP BY item_id, user_id) AS Y
  GROUP BY item_id
  HAVING item_id = p.ID
) AS b
FROM {$wpdb->posts} p
LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id  AND pm.meta_key = %s
WHERE p.post_type = %s AND p.post_status = %s
GROUP BY ID
) AS Z
ORDER BY students DESC
	  LIMIT 0, $limit
 ", '_lp_students', 'lp_course', 'publish' );

	$post_in = $wpdb->get_col( $query );

	$condition['post__in'] = $post_in;
	$condition['orderby']  = 'post__in';
}

if( $feature ) {
	$condition['meta_query'] = array(
		array(
			'key' => '_lp_featured',
			'value' =>  'yes',
		)
	);
}

$the_query = new WP_Query( $condition );

if ( $the_query->have_posts() ) :
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	if ( $view_all_course && 'top' == $view_all_position ) {
		echo '<a class="view-all-courses position-top" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . '</a>';
	}
	?>
	<div class="thim-course-grid">
		<?php
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$course      = LP_Course::get_course( $post->ID );
			$is_required = $course->is_required_enroll();
			?>
			<div class="lpr_course <?php echo 'course-grid-' . $columns; ?>">
				<div class="course-item">
					<?php
					echo '<div class="course-thumbnail">';
					echo '<a href="' . esc_url( get_the_permalink() ) . '" >';
					echo thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_course_thumbnail_width', 450 ), apply_filters( 'thim_course_thumbnail_height', 450 ), get_the_title() );
					echo '</a>';
					thim_course_wishlist_button();
					echo '</div>';
					?>
					<div class="thim-course-content">
						<?php
						learn_press_course_instructor();
						?>
						<h2 class="course-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a>
						</h2>

						<div class="course-meta">
							<?php learn_press_course_students(); ?>
							<?php thim_course_ratings_count(); ?>
							<div class="course-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								<?php if ( $course->is_free() || !$is_required ) : ?>
									<div class="value free-course" itemprop="price" content="<?php esc_attr_e( 'Free', 'eduma' ); ?>">
										<?php esc_html_e( 'Free', 'eduma' ); ?>
									</div>
								<?php else:
									$price = $course->get_price_html();
									$origin_price = $course->get_origin_price_html();
									?>
									<div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
										<?php
										echo esc_html( $price );
										if ( $price != $origin_price ) {
											echo '<span class="course-origin-price">' . $origin_price . '</span>';
										}
										?>
									</div>
								<?php endif; ?>
								<meta itemprop="priceCurrency" content="<?php echo learn_press_get_currency_symbol(); ?>" />

							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		endwhile;
		?>
	</div>
	<?php
	if ( $view_all_course && 'bottom' == $view_all_position ) {
		echo '<a class="view-all-courses position-bottom" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . '</a>';
	}

endif;

wp_reset_postdata();
