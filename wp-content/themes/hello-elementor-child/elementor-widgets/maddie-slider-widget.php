<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Demo Widget.
 *
 * Elementor widget that inserts an text content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Maddie_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'maddie_slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Maddie Slider', 'maddie' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-editor-paragraph';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	// public function get_custom_help_url() {
	// 	return 'https://developers.elementor.com/docs/widgets/';
	// }

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'maddie-category' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'slider', 'maddie' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'maddie' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'funny_text',
			[
				'label' => esc_html__( 'Funny Text', 'maddie' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				// 'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => esc_html__( 'please enter your text here...', 'maddie' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render demo widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'funny_text', 'advanced' );

		error_log(print_r( 'test', true ));
		error_log(print_r( $this->get_settings( 'funny_text' ), true )); 	
		// error_log(print_r( $settings )); 	

		echo '<div class="demo-elementor-widget">';
		?>
			<div <?php echo $this->get_render_attribute_string( 'funny_text' ); ?>><?php echo $settings['funny_text']; ?></div>
		<?php
		// echo ( $settings['funny_text'] ) ? $settings['funny_text'] : '';
		echo '</div>';

	}

	protected function content_template() {
		?>
		<# view.addInlineEditingAttributes( 'funny_text', 'advanced' ); #>
		<div {{{ view.getRenderAttributeString( 'funny_text' ) }}}>{{{ settings.funny_text }}}</div>
		<?php
	}


}