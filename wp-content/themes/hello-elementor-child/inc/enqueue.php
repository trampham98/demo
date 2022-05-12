<?php 
/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 99 );
function theme_enqueue_styles() {

    // Get the theme data
    $the_theme = wp_get_theme();

    // style css
    // wp_enqueue_style( 'hello-elementor', get_template_directory_uri() . '/style.min.css', array(), $the_theme->get( 'Version' ) );
    // wp_enqueue_style( 'vendors-styles', get_stylesheet_directory_uri() . '/assets/css/vendors.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'slick-styles', get_stylesheet_directory_uri() . '/assets/vendors/css/slick.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'slick-theme-styles', get_stylesheet_directory_uri() . '/assets/vendors/css/slick-theme.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'elementor-child-styles', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), $the_theme->get( 'Version' ) );

    // style js
    wp_enqueue_script( 'jquery');       
    wp_enqueue_script( 'slick-scripts', get_stylesheet_directory_uri() . '/assets/vendors/js/slick.min.js', array(), $the_theme->get( 'Version' ), true );
    
    // wp_enqueue_script( 'vendors-scripts', get_stylesheet_directory_uri() . '/assets/js/vendors.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'elementor-child-scripts', get_stylesheet_directory_uri() . '/assets/js/theme.js', array(), $the_theme->get( 'Version' ), true );
    
    // wp_enqueue_script( 'ajax-scripts', get_stylesheet_directory_uri() . '/assets/js/ajax.js', array(), $the_theme->get( 'Version' ), true );
    // wp_localize_script( 'elementor-child-scripts', 'demo', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}