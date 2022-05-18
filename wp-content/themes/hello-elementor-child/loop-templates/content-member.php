<?php
/**
 * Single post member partial template
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$index           = 0;
$member_id       = get_the_ID();
$member_avatar   = has_post_thumbnail() ? get_the_post_thumbnail_url($member_id, 'full') : \Elementor\Utils::get_placeholder_image_src();
$member_position = get_field('member_meta_position', $member_id);
$member_linkedin = get_field('member_meta_linkedin', $member_id);
$member_download = get_field('member_meta_download_link', $member_id);

if ( $args ) {
    $index = $args['index'] ? $args['index'] : 0;
}
?>

<div class="maddie-col-3 post-item-<?php echo $member_id; ?> maddie-post-item member-item" <?php echo ($index > 0) ? 'style="animation-duration:'.$index*0.5.'s;"' : ''; ?>>
    <div class="member-item-wrapper">
        <div class="member-item-avatar" style="background-image: url(<?php echo $member_avatar; ?>);">
            <img src="<?php echo $member_avatar; ?>" alt="<?php get_alt_image($member_id); ?>">
        </div>
        <div class="member-item-info">
            <div class="member-item-name">
                <a class="member-name" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                <?php echo $member_position ? "<span>$member_position</span>" : ''; ?>
            </div>
            <div class="member-item-link">

                <?php if( $member_linkedin ): 
                    $link_target = $member_linkedin['target'] ? $member_linkedin['target'] : '_self'; ?>
                    <a class="linkedin" href="<?php echo esc_url( $member_linkedin['url'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                        <i class="icon-linkedin"></i>
                        <?php echo esc_html( $member_linkedin['title'] ); ?>
                    </a>
                <?php endif; ?>

                <?php if( $member_download ): 
                    $link_target = $member_download['target'] ? $member_download['target'] : '_self'; ?>
                    <a class="download" href="<?php echo esc_url( $member_download['url'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                        <i class="icon-file-pdf"></i>
                        <?php echo esc_html( $member_download['title'] ); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>