<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Maddie Milestone Widget.
 * Elementor widget that inserts an Milestone section into the page.
 */
class Elementor_Maddie_Milestone_Widget extends \Elementor\Widget_Base {

	// Get widget name.
	public function get_name() {
		return 'maddie_milestone';
	}

	// Get widget title.
	public function get_title() {
		return esc_html__( 'Maddie Milestone', 'maddie' );
	}

	// Get widget icon.
	public function get_icon() {
		return 'eicon-tabs';
	}

	// Get widget categories.
	public function get_categories() {
		return [ 'maddie-category' ];
	}

	// Get widget keywords.
	public function get_keywords() {
		return [ 'milestone', 'maddie' ];
	}

	// Register oEmbed widget controls.
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Milestone', 'maddie' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ctrl_widget_title',
			[
				'label' => esc_html__( 'Widget Title', 'elementor-list-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'ctrl_milestone_item',
			[
				'label' => __( 'Milestone Items', 'maddie' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'default' => [
					[
						'ctrl_milestone_item_title'   => __( 'Milestone #1', 'maddie' ),
						'ctrl_milestone_item_content' => __( 'Milestone Content', 'maddie' ),
						'ctrl_milestone_item_year'    => __( '2022', 'maddie' ),
					],
					[
						'ctrl_milestone_item_title'   => __( 'Milestone #2', 'maddie' ),
						'ctrl_milestone_item_content' => __( 'Milestone Content', 'maddie' ),
						'ctrl_milestone_item_year'    => __( '2022', 'maddie' ),
					],
				],
				'fields' => [
					[
						'name'    => 'ctrl_milestone_item_title',
						'label'   => __( 'Title', 'maddie' ),
						'label_block' => true,
						'type'    => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Title', 'maddie' ),
					],
					[
						'name'    => 'ctrl_milestone_item_content',
						'label'   => __( 'Content', 'maddie' ),
						'type'    => \Elementor\Controls_Manager::WYSIWYG,
						'default' => __( 'Content', 'maddie' ),
					],
					[
						'name'    => 'ctrl_milestone_item_year',
						'label'   => __( 'Year', 'maddie' ),
						'type'    => \Elementor\Controls_Manager::NUMBER,
						'default' => __( '2022', 'maddie' ),
						// 'prefix_class' => '',
					],

				],
				'title_field' => '{{{ ctrl_milestone_item_title }}} - {{{ ctrl_milestone_item_year }}}',
			]
		);

		$this->end_controls_section();

	}

	// Render demo widget output on the frontend.
	protected function render() {
		$settings     = $this->get_settings_for_display();
		$widget_id    = $this->get_id();
		$widget_title = $settings['ctrl_widget_title'];

		$milestones    = array();
		$tabs_html     = '';
		$tab_item_html = '';


		if ( $settings['ctrl_milestone_item'] ) {
			foreach (  $settings['ctrl_milestone_item'] as $item ) {
				$item_title   = $item['ctrl_milestone_item_title'];
				$item_content = $item['ctrl_milestone_item_content'];
				$item_year    = $item['ctrl_milestone_item_year'];

				$milestones[$item_year][] = array(
					'ctrl_milestone_item_title'   => $item_title,
					'ctrl_milestone_item_content' => $item_content,
				);
			}
		}

		if ( !empty( $milestones ) ) {
			$tabs_html .= '<ul class="tabs-nav">';

			foreach ($milestones as $key => $milestone) {
				$tab_id = "tab-$widget_id-$key";

				// tab nav
				$tabs_html .= '<li><a class="tab-nav-item" href="#'.$tab_id.'">'.$key.'</a></li>';

				// tab content
				$tab_item_html .= '<div class="tab-content-item" id="'.$tab_id.'">';
				foreach ($milestone as $item) {
					$tab_item_html .= '<div class="milestone-item"><div class="milestone-item-inner">';
					$tab_item_html .= '<span class="milestone-item-title">'.$item['ctrl_milestone_item_title'].'</span>';
					$tab_item_html .= '<div class="milestone-item-content">'.$item['ctrl_milestone_item_content'].'</div>';
					$tab_item_html .= '<span class="milestone-item-year">'.$key.'</span>';
					$tab_item_html .= '</div></div>';
				}
				$tab_item_html .= '</div>';
			}

			$tabs_html .= '</ul>';
		}
		?>
		<div class="maddie-milestone-widget maddie-widget-<?php echo $widget_id; ?>">
			<h2 class="milestone-widget-title"><?php echo $widget_title; ?></h2>
			<?php if ( $tabs_html !='' && $tab_item_html !='' ): ?>
				<div class="milestone-widget-wrapper">
					<div class="maddie-milestone-tabs" id="tabs-<?php echo $widget_id; ?>">
						<?php echo $tabs_html; ?>
						<?php echo $tab_item_html; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<script>
			jQuery(document).ready(function ($) {
				$( "#tabs-<?php echo $widget_id; ?>" ).tabs();

				$('.maddie-widget-<?php echo $widget_id; ?> .tab-content-item').slick({
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: true,
					centerMode: true,
					centerPadding: '200px',
					// draggable: false,
				});

				// let defaults = {
				// 	dots: false,
				// 	speed: 300,
				// 	slidesToShow: 1,
				// 	arrows: false,
				// 	draggable: false,
				// 	fade: true,
				// 	cssEase: 'linear'            
				// }
				
				$( ".maddie-widget-<?php echo $widget_id; ?> .tab-nav-item" ).click(function() {
					// console.log('test123', $(this).attr( "href" ));
					var tabContentItemId = $(this).attr( "href" );
					$(tabContentItemId).slick('refresh');

				});				
			});
		</script>

		<?php
	}
}