<?php
/**
 * Single post job partial template
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$index = 0;

if ( $args ) {
    $index = $args['index'] ? $args['index'] : 0;
}

$term_obj_list = get_the_terms( $post->ID, 'tax_job_team' );
$terms_name    = join(', ', wp_list_pluck($term_obj_list, 'name'));
?>

<div class="maddie-col-6 job-item maddie-post-item" style="animation-duration: <?php echo $index*0.5; ?>s;">
    <div class="job-item-wrapper">
        <a class="job-item-title" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        <span class="job-item-team"><?php echo $terms_name ? $terms_name : '__'; ?></span>
        <span class="job-item-date"><small><?php echo get_the_date('F m, Y'); ?></small></span>
    </div>
</div>