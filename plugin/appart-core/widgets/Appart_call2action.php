<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use  Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
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
class Appart_call2action extends Widget_Base {

	public function get_name() {
		return 'appart-call2action';
	}

	public function get_title() {
		return __( 'Call to Action', 'appart-hero' );
	}

	public function get_icon() {
		return ' eicon-call-to-action';
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
				'description' => esc_html__( 'Use <br> tag for line breaking.', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Beautiful Design'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------ Button ------------------------------
		$this->start_controls_section(
			'button', [
				'label' => __( 'Button', 'appart-core' ),
			]
		);
		$this->add_control(
			'btn_label', [
				'label' => esc_html__( 'Button label', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Learn More',
			]
		);
		$this->add_control(
			'btn_url', [
				'label' => __( 'Button URL', 'appart-core' ),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '#'
				]
			]
		);
		$this->end_controls_section(); // End the Button

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
			'color_prefix', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title-four h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .about_content h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .features_content h2' => 'color: {{VALUE}};',
				],
				'default' => '#1a264a'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_prefix',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '
				    {{WRAPPER}} .features_content h2,
				    {{WRAPPER}} .about_content h2,
				    {{WRAPPER}} .title-four h2',
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
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .features_content p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .overview-details p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .about_content p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '
				    {{WRAPPER}} .features_content p,
				    {{WRAPPER}} .about_content p,
				    {{WRAPPER}} .title-four p,
				    {{WRAPPER}} .overview-details p',
			]
		);
		$this->end_controls_section();


		//------------------------------ Style button ------------------------------
		$this->start_controls_section(
			'style_button', [
				'label' => __( 'Style button', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'bg_color_btn', [
				'label' => __( 'Background color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .learn-btn-two' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'color_btn', [
				'label' => __( 'Text color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .learn-btn-two' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'is_box_shadow', [
                'label' => __( 'Box shadow', 'appart-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __( 'Show', 'appart-core' ),
                'label_off' => __( 'Hide', 'appart-core' ),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'box_shadow', [
                'label' => __( 'Apply Box Shadow', 'your-plugin' ),
                'type' => Controls_Manager::BOX_SHADOW,
                'default' => [
                    'color' => 'rgba(76, 132, 255, 0.2)',
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn_box_shadow' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                ],
                'condition' => [
                    'is_box_shadow' => 'yes'
                ]
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_btn',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .learn-btn-two',
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
			'style', [
				'label' => esc_html__( 'Style', 'appart-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'style_01' => esc_html__('Style one ', 'appart-core'),
                    'style_02' => esc_html__('Style two ', 'appart-core'),
                    'style_03' => esc_html__('Style three ', 'appart-core'),
                ],
				'default' => 'style_01'
			]
		);
        $this->add_control(
            'background_animation', [
                'label'     => esc_html__('Background animation?', 'appart'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'style' => 'style_02',
                ]
            ]
        );
		$this->add_control(
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .overview-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .about_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ex_features_one_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '150',
					'right' => '0',
					'bottom' => '120',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
        if($settings['style']=='style_01') { ?>
            <section class="overview-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-12 overview-details-left">
                            <?php if (!empty($settings['the_featured_image']['url'])) : ?>
                                <img src="<?php echo esc_url($settings['the_featured_image']['url']); ?>"
                                     class="img-responsive" alt="<?php echo esc_attr($settings['title_text']); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-12 overview-details-right">
                            <div class="overview-details">
                                <div class="title-four">
                                    <?php if (!empty($settings['title_text'])) : ?>
                                        <h2> <?php echo esc_html($settings['title_text']); ?> </h2>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($settings['subtitle_text'])) : ?><?php echo wpautop($settings['subtitle_text']); endif; ?>
                                <?php if (!empty($settings['btn_label'])) :
                                    $is_external = $settings['btn_url']['is_external'] == true ? 'target="_blank"' : '';
                                    $is_box_shadow = $settings['is_box_shadow'] == 'yes' ? 'btn_box_shadow' : '';
                                    ?>
                                    <a href="<?php echo esc_url($settings['btn_url']['url']) ?>" <?php echo $is_external; ?>
                                       class="btn learn-btn-two <?php echo $is_box_shadow; ?>">
                                        <?php echo esc_html($settings['btn_label']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
        elseif($settings['style']=='style_02') {
            ?>
            <section class="about_area">
                <?php if (true == $settings['background_animation']) : ?>
                    <!--Parallax-->
                    <ul class="memphis-parallax hidden-xs hidden-sm white_border">
                        <li data-parallax='{"x": -100, "y": 100}'>
                            <img class="br_shape" src="<?php echo plugin_dir_url(__FILE__) . 'images/line_01.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": -200, "y": 200}'>
                            <img class="br_shape" src="<?php echo plugin_dir_url(__FILE__) . 'images/line_02.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": -150, "y": 150}'>
                            <img class="br_shape" src="<?php echo plugin_dir_url(__FILE__) . 'images/line_03.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": 50, "y": -50}'>
                            <img class="br_shape" src="<?php echo plugin_dir_url(__FILE__) . 'images/line_04.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": -150, "y": 150}'><img
                                    src="<?php echo plugin_dir_url(__FILE__) . 'images/line_05.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": -100, "y": 100}'><img
                                    src="<?php echo plugin_dir_url(__FILE__) . 'images/line_06.png'; ?>" alt="f_img">
                        </li>
                        <li data-parallax='{"x": 50, "y": -50}'><img
                                    src="<?php echo plugin_dir_url(__FILE__) . 'images/shape.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 250, "y": -250}'><img
                                    src="<?php echo plugin_dir_url(__FILE__) . 'images/shape-1.png'; ?>" alt="f_img">
                        </li>
                    </ul>
                    <img class="shape wow fadeInRight"
                         src="<?php echo plugin_dir_url(__FILE__) . 'images/shape3.png'; ?>" alt="f_img">
                <?php endif; ?>
                <div class="container">
                    <div class="row row_reverse align_items_center">
                        <div class="col-lg-7">
                            <?php if(!empty($settings['the_featured_image']['url'])) : ?>
                                <div class="about_img text-right">
                                    <img src="<?php echo esc_url($settings['the_featured_image']['url']); ?>" alt="f_img">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-5">
                            <div class="about_content">
                                <?php if (!empty($settings['title_text'])) : ?>
                                    <h2 class="h_color f_36 wow fadeInUp"> <?php echo wp_kses_post($settings['title_text']); ?> </h2>
                                <?php endif; ?>
                                <?php if (!empty($settings['subtitle_text'])) : ?>
                                    <div class="wow fadeInUp"
                                         data-wow-delay="300ms"><?php echo wpautop($settings['subtitle_text']); ?></div>
                                <?php endif; ?>
                                <?php
                                if (!empty($settings['btn_label'])) :
                                    $is_external = $settings['btn_url']['is_external'] == true ? 'target="_blank"' : '';
                                    $is_box_shadow = $settings['is_box_shadow'] == 'yes' ? 'btn_box_shadow' : '';
                                    ?>
                                    <a href="<?php echo esc_url($settings['btn_url']['url']) ?>" <?php echo $is_external ?>
                                       class="n_banner_btn wow fadeInUp <?php echo $is_box_shadow; ?>"
                                       data-wow-delay="450ms">
                                        <?php echo esc_html($settings['btn_label']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }

        elseif($settings['style']=='style_03') {
            ?>
            <section class="ex_features_one_area ex-featured">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-7 features_content">
                            <?php if (!empty($settings['title_text'])) : ?>
                                <h2 class="title_three color-b"> <?php echo esc_html($settings['title_text']); ?> </h2>
                            <?php endif; ?>
                            <?php if (!empty($settings['subtitle_text'])) : ?>
                                <?php echo wpautop($settings['subtitle_text']);
                            endif; ?>
                            <?php if (!empty($settings['btn_label'])) :
                                $is_external = $settings['btn_url']['is_external'] == true ? 'target="_blank"' : '';
                                $is_box_shadow = $settings['is_box_shadow'] == 'yes' ? 'btn_box_shadow' : '';
                                ?>
                                <a href="<?php echo esc_url($settings['btn_url']['url']) ?>" <?php echo $is_external; ?>
                                   class="btn learn_btn <?php echo $is_box_shadow; ?>">
                                    <?php echo esc_html($settings['btn_label']) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-5 offset-lg-1 col-md-5">
                            <div class="f_img text-center">
                                <?php if (!empty($settings['the_featured_image']['url'])) : ?>
                                    <img src="<?php echo esc_url($settings['the_featured_image']['url']); ?>"
                                         class="img-responsive" alt="<?php echo esc_attr($settings['title_text']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
	}
}