<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Maddie Widget.
 * Elementor widget that inserts an widget section into the page.
 */
class Elementor_Maddie_Text_Image extends \Elementor\Widget_Base {

	// Get widget name.
	public function get_name() {
		return 'maddie_text_image';
	}

	// Get widget title.
	public function get_title() {
		return esc_html__( 'Maddie Text-Image', 'maddie' );
	}

	// Get widget icon.
	public function get_icon() {
		return 'eicon-image-box';
	}

	// Get widget categories.
	public function get_categories() {
		return [ 'maddie-category' ];
	}

	// Get widget keywords.
	public function get_keywords() {
		return [ 'text', 'image', 'maddie' ];
	}

	// Register oEmbed widget controls.
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'plugin-name' ),

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f00',
				'selectors' => [
					'{{WRAPPER}} .style-new' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="style-new">
			<p><?php echo $settings['title']; ?></p>
		</div>
		<?php
		echo '<h3>' . $settings['title'] . '</h3>';
	}

	protected function content_template() {
		?>
		<!-- <h3>{{{ settings.title }}}</h3> -->
		<?php
	}
}