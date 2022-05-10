<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$demo_child_includes = array(
	'/setup.php',                           // Theme setup and custom theme supports.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/shortcodes.php',                      // Custom shortcodes.
	// '/widgets.php',                         // Custom shortcodes.
	// '/post_type.php',                       // Custom post_type.
	// '/woocommerce.php',                     // Custom woocommerce.
	'/functions.php'                        // Custom functions.
);

foreach ( $demo_child_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
