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

		$this->end_controls_section();

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

		$member_cate   = $settings['ctrl_member_categories'] ?? '';
		
		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => $post_per_page,
		);

		if ( $post_type == 'member' && $member_cate != '' && $member_cate != 'all' ) {
			$args['tax_query'] =  array(
				array(
					'taxonomy' => 'tax_member',
					'field'    => 'slug',
					'terms'    => $member_cate,
				),
			);
		}

		$query = new WP_Query( $args );
		?>
		<!-- style="animation: slideInUp; animation-duration: <?php //echo $index*0.5; ?>s;" -->
		<div class="maddie-list-posttype-widget maddie-widget-<?php echo $widget_id; ?> <?php echo 'posttype_item_animate_'.$animate_post; ?>">

			<h2 class="list-posttype-widget-title"><?php echo $widget_title; ?></h2>

			<!-- member -->
			<?php if ( $post_type == 'member' ): ?>
				<?php if ( $query->have_posts() ) : ?>
					<div class="list-members-widget maddie-row">
						<?php $index=1; ?>
						<?php while ( $query->have_posts() ): $query->the_post(); 
						
							$member_id       = get_the_ID();
							$member_avatar   = has_post_thumbnail() ? get_the_post_thumbnail_url($member_id, 'full') : \Elementor\Utils::get_placeholder_image_src();
							$member_position = get_field('member_meta_position', $member_id);
							$member_linkedin = get_field('member_meta_linkedin', $member_id);
							$member_download = get_field('member_meta_download_link', $member_id);
							?>
							<div class="maddie-col-3 member-item maddie-post-item" style="animation-duration: <?php echo $index*0.5; ?>s;">
							<!-- <div class="maddie-col-3 member-item"> -->
								<div class="member-item-wrapper">
									<div class="member-item-avatar" style="background-image: url(<?php echo $member_avatar; ?>);">
										<img src="<?php echo $member_avatar; ?>" alt="<?php get_alt_image($member_id); ?>">
									</div>
									<div class="member-item-info">
										<div class="member-item-name">
											<a class="member-name" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
											<?php 
												// the_title('<h5>','</h5>'); 
												echo $member_position ? "<span>$member_position</span>" : '';
											?>
										</div>
										<div class="member-item-link">

											<?php if( $member_linkedin ): 
												$link_target = $member_linkedin['target'] ? $member_linkedin['target'] : '_self'; ?>
												<a class="linkedin" href="<?php echo esc_url( $member_linkedin['url'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
													<i class="icon-linkedin"></i>
													<?php echo esc_html( $member_linkedin['title'] ); ?>
												</a>
											<?php endif; ?>

											<?php if( $member_download ): 
												$link_target = $member_download['target'] ? $member_download['target'] : '_self'; ?>
												<a class="download" href="<?php echo esc_url( $member_download['url'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
													<i class="icon-file-pdf"></i>
													<?php echo esc_html( $member_download['title'] ); ?>
												</a>
											<?php endif; ?>

										</div>
									</div>
								</div>
							</div>
							<?php $index++; ?>
						<?php endwhile; ?>
					</div>

				<?php else : ?>
					<p><?php _e( 'No posts', 'maddie' ); ?></p>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

			<!-- post default -->
			<?php else :
				if ( $query->have_posts() ) {
					echo '<ul class="books-listing-elementor-widget-wrapper">';
					while ( $query->have_posts() ) {
						$query->the_post();
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