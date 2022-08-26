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
class Appart_download_buttons extends Widget_Base {

	public function get_name() {
		return 'appart-download-sec';
	}

	public function get_title() {
		return __( 'Download section', 'appart-hero' );
	}

	public function get_icon() {
		return '  eicon-download-button';
	}

	public function get_categories() {
		return [ 'appart-elements' ];
	}

	protected function _register_controls() {

		// ------------------------------  Title Section ------------------------------
		$this->start_controls_section(
			'title_sec', [
				'label' => __( 'Title section', 'appart-core' ),
			]
		);
		$this->add_control(
			'title_text', [
				'label' => esc_html__( 'Title text', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Get App Now!'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => '<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores ratione voluptatem sequi nesciunt.</p>'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------ Buttons ------------------------------
		$this->start_controls_section(
			'btn_sec', [
				'label' => __( 'Download Buttons', 'appart-core' ),
			]
		);
		$this->add_control(
			'buttons', [
				'label' => __( 'Create buttons', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ btn_name }}}',
				'fields' => [
					[
						'name' => 'btn_name',
						'label' => __( 'Button label', 'appart-core' ),
						'description' => esc_html__( 'Use <br> tag for line breaking.', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'Download iPhone app',
                        'label_block' => true,
					],
					[
						'name' => 'btn_url',
						'label' => __( 'Button URL', 'appart-core' ),
						'type' => Controls_Manager::URL,
						'default' => [
                            'url' => '#',
							'is_external' => '',
                        ],
						'show_external' => true,
					],
                    [
                        'name' => 'btn_icon',
                        'label' => __( 'Button icon', 'appart-core' ),
                        'type' => Controls_Manager::ICON,
                        'default' => 'fa fa-apple'
                    ],
					[
						'name' => 'color',
						'label' => __( 'Color', 'appart-core' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#fff',
					],
					[
						'name' => 'bg_color',
						'label' => __( 'Background color', 'appart-core' ),
						'type' => Controls_Manager::COLOR,
						'default' => 'rgba(255,255,255,0.1)',
					],
					[
						'name' => 'bg_hover_color',
						'label' => __( 'Background hover color', 'appart-core' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#fff',
					],
					[
						'name' => 'border_color',
						'label' => __( 'Button border color', 'appart-core' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
					],

				],
			]
		);
		$this->end_controls_section(); // End Buttons

		// ------------------------------  Featured image ------------------------------
		$this->start_controls_section(
			'featured_image', [
				'label' => __( 'Featured image', 'appart-core' ),
			]
		);
		$this->add_control(
			'the_featured_image', [
				'label' => esc_html__( 'Featured image', 'appart-core' ),
				'desc' => esc_html__( 'Upload the featured image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'featured_image_position', [
				'label' => __( 'Image position', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .call-action .call-mobile-img img' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .new_call_action_area .action_mobile' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '-382',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);
		$this->end_controls_section(); // End title section

		/**
		 * Style Tab
		 * ------------------------------ Style Title ------------------------------
		 *
		 */
		$this->start_controls_section(
			'style_title', [
				'label' => __( 'Style title', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_title', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .call-action .call-text h2' => 'color: {{VALUE}};',
				],
				'default' => '#fff'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .call-action .call-text h2',
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
					'{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .apps_button p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .call-action .call-text p',
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
			'style',
			[
				'label' => esc_html__( 'Style', 'appart-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'style_01' => esc_html__('Style one ', 'appart-core'),
                    'style_02' => esc_html__('Style two ', 'appart-core'),
                ],
				'default' => 'style_01'
			]
		);
		$this->add_control(
			'sec_bg_image', [
				'label' => esc_html__( 'Background image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .call-action-area-six' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '128',
					'right' => '0',
					'bottom' => '105',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);
		$this->add_control(
			'bg_overlay', [
				'label' => _x( 'Background overlay type', 'Background Control', 'appart-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'gradient' => [
						'title' => 'Gradient',
						'icon' => 'fa fa-barcode'
					],
					'solid' => [
						'title' => 'Solid',
						'icon' => 'fa fa-paint-brush'
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
					'{{SELECTOR}} .call-action-area' => 'background-color: {{VALUE}};',
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
					'{{SELECTOR}} .call-action-area' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'of_type' => 'gradient',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$buttons = isset($settings['buttons']) ? $settings['buttons'] : '';
		$sec_bg = !empty($settings['sec_bg_image']['url']) ? $settings['sec_bg_image']['url'] : '';
        if($settings['style']=='style_01') {
		?>
		<section class="call-action-area  call-action-area-six">
            <?php if(!empty($settings['sec_bg_image']['url'])) : ?>
            <div class="video-bg" style="background: url('<?php echo esc_url($sec_bg) ?>') no-repeat scroll center center/cover;"> </div>
			<?php endif; ?>
            <div class="container">
				<div class="row call-action">
					<div class="col-md-7 col-sm-12">
						<div class="call-text">
							<div class="title-four title-w">
								<?php if(!empty($settings['title_text'])) : ?> <h2> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
							</div>
                            <div class="apps_button white">
                                <?php if(!empty($settings['subtitle_text'])) : ?>
                                    <?php echo wpautop($settings['subtitle_text']);
                                endif; ?>
                                <?php if(!empty($buttons)) {
                                    foreach ($buttons as $button) {
                                        $button_url = $button['btn_url'];
                                        $btn_target = $button_url['is_external'] ? 'target="_blank"' : '';
                                        $btn_bg_color = !empty($button['bg_color']) ? 'background-color:' . $button['bg_color'] . ';' : '';
                                        $btn_border_color = !empty($button['border_color']) ? 'border-color:' . $button['border_color'] . ';' : '';
                                        $icon = !empty($button['btn_icon']) ? $button['btn_icon'] : '';
                                        if(!empty($button['btn_name'])) : ?>
                                            <a href="<?php echo esc_url($button_url['url']) ?>" style="<?php echo $btn_bg_color.$btn_border_color ?>" <?php echo $btn_target; ?>><i class="<?php echo $icon; ?>"></i> <?php echo esc_html($button['btn_name']) ?> </a>
                                        <?php
                                        endif; ?>
                                        <?php
                                    }
                                } ?>
                            </div>
						</div>
					</div>
					<div class="col-sm-5">
                        <?php if(!empty($settings['the_featured_image']['url'])) : ?>
                            <div class="call-mobile-img">
                                <img class="img-fluid" src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="">
                            </div>
                        <?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
        }elseif($settings['style']=='style_02') {
            ?>
            <section class="new_call_action_area" style="background: linear-gradient(<?php echo $settings['gradient_angle']['size'].$settings['gradient_angle']['unit'].', '; echo $settings['color'].', '; echo $settings['color_b'] ?>), url(<?php echo esc_url($sec_bg) ?>) no-repeat;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="action_mobile wow fadeInUp">
                                <img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="f_img">
                            </div>
                        </div>
                        <div class="col-lg-8 d_flex">
                            <div class="n_call_action_content">
                                <?php if(!empty($settings['title_text'])) : ?>
                                    <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2>
                                <?php endif; ?>
                                <?php if(!empty($settings['subtitle_text'])) : ?>
                                    <div class="wow fadeInUp" data-wow-delay="300ms"><?php echo wpautop($settings['subtitle_text']); ?></div>
                                 <?php endif;?>
                                <?php if(!empty($buttons)) {
                                    foreach ($buttons as $button) {
                                        $button_url = $button['btn_url'];
                                        $btn_target = $button_url['is_external'] ? 'target="_blank"' : '';
                                        $btn_bg_color = !empty($button['bg_color']) ? 'background-color:' . $button['bg_color'] . ';' : '';
                                        $btn_border_color = !empty($button['border_color']) ? 'border-color:' . $button['border_color'] . ';' : '';
                                        $btn_color = !empty($button['color']) ? 'color:' . $button['color'] . ';' : '';
                                        $icon = !empty($button['btn_icon']) ? $button['btn_icon'] : '';
                                        if(!empty($button['btn_name'])) : ?>
                                            <a class="btn btn-normal apps-button wow fadeInUp" data-wow-delay="450ms" style="<?php echo $btn_bg_color.$btn_border_color.$btn_color; ?>" href="<?php echo esc_url($button_url['url']) ?>" <?php echo $btn_target; ?>>
                                                <i style="color: <?php echo $button['color'] ?>;" class="<?php echo $icon; ?>"></i> <?php echo wp_kses_post($button['btn_name']) ?>
                                            </a>
                                        <?php
                                        endif;
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
	}

}