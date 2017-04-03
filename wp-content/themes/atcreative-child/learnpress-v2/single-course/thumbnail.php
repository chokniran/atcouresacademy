<?php
/**
 * Template for displaying the thumbnail of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.0.6
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;
if (is_singular()) {
    if (is_user_logged_in()) {
        $auto = '0';
    } else {
        $auto = '1';
    }

    $youtube_id = get_post_meta(get_the_id(), 'youtube_id', true);
    $vimeo_id = get_post_meta(get_the_id(), 'vimeo_id', true);
    $image_id = get_post_meta(get_the_id(), 'image_url_thm', true);
    ?> 
    <div class="course-thumbnail">
        <?php
        if (!empty($youtube_id)) {
            ?>
            <style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='embed-container'><iframe src='http://www.youtube.com/embed/<?php echo $youtube_id ?>'?autoplay=<?php echo $auto ?>" frameborder='0' allowfullscreen></iframe></div>
            <?php
        } else if (!empty($vimeo_id)) {
            ?>
            <style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style>
            <div class='embed-container'>
                <iframe src='http://player.vimeo.com/video/<?php echo $vimeo_id ?>?autoplay=<?php echo $auto ?>' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            </div>
        <?php
    } else {
        ?>
            <img src="<?php echo wp_get_attachment_url($image_id) ?>" alt="">
            <?php
        }
        ?>
    </div>
        <?php
    } else {
        ?>
    <div class="course-thumbnail">
        <a href="<?php echo get_the_permalink(); ?>">
    <?php
    echo thim_get_feature_image(get_post_thumbnail_id(get_the_ID()), 'full', get_the_title());
    ?>
        </a>
            <?php //thim_course_wishlist_button(); ?>
    </div>
        <?php
    }
