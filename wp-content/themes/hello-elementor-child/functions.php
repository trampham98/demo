<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$demo_child_includes = array(
	'/setup.php',                           
	'/enqueue.php',                         
	'/shortcodes.php',                     
	'/widgets.php',
	'/ajax.php',
	// '/post_type.php',
	// '/woocommerce.php',
	'/pagination.php',
	'/elementor-widgets.php',
	'/functions.php'
);

foreach ( $demo_child_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
