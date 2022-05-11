<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register custom Widgets.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

add_action( 'elementor/widgets/register', 'maddie_register_elementor_widget' );
function maddie_register_elementor_widget( $widgets_manager ) {

    // maddie slider widget
    require_once( get_stylesheet_directory() . '/elementor-widgets/maddie-slider-widget.php' );
	$widgets_manager->register( new \Elementor_Maddie_Slider_Widget() );
}

add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
function add_elementor_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'maddie-category',
		[
			'title' => esc_html__( 'Maddie Category', 'maddie' ),
			'icon' => 'fa fa-plug',
		]
	);
}
