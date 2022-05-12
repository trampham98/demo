<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Maddie Slider Widget.
 * Elementor widget that inserts an slider section into the page.
 */
class Elementor_Maddie_Slider_Widget extends \Elementor\Widget_Base {

	// Get widget name.
	public function get_name() {
		return 'maddie_slider';
	}

	// Get widget title.
	public function get_title() {
		return esc_html__( 'Maddie Slider', 'maddie' );
	}

	// Get widget icon.
	public function get_icon() {
		return 'eicon-slider-device';
	}

	// Get widget categories.
	public function get_categories() {
		return [ 'maddie-category' ];
	}

	// Get widget keywords.
	public function get_keywords() {
		return [ 'slider', 'maddie' ];
	}

	// Register oEmbed widget controls.
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Slider', 'maddie' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		// ctrl slide item
		$repeater->add_control(
			'ctrl_slide_title', [
				'label' => esc_html__( 'Title', 'maddie' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Slide Title' , 'maddie' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'ctrl_slide_image',
			[
				'label' => esc_html__( 'Choose Image', 'maddie' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// ctrl slides
		$this->add_control(
			'ctrl_slides',
			[
				'label' => esc_html__( 'Slider', 'maddie' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'ctrl_slide_title' => esc_html__( 'Title #1', 'maddie' ),
					],
					[
						'ctrl_slide_title' => esc_html__( 'Title #2', 'maddie' ),
					],
				],
				'title_field' => '{{{ ctrl_slide_title }}}',
			]
		);

		$this->end_controls_section();

	}

	// Render demo widget output on the frontend.
	protected function render() {
		$settings = $this->get_settings_for_display();

		// if ( $settings['list'] ) {
		// 	echo '<dl>';
		// 	foreach (  $settings['list'] as $item ) {
		// 		echo '<dt class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . '">' . $item['list_title'] . '</dt>';
		// 		echo '<dd>' . $item['list_content'] . '</dd>';
		// 	}
		// 	echo '</dl>';
		// }

		?>

		<?php if ( $settings['ctrl_slides'] ): ?>
			<div class="maddie-slider-widget">
				<div class="maddie-slider-wrapper">
					<?php foreach (  $settings['ctrl_slides'] as $slide ): 
						// error_log(print_r( 'test789', true ));
						// error_log(print_r( $slide, true )); 

						$slide_image = ($slide['ctrl_slide_image']['url'] !='') ? $slide['ctrl_slide_image']['url'] : \Elementor\Utils::get_placeholder_image_src(); ?>

						<div class="maddie-slide maddie-slide-<?php echo $slide['_id']; ?>" style="background-image: url(<?php echo $slide_image ?>);">
							<div class="maddie_container">
								<img class="d-none" src="<?php echo $slide_image ?>" alt="<?php echo get_alt_image( $slide_image ); ?>">
								<?php if ( $slide['ctrl_slide_title'] && $slide['ctrl_slide_title'] != '' ): ?>
									<h2 class="maddie-slide-title"><?php echo $slide['ctrl_slide_title'] ?></h2>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<script>
				jQuery(document).ready(function ($) {
					$('.maddie-slider-widget .maddie-slider-wrapper').slick({
						infinite: false,
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						// draggable: false,
					});
				});
			</script>
		<?php endif; ?>

		<?php
	}

	protected function content_template() {
		?>
		<!-- <# if ( settings.ctrl_slides ) { #>
			<div class="maddie-slider-widget">
				<div class="maddie-slider-wrapper">
					<# _.each( settings.ctrl_slides, function( item, index ) { 
						
						var	maddie_slide_attr = view.getRepeaterSettingKey( '_id', 'ctrl_slides', index );
						view.addRenderAttribute( maddie_slide_attr, { 
							'class': [ '"maddie-slide', 'maddie-slide-' + item._id ], 
							'style': 'background-image: url('+ item.ctrl_slide_image.url +');'
						} ); #>

						<div {{{ view.getRenderAttributeString( maddie_slide_attr ) }}}>
							<div class="maddie_container">
								<# if ( settings.ctrl_slide_title ) { #>
									<h2 class="maddie-slide-title">{{{ item.ctrl_slide_title }}}</h2>
								<# } #>
							</div>
						</div>

					<# } ); #>
				</div>
			</div>
		<# } #> -->


		<# if ( settings.ctrl_slides ) { #>
		<ul>
			<# _.each( settings.ctrl_slides, function( item, index ) { #>
				<li class="slide-item-{{ item._id }}">
					<p>Slide #{{ index }}</p>
					<ul>
						<li><b>Slide title:</b> {{{ item.ctrl_slide_title }}}</li>

						<# if ( item.ctrl_slide_image.url != '' ) { #>
							<li><b>Slide image URL:</b> {{{ item.ctrl_slide_image.url }}}</li>
						<# } else { #>
							<li><b>Slide image URL:</b> NULL</li>
						<# } #>
					</ul>
				</li>
			<# }); #>
		</ul>
		<# } #>
		<?php
	}
}