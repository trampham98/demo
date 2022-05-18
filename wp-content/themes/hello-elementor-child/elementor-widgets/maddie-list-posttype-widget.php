<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Maddie Slider Widget.
 * Elementor widget that inserts an slider section into the page.
 */
class Elementor_Maddie_List_Posttype_Widget extends \Elementor\Widget_Base {

	// Get widget name.
	public function get_name() {
		return 'maddie_list_posttype';
	}

	// Get widget title.
	public function get_title() {
		return esc_html__( 'Maddie List Post Type', 'maddie' );
	}

	// Get widget icon.
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	// Get widget categories.
	public function get_categories() {
		return [ 'maddie-category' ];
	}

	// Get widget keywords.
	public function get_keywords() {
		return [ 'list', 'post-type', 'maddie' ];
	}

	protected function enqueue() {

		

		// // Scripts
		// wp_register_script( 'control-script', plugins_url( 'assets/js/control-script.js', __FILE__ ) );
		// wp_enqueue_script( 'control-script' );

	}

	// Register oEmbed widget controls.
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'List Post Type', 'maddie' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ctrl_widget_title',
			[
				'label' => esc_html__( 'Title Widget', 'maddie' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'ctrl_post_type',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Post Type', 'maddie' ),
				'options' => [
					'post' => esc_html__( 'Post', 'maddie' ),
					'news' => esc_html__( 'News', 'maddie' ),
					'member' => esc_html__( 'Member', 'maddie' ),
				],
				'default' => 'post',
			]
		);


		$this->add_control(
			'ctrl_member_categories',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Categories Member', 'maddie' ),
				'options' => [
					'all' => esc_html__( 'All', 'maddie' ),
					'dev' => esc_html__( 'Dev', 'maddie' ),
					'qa' => esc_html__( 'QA', 'maddie' ),
					'pm' => esc_html__( 'PM', 'maddie' ),
				],
				'condition' => [
					'ctrl_post_type' => 'member',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'ctrl_posts_per_page',
			[
				'label' => esc_html__( 'Posts per Page', 'maddie' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'default to show 4 posts (-1 to show all posts)', 'maddie' ),
				// 'placeholder' => esc_html__( '-1 to show all posts', 'maddie' ),
			]
		);

		// $this->add_control(
		// 	'ctrl_entrance_animation',
		// 	[
		// 		'label' => esc_html__( 'Animation for post item', 'maddie' ),
		// 		'type' => \Elementor\Controls_Manager::ANIMATION,
		// 		'prefix_class' => 'animated ',
		// 	]
		// );
		$this->add_control(
			'ctrl_enable_animation',
			[
				'label' => esc_html__( 'Enable Animation for post item', 'maddie' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'maddie' ),
				'label_off' => esc_html__( 'Off', 'maddie' ),
				'return_value' => 'yes',
				// 'default' => 'no',
				// 'prefix_class' => 'posttye_item_animate_ ',
			]
		);

		$this->add_control(
			'ctrl_enable_news_filter',
			[
				'label' => esc_html__( 'Enable Filter', 'maddie' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'maddie' ),
				'label_off' => esc_html__( 'Off', 'maddie' ),
				'return_value' => 'yes',
				'condition' => [
					'ctrl_post_type' => 'news',
				],
				'default' => 'no',
			]
		);

		$this->add_control(
			'ctrl_enable_news_pagination',
			[
				'label' => esc_html__( 'Enable Pagination', 'maddie' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'maddie' ),
				'label_off' => esc_html__( 'Off', 'maddie' ),
				'return_value' => 'yes',
				'condition' => [
					'ctrl_post_type' => 'news',
				],
				'default' => 'no',
			]
		);

		$this->end_controls_section();

	}

	public function get_style_depends() {
		return [ 'e-animations' ];
	}

	// Render demo widget output on the frontend.
	protected function render() {

		// Styles
		// wp_enqueue_style( 'e-animations' );

		$widget_id     = $this->get_id();
		$settings      = $this->get_settings_for_display();
		$animate_post  = $settings['ctrl_enable_animation'];
		// $animate_post  = $settings['ctrl_entrance_animation']; var_dump($animate_post);

		$widget_title  = $settings['ctrl_widget_title'];
		$post_type     = $settings['ctrl_post_type'];
		$post_per_page = $settings['ctrl_posts_per_page'] ? $settings['ctrl_posts_per_page'] : 4;
		$paged         = 1;

		if ( get_query_var( 'paged' ) ) {
			$paged = absint( get_query_var( 'paged' ) );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = absint( get_query_var( 'page' ) );
		}
		
		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => $post_per_page,
			'paged'          => $paged,
		);

		// member
		$member_cate   = $settings['ctrl_member_categories'] ?? '';

		if ( $post_type == 'member' && $member_cate != '' && $member_cate != 'all' ) {
			$args['tax_query'] =  array(
				array(
					'taxonomy' => 'tax_member',
					'field'    => 'slug',
					'terms'    => $member_cate,
				),
			);
		}

		// news
		$news_cat = '';
		$news_year = '';

		if ( isset($_GET['news_cat']) && $_GET['news_cat'] != '' ) {			
			$news_cat = $_GET['news_cat'];
			$args['tax_query'] =  array(
				array(
					'taxonomy' => 'tax_news',
					'field'    => 'slug',
					'terms'    => $news_cat,
				),
			);
		}

		if ( isset($_GET['news_year']) && $_GET['news_year'] != '' ) {
			$news_year = $_GET['news_year'];
			$args['date_query'] =  array(
				array(
					'year'  => $news_year,
				),
			);
		}

		global $the_query;
		$the_query = new WP_Query( $args );
		?>
		<!-- style="animation: slideInUp; animation-duration: <?php //echo $index*0.5; ?>s;" -->
		<div class="maddie-list-posttype-widget maddie-widget-<?php echo $widget_id; ?> <?php echo 'posttype_item_animate_'.$animate_post; ?>">

			<h2 class="list-posttype-widget-title"><?php echo $widget_title; ?></h2>

			<!-- member -->
			<?php if ( $post_type == 'member' ): ?>
				<?php if ( $the_query->have_posts() ) : ?>
					<div class="list-members-widget maddie-row">
						<?php 
							$index=1; 
							while ( $the_query->have_posts() ) {
								$the_query->the_post(); 
								get_template_part(
									'loop-templates/content',
									'member',
									array(
										'index'   => $index,
									)
								);

								$index++;
							} 							
						?>
					</div>
				<?php else : ?>
					<p><?php _e( 'No posts', 'maddie' ); ?></p>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			
			<!-- news -->
			<?php elseif ( $post_type == 'news' ): ?>	

				<!-- Filter news -->
				<div class="new-filter maddie-row justify-content-end">
					<div class="maddie-col-2">
						<?php 
							$news_cate_args = array(
								'show_option_none' => __( 'All Categories', 'textdomain' ),
								'orderby'         => 'name',
								'show_count'      => 0,
								'selected'        => $news_cat,
								'name'            => 'news_cat',
								'class'           => 'news_categories_dropdown',
								'taxonomy'        => 'tax_news',
								'option_none_value' => '',
								'value_field'     => 'slug',
							);

							$news_years = array(
								'type'            => 'yearly', 
								'format'          => 'option',
								'show_post_count' => false,
								// 'echo'            => false,
								'post_type'       => 'news',
							);
						?>
						<form class="news_filter_form" action="<?php echo esc_url( get_the_permalink() ); ?>" method="get">
							<?php wp_dropdown_categories( $news_cate_args ); ?>
							<select name="news_year">
								<option value=""><?php esc_attr( _e( 'All Year', 'maddie' ) ); ?></option> 
								<?php wp_get_archives( $news_years ); ?>
							</select>
						</form>
					</div>				
				</div>
				
				<?php if ( $the_query->have_posts() ) : ?>
					<div class="list-news-wrapper maddie-row">
						<?php 
							$index=1; 
							while ( $the_query->have_posts() ) {
								$the_query->the_post(); 
								get_template_part(
									'loop-templates/content',
									'news',
									array(
										'index'   => $index,
									)
								);
								$index++;
							} 							
						?>
					</div>
					<?php understrap_pagination(); ?>

				<?php else : ?>
					<p><?php _e( 'No posts', 'maddie' ); ?></p>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

			<!-- post default -->
			<?php else :
				if ( $the_query->have_posts() ) {
					echo '<ul class="books-listing-elementor-widget-wrapper">';
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<li>' . get_the_title() . '</li>';
					}
					echo '</ul>';
				} else {
					echo 'No posts';
				}
				wp_reset_postdata();
			endif; ?>
		</div>

		<?php
	}
}