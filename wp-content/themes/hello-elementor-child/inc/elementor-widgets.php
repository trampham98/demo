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

	// maddie list widget
    require_once( get_stylesheet_directory() . '/elementor-widgets/maddie-list-posttype-widget.php' );
	$widgets_manager->register( new \Elementor_Maddie_List_Posttype_Widget() );

	// maddie milestone widget
    require_once( get_stylesheet_directory() . '/elementor-widgets/maddie-milestone-widget.php' );
	$widgets_manager->register( new \Elementor_Maddie_Milestone_Widget() );


	// demo
    // maddie repeater widget
    require_once( get_stylesheet_directory() . '/elementor-widgets/maddie-repeater-widget.php' );
	$widgets_manager->register( new \Elementor_Maddie_Repeater_Widget() );

	// maddie list widget
    require_once( get_stylesheet_directory() . '/elementor-widgets/maddie-list-widget.php' );
	$widgets_manager->register( new \Elementor_Maddie_list_Widget() );	
}

// add elementor categories
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

/*
 * Add custom container (container and full container), spacing (margin and padding) controls to Elementor's Column_Element and Section_Element
 * This hook means "run this function before you add the control section named 'section_layout' on 
 * the element 'column' or 'section'.
 */
add_action( 'elementor/element/column/section_advanced/before_section_start', 'maddie_add_section_setting_controls' ); 
add_action( 'elementor/element/section/section_advanced/before_section_start', 'maddie_add_section_setting_controls' ); 
function maddie_add_section_setting_controls( \Elementor\Element_Base $element) {
	// Create our own custom control section
	$element->start_controls_section(
		'section_maddie_setting',
		[
			'label' => __( 'Maddie Section Setting', 'maddie' ),
			'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
		]
	);

    // add control container
	// $element->add_control(
	// 	'ctrl_maddie_container',
	// 	[
	// 		'type'    => \Elementor\Controls_Manager::SELECT,
	// 		'label'   => esc_html__( 'Container Content', 'maddie' ),
	// 		'options' => [
	// 			'container'      => esc_html__( 'Container', 'maddie' ),
	// 			'full_container' => esc_html__( 'Full Container', 'maddie' ),
	// 		],
    //         // 'default' => 'container',
	// 		'prefix_class' => 'maddie_',
	// 	]
	// );

	$element->add_control(
		'ctrl_maddie_container',
		[
			'label' => esc_html__( 'Enable Container', 'maddie' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'On', 'maddie' ),
			'label_off' => esc_html__( 'Off', 'maddie' ),
			'return_value' => 'yes',
			// 'default' => 'no',
			'prefix_class' => 'maddie_container_',
		]
	);

    // add control spacing
    $element->add_control(
		'ctrl_maddie_padding',
		[
			'type' => \Elementor\Controls_Manager::SELECT,
			'label' => esc_html__( 'Padding', 'maddie' ),
			'options' => [
				'no_padding' => esc_html__( 'No Padding', 'maddie' ),
				'pt_1x' => esc_html__( 'Top 1x', 'maddie' ),
				'pt_2x' => esc_html__( 'Top 2x', 'maddie' ),
				'pb_1x' => esc_html__( 'Bottom 1x', 'maddie' ),
				'pb_2x' => esc_html__( 'Bottom 2x', 'maddie' ),
				'px_1x' => esc_html__( 'Top & Bottom 1x', 'maddie' ),
				'px_2x' => esc_html__( 'Top & Bottom 2x', 'maddie' ),
			],
            // 'default' => 'no_padding',
			'prefix_class' => '',
		]
	);

    // add control margin
    $element->add_control(
		'ctrl_maddie_margin',
		[
			'type' => \Elementor\Controls_Manager::SELECT,
			'label' => esc_html__( 'Margin', 'maddie' ),
			'options' => [
				'no_margin' => esc_html__( 'No Margin', 'maddie' ),
				'mt_1x' => esc_html__( 'Top 1x', 'maddie' ),
				'mt_2x' => esc_html__( 'Top 2x', 'maddie' ),
				'mb_1x' => esc_html__( 'Bottom 1x', 'maddie' ),
				'mb_2x' => esc_html__( 'Bottom 2x', 'maddie' ),
				'mx_1x' => esc_html__( 'Top & Bottom 1x', 'maddie' ),
				'mx_2x' => esc_html__( 'Top & Bottom 2x', 'maddie' ),
			],
            // 'default' => 'no_margin',
			'prefix_class' => '',
		]
	);

	$element->end_controls_section();
};
