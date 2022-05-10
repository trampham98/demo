<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc-child';

// Array of files to include.
$understrap_includes_child = array(
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/functions.php'                        // Custom functions.
);

// Load WooCommerce functions if WooCommerce is activated.
// if ( class_exists( 'WooCommerce' ) ) {
// 	$understrap_includes_child[] = '/woocommerce.php';
// }

// Include files.
foreach ( $understrap_includes_child as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}
