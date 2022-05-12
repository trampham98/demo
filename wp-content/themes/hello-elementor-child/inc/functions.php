<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Set default alt tag image
 */
function get_alt_image( $image, $altDefault = 'Demo' ) {
    
    if (is_array($image)) {
        if (isset($image['alt']) && $image['alt'] != '') 
            return $image['alt'];
        return @str_replace('-', ' ', $image['title']);
    }

    if (is_numeric($image)) {
        $image_id = get_post_thumbnail_id($image);
        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        return ($alt != '') ? $alt : str_replace('-', ' ', get_post($image_id)->post_title);
    }

    if(is_string($image)) {
        $image_id = attachment_url_to_postid($image);
        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        return ($alt != '') ? $alt : str_replace('-', ' ', get_post($image_id)->post_title);
    }

    return $altDefault;
}