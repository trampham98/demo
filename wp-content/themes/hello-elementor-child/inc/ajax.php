<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// demo
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
function my_action() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
    echo $whatever;
	
    wp_die();
}

// filter news
add_action( 'wp_ajax_maddie_filter_news', 'maddie_filter_news' );
add_action( 'wp_ajax_nopriv_maddie_filter_news', 'maddie_filter_news' );
function maddie_filter_news() {
    global $the_query;

    $post_per_page = ( isset( $_POST['post_per_page'] ) && $_POST['post_per_page'] != '' ) ? $_POST['post_per_page'] : ''; 

    $terms = array();
    if ( isset( $_POST['terms'] ) && $_POST['terms'] != '' ) {
        $terms = $_POST['terms'];
    }

    // url of page link (pagination)
    $page_url     = ( isset( $_POST['page_url'] ) && $_POST['page_url'] != '' ) ? $_POST['page_url'] : ''; 
    $pagenum_link = html_entity_decode( $page_url );
    $url_parts    = explode( '?', $pagenum_link );
    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

    $paged         = 1;

    if ( get_query_var( 'paged' ) ) {
        $paged = absint( get_query_var( 'paged' ) );
    } elseif ( get_query_var( 'page' ) ) {
        $paged = absint( get_query_var( 'page' ) );
    }
    
    $args = array(
        'post_type'      => 'news',
        'posts_per_page' => $post_per_page,
        'paged'          => $paged,
    );

    if ( !empty($terms) && $terms['news_cat'] != '' ) {			
        $args['tax_query'] =  array(
            array(
                'taxonomy' => 'tax_news',
                'field'    => 'slug',
                'terms'    => $terms['news_cat'],
            ),
        );
    }

    if ( !empty($terms) && $terms['news_year'] != '' ) {	
        $args['date_query'] =  array(
            array(
                'year'  => $terms['news_year'],
            ),
        );
    }

    $the_query = new WP_Query( $args );

    ?>
    <?php if ( $the_query->have_posts() ) : ?>
        <div class="list-news-wrapper maddie-row">
            <?php 
                $index=1; 
                while ( $the_query->have_posts() ) {
                    $the_query->the_post(); 
                    get_template_part(
                        'loop-templates/content',
                        'news',
                        array(
                            'index'   => $index,
                        )
                    );
                    $index++;
                } 							
            ?>
        </div>
        <?php 
            understrap_pagination(array(
                'base'     => $pagenum_link,
                'add_args' => $terms,
            )); 
        ?>

    <?php else : ?>
        <p><?php _e( 'No posts', 'maddie' ); ?></p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <?php
    wp_die();
}