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
class Appart_features extends Widget_Base {

	public function get_name() {
		return 'appart-features';
	}

	public function get_title() {
		return __( 'Features section', 'appart-hero' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
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
			'title_text', [
				'label' => esc_html__( 'Title text', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Exclusive Features'
			]
		);

		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => 'We’re a team of creative and make amazing site in ecommerce from Unite States. We love colour pastel, highlight and simple, its make our design look so awesome'
			]
		);

		$this->add_control(
			'title_sec_margin', [
				'label' => esc_html__( 'Margin', 'appart-core' ),
				'description' => esc_html__( 'Margin around title section', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .title-four' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '100',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
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
				'label' => __( 'Features', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Feature name', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Awesome design'
					],
					[
						'name' => 'desc',
						'label' => __( 'Feature description', 'appart-core' ),
						'type' => Controls_Manager::TEXTAREA,
                        'default' => 'Consectetur adipiscing elit donec tempus pellentesque dui.'
					],
					[
                        'name' => 'icon_type',
						'label' => __( 'Icon type', 'appart-core' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'font_icon' => __( 'Font icon', 'appart-core' ),
							'image_icon' => __( 'Image icon', 'appart-core' ),
						],
                        'default' => 'font_icon'
					],
					[
                        'name' => 'font_icon',
                        'label' => __( 'Social icon', 'appart-core' ),
                        'type' => Controls_Manager::ICON,
                        'options' => appart_thimify_icons(),
                        'include' => appart_thimify_include_icons(),
                        'default' => 'ti-ruler-pencil',
                        'condition' => [
                            'icon_type' => 'font_icon'
                        ]
				    ],
					[
                        'name' => 'icon_color',
                        'label' => __( 'Icon Color', 'appart-core' ),
                        'desc' => __( 'Leave the field blank to use the accent color as icon the color.', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'scheme' => [
                            'type' => Color::get_type(),
                            'value' => Color::COLOR_1,
                        ],
                        'condition' => [
                            'icon_type' => 'font_icon'
                        ]
                    ],
					[
						'name' => 'image_icon',
						'label' => __( 'Image icon', 'appart-core' ),
						'type' => Controls_Manager::MEDIA,
						'condition' => [
							'icon_type' => 'image_icon'
						]
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
				'label' => __( 'Style Section Title', 'appart-core' ),
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
				],
                'default' => '#1a264a'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_prefix',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .title-four h2',
			]
		);
		$this->end_controls_section();


		//------------------------------ Style subtitle ------------------------------
		$this->start_controls_section(
			'style_subtitle',
			[
				'label' => __( 'Style Subtitle', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_suffix', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
				],
                'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_subtitle',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .title-four p',
			]
		);
        $this->add_control(
            'margin_around_subtitle', [
                'label' => __( 'Margin around the subtitle', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .title-four p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '15',
                    'bottom' => '50',
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
            ]
        );
		$this->end_controls_section();

        // ------------------------------------ Style Feature List
        $this->start_controls_section(
            'style_feature_list',
            [
                'label' => __( 'Style Feature List', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'column', [
                'label' => esc_html__( 'Show in column', 'appart-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '6' => 'Two',
                    '4' => 'Three',
                    '3' => 'Four',
                    '2' => 'Six',
                ]
            ]
        );
        $this->add_control(
            'feature_item_color', [
                'label' => __( 'Title Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .features-area-five .feature-five-item h2' => 'color: {{VALUE}};',
                ],
                'default' => '#404040'
            ]
        );
        $this->add_control(
            'feature_icon_size', [
                'label' => __( 'Icon size', 'appart-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => __( 'Title Typography', 'appart-core' ),
                'name' => 'feature_item_title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} h2',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => __( 'Subtitle Typography', 'appart-core' ),
                'name' => 'feature_item_desc_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} p',
            ]
        );
        $this->add_control(
            'feature_item_align', [
                'label' => __( 'Alignment', 'chaoz-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left align', 'chaoz-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'left_icon'    => [
                        'title' => __( 'Left icon', 'chaoz-core' ),
                        'icon' => 'eicon-post-list',
                    ],
                    'center' => [
                        'title' => __( 'Center align', 'chaoz-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                ],
                'default' => 'center'
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
					'{{WRAPPER}} .features-area-six' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
			]
		);
		$this->add_control(
			'is_circle', [
				'label' => __( 'Show/hide circles', 'appart-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'appart-core' ),
				'label_off' => __( 'Hide', 'appart-core' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'left_circle_color', [
				'label' => __( 'Left circle color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .features-area-five .f-round.circle-one' => 'background: {{VALUE}};',
				],
				'default' => '#9ce7c0',
                'condition' => [
                    'is_circle' => 'yes'
                ]
			]
		);
		$this->add_control(
			'left_circle_size', [
				'label' => __( 'Left circle size', 'appart-core' ),
				'description' => __( 'Left circle size in pixel (px)', 'appart-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '69',
				'condition' => [
					'is_circle' => 'yes'
				]
			]
		);
		$this->add_control(
			'right_circle_color', [
				'label' => __( 'Right circle color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .features-area-five .f-round.circle-two' => 'background: {{VALUE}};',
				],
				'default' => '#ffe4f1',
				'condition' => [
					'is_circle' => 'yes'
				]
			]
		);
		$this->add_control(
			'right_circle_size', [
				'label' => __( 'Right circle size', 'appart-core' ),
				'description' => __( 'Right circle size in pixel (px)', 'appart-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '32',
				'condition' => [
					'is_circle' => 'yes'
				]
			]
		);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$features = isset($settings['features']) ? $settings['features'] : '';
		?>
        <section class="features-area-five features-area-six">
            <?php if($settings['is_circle']=='yes') : ?>
            <div class="f-round circle-one" style="height: <?php echo esc_attr($settings['left_circle_size']); ?>px; width: <?php echo esc_attr($settings['left_circle_size']); ?>px;"></div>
            <div class="f-round circle-two" style="height: <?php echo esc_attr($settings['right_circle_size']); ?>px; width: <?php echo esc_attr($settings['right_circle_size']); ?>px;"></div>
            <?php endif; ?>
            <div class="container">
                <div class="title-four text-center">
                    <?php if(!empty($settings['title_text'])) : ?> <h2> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
                    <?php if(!empty($settings['subtitle_text'])) : ?> <?php echo wpautop($settings['subtitle_text']); endif; ?>
                </div>
                <div class="row <?php echo ($settings['feature_item_align']=='left_icon') ? 'more_features exclusive_features-two' : '' ?>">
                    <?php
                    if($features) {
                    foreach ($features as $feature) {
                        ?>
                        <div class="col-md-<?php echo esc_attr($settings['column']) ?> col-sm-6 <?php echo ($settings['feature_item_align']!='left_icon') ? 'feature-five-item' : ''; echo $settings['feature_item_align']=='left' ? ' align_left' : ''; ?>">
                            <?php
                            if($settings['feature_item_align']=='left_icon') {
                                ?>
                                <div class="media">
                                    <div class="media-left">
                                        <?php
                                        if ($feature['icon_type'] == 'font_icon') : ?>
                                                <i class="<?php echo $feature['font_icon']; ?>" style="color: <?php echo $feature['icon_color'] ?>;"></i>
                                        <?php else: ?>
                                            <img src="<?php echo $feature['image_icon']['url'] ?>" alt="<?php echo esc_html($feature['title']) ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="media-body">
                                        <h2> <?php echo esc_html($feature['title']) ?> </h2>
                                        <?php echo (!empty($feature['desc'])) ? '<p>'.$feature['desc'].'</p>' : ''; ?>
                                    </div>
                                </div>
                                <?php
                            }else {
                                if ($feature['icon_type'] == 'font_icon') : ?>
                                    <div class="round">
                                        <i class="<?php echo $feature['font_icon']; ?>" style="color: <?php echo $feature['icon_color'] ?>;"></i>
                                    </div>
                                <?php else: ?>
                                    <img src="<?php echo $feature['image_icon']['url'] ?>" alt="<?php echo esc_html($feature['title']) ?>">
                                <?php endif; ?>
                                <h2> <?php echo esc_html($feature['title']) ?> </h2>
                                <?php echo (!empty($feature['desc'])) ? '<p>'.$feature['desc'].'</p>' : ''; ?>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }}
                    ?>
                </div>
            </div>
        </section>
		<?php
	}
}
