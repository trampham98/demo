<?php
/**
 * Understrap enqueue scripts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// enqueue child theme stylesheets
add_action( 'wp_enqueue_scripts', 'understrap_child_enqueue_styles', 99 );
function understrap_child_enqueue_styles() {
    $theme = wp_get_theme();
    wp_enqueue_style( 'understrap-theme-styles', get_stylesheet_directory_uri() . '/css/theme.css', array(), $theme->parent()->get('Version') );
    wp_enqueue_style( 'understrap-child-styles', get_stylesheet_uri(), array(), $theme->parent()->get('Version') );
}