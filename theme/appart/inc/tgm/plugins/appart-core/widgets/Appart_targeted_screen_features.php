<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Appart_targeted_screen_features extends Widget_Base {

	public function get_name() {
		return 'appart-targeted-screen-features';
	}

	public function get_title() {
		return __( 'Targeted screen features', 'appart-hero' );
	}

	public function get_icon() {
		return ' eicon-editor-list-ul';
	}

	public function get_categories() {
		return [ 'appart-elements' ];
	}

	protected function _register_controls() {

		// ------------------------------  Title Section ------------------------------
		$this->start_controls_section(
			'title_sec',
			[
				'label' => __( 'Title section', 'appart-core' ),
			]
		);
		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title text', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Data Analytics'
			]
		);
		$this->add_control(
			'subtitle_text',
			[
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------  Featured image ------------------------------
		$this->start_controls_section(
			'featured_image',
			[
				'label' => __( 'Featured image', 'appart-core' ),
			]
		);
		$this->add_control(
			'the_featured_image',
			[
				'label' => esc_html__( 'Featured image', 'appart-core' ),
				'desc' => esc_html__( 'Upload the featured image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->end_controls_section(); // End title section


		// ------------------------------ Feature list ------------------------------
		$this->start_controls_section(
			'feature_list', [
				'label' => __( 'Feature list', 'appart-core' ),
			]
		);
		$this->add_control(
			'features', [
				'label' => __( 'Features list', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Feature name', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Feature 1'
					],
					[
						'name' => 'width',
						'label' => __( 'Width', 'appart-core' ),
						'description' => __( 'Indicator line width in pixel', 'appart-core' ),
						'type' => Controls_Manager::NUMBER,
						'default' => '390',
                    ],
					[
						'name' => 'position',
						'label' => __( 'Position', 'appart-core' ),
						'type' => Controls_Manager::DIMENSIONS,
						'default' => [
							'top' => '180',
							'right' => 'auto',
							'bottom' => 'auto',
							'left' => '80',
							'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
							'isLinked' => false,
						],
					],
					[
						'name' => 'alignment',
						'label' => __( 'Alignment position', 'appart-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'left',
						'options' => [
                            'lef' => 'Left',
                            'right' => 'Right'
                        ],
					],
				],
			]
		);
		$this->end_controls_section(); // End Buttons


		/**
		 * Style Tab
		 * ------------------------------ Style Title ------------------------------
		 *
		 */
		$this->start_controls_section(
			'style_title', [
				'label' => __( 'Style section title', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_prefix', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .product-features .title-four h2' => 'color: {{VALUE}};',
				],
				'default' => '#ffffff'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_prefix',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .product-features .title-four h2',
			]
		);
		$this->end_controls_section();


		//------------------------------ Style subtitle ------------------------------
		$this->start_controls_section(
			'style_subtitle', [
				'label' => __( 'Style subtitle', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_subtitle', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .product-features .title-four p' => 'color: {{VALUE}};',
				],
				'default' => '#ffffff'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .product-features .title-four p',
			]
		);

		$this->end_controls_section();


		//------------------------------ Style Section ------------------------------
		$this->start_controls_section(
			'style_section', [
				'label' => __( 'Style section', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .features_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '115',
					'right' => '0',
					'bottom' => '60',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);
		$this->add_control(
			'sec_bg_image', [
				'label' => esc_html__( 'Background image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'bg_overlay', [
				'label' => _x( 'Background overlay type', 'Background Control', 'appart-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'gradient' => [
						'title' => 'Gradient',
						'icon' => 'fa fa-paint-brush'
					],
					'solid' => [
						'title' => 'Solid',
						'icon' => 'fa fa-barcode'
					]
				]
			]
		);
		$this->add_control(
			'color', [
				'label' => _x( 'Color', 'Background Control', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4c84ff',
				'title' => _x( 'Background Color', 'Background Control', 'appart-core' ),
				'selectors' => [
					'{{SELECTOR}} .product-features' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'bg_overlay' => [ 'solid', 'gradient' ],
				],
			]
		);
		$this->add_control(
			'color_b', [
				'label' => _x( 'Second Color', 'Background Control', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#783dff',
				'render_type' => 'ui',
				'condition' => [
					'bg_overlay' => [ 'gradient' ],
				],
				'of_type' => 'gradient'
			]
		);
		$this->add_control(
			'gradient_angle', [
				'label' => _x( 'Angle', 'Background Control', 'appart-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'condition' => [
					'bg_overlay' => [ 'gradient' ],
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{SELECTOR}} .product-features' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'of_type' => 'gradient',
			]
		);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$features = isset($settings['features']) ? $settings['features'] : '';
		?>
		<section class="product-features">
			<?php if(!empty($settings['sec_bg_image']['url'])) : ?>
                <div class="video-bg" style="background: url('<?php echo esc_url($settings['sec_bg_image']['url']) ?>') no-repeat scroll center center/cover;"> </div>
			<?php endif; ?>
			<div class="container">
				<div class="title-four text-center">
					<?php if(!empty($settings['title_text'])) : ?> <h2> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
					<?php if(!empty($settings['subtitle_text'])) : ?> <?php echo wpautop($settings['subtitle_text']); endif; ?>
				</div>
				<div class="row">
					<div class="product-features-left col-md-12 pr-features-item">
						<?php if(!empty($settings['the_featured_image']['url'])) : ?>
							<div class="pr-features-img text-center">
								<img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="">
							</div>
						<?php endif; ?>
						<?php if(is_array($features)) {
						    foreach ($features as $feature) {
						        $top = $feature['position']['top']!='0' ? $feature['position']['top'].'px' : 'auto';
						        $right = $feature['position']['right']!='0' ? $feature['position']['right'].'px' : 'auto';
						        $bottom = $feature['position']['bottom']!='0' ? $feature['position']['bottom'].'px' : 'auto';
						        $left = $feature['position']['left']!='0' ? $feature['position']['left'].'px' : 'auto';
						        $alignment = $feature['alignment']=='right' ? 's_f_four' : '';
						        ?>
                                <div class="single-features <?php echo $alignment ?>" style="width: <?php echo $feature['width'].'px' ?>; top: <?php echo $top ?>; right: <?php echo $right ?>; bottom: <?php echo $bottom ?>; left: <?php echo $left ?>;">
                                    <h6> <?php echo esc_html($feature['title']); ?> </h6>
                                    <div class="dot"></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
					</div>
				</div>
			</div>
		</section>
		<?php

	}

	protected function _content_template() {
	}

}