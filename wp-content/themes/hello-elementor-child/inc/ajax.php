<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// filter news
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
function my_action() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
    echo $whatever;
	
    wp_die();
}