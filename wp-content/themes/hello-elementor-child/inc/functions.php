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

function maddie_custom_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) { 
        if ( is_post_type_archive('job') ) {
            $query->set( 'posts_per_page', -1 );
        }
    }
}
add_action( 'pre_get_posts', 'maddie_custom_pre_get_posts' );


function maddie_get_terms_checklist( $taxonomy ) {
 
    $args = array(
        'taxonomy'     => $taxonomy,
        'hide_empty'   => true,
        // 'hierarchical' => false,
    );

    $terms = get_terms( $args );
    $select_html = '';
    ?>
  
    <?php if ($terms): ?>
        <?php $select_html .= '<select name="'.$taxonomy.'[]" id="" multiple="multiple">'; ?>
        <ul class="<?php echo $taxonomy; ?>_checklist">
            <?php foreach ( $terms as $term ): ?>
                <li class="checkbox-item">
                    <label>
                        <input type="checkbox" name="<?php echo $taxonomy.'_'.$term->term_id; ?>" value="<?php echo $term->term_id; ?>"/>
                        <span class="checkbox-item-label"><?php echo esc_html( apply_filters( 'the_category', $term->name, '', '' ) ); ?></span>
                    </label>
                </li>
                <?php $select_html .= '<option value="'.$term->term_id.'">'.$term->name.'</option>'; ?>
            <?php endforeach; ?>
        </ul>
        <?php $select_html .= '</select>'; ?>
        <?php echo $select_html; ?>
    <?php endif; ?>

<?php    
}