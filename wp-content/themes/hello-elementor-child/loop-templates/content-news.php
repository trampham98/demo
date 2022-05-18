<?php
/**
 * Single post news partial template
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$index = 0;

if ( $args ) {
    $index = $args['index'] ? $args['index'] : 0;
}
?>

<div class="maddie-col-4 news-item maddie-post-item" style="animation-duration: <?php echo $index*0.5; ?>s;">
    <div class="news-item-wrapper">
        <a class="new-item-title" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        <span class="new-item-date"><?php echo get_the_date('F m, Y'); ?></span>
    </div>
</div>