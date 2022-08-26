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
class Appart_pricing_table extends Widget_Base {

	public function get_name() {
		return 'appart-pricing-table';
	}

	public function get_title() {
		return __( 'Pricing table', 'appart-hero' );
	}

	public function get_icon() {
		return ' eicon-price-table';
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
				'default' => 'Pricing Table'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => '<p> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut<br> fugit, sed consequuntur magni dolores ratione voluptatem sequi nesciunt. </p>'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------ Feature list ------------------------------
		$this->start_controls_section(
			'pricing_table', [
				'label' => __( 'Pricing Table', 'appart-core' ),
			]
		);
		$this->add_control(
			'tables', [
				'label' => __( 'Pricing Tables', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Table name', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Free'
					],
                    [
                        'name'      => 'price_style_type',
                        'label'     => esc_html__('Select Style', 'appart-core'),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => [
                            'style_one'     => esc_html__('Style One', 'appart-core'),
                            'style_two'    => esc_html__('Style Two', 'appart-core'),
                        ]
                    ],
                    [
                        'name'       => 'sub_title',
                        'label'      => esc_html__('Table Sub title', 'appart-core'),
                        'type'     => Controls_Manager::TEXT,
                        'condition'  => [
                            'price_style_type' => 'style_two',
                        ]

                    ],
					[
                        'name'      => 'icon_type',
                        'label'     => esc_html__('Icon Type', 'appart-core'),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => [
                                'font_icon'     => esc_html__('Font Icon', 'appart-core'),
                                'image_icon'    => esc_html__('Image Icon', 'appart-core'),
                        ],
                        'condition'  => [
                            'price_style_type' => 'style_two',
                        ]

                    ],
                    [
                            'name'       => 'font_icon',
                            'label'      => esc_html__('Social Icon', 'appart-core'),
                            'type'       => Controls_Manager::ICON,
                            'option'     => appart_thimify_icons(),
                            'include'    => appart_thimify_include_icons(),
                            'default'    => 'ti-ruler-pencil',
                            'condition'  => [
                                 'icon_type' => 'font_icon',
                                'price_style_type' => 'style_two',
                            ],

                    ],
                    [
                        'name' => 'image_icon',
                        'label' => __( 'Image icon', 'appart-core' ),
                        'type' => Controls_Manager::MEDIA,
                        'condition' => [
                            'icon_type' => 'image_icon',
                            'price_style_type' => 'style_two',
                        ],

                    ],
					[
						'name' => 'currency',
						'label' => __( 'Currency', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => '$',
					],
					[
						'name' => 'price',
						'label' => __( 'Price', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => '0',
					],
					[
						'name' => 'duration',
						'label' => __( 'Duration', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'Lifetime',
                        'condition'  => [
                            'price_style_type' => 'style_one',
                        ]
					],
					[
						'name' => 'list_items',
						'label' => __( 'List items', 'appart-core' ),
						'type' => Controls_Manager::TEXTAREA,
						'label_block' => true,
						'default' => '<li>One User</li>
                                      <li>1000 ui elements</li>
                                      <li>E-mail support</li>',
					],
					[
						'name' => 'try_btn_label',
						'label' => __( 'Try button label', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'Try Now',
						'label_block' => true
					],
					[
						'name' => 'try_btn_url',
						'label' => __( 'Try button URL', 'appart-core' ),
						'type' => Controls_Manager::URL,
						'default' => [
							'url' => '#',
							'is_external' => '',
						],
						'show_external' => true,
					],
					[
						'name' => 'purchase_btn_label',
						'label' => __( 'Purchase button label', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'Purchase',
                        'label_block' => true
					],
					[
						'name' => 'purchase_btn_url',
						'label' => __( 'Purchase button URL', 'appart-core' ),
						'type' => Controls_Manager::URL,
						'default' => [
							'url' => '#',
							'is_external' => '',
						],
						'show_external' => true,
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
					'{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .title-four p',
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
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pricing-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .priceing_area_two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '104',
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
		$tables = isset($settings['tables']) ? $settings['tables'] : '';
        if($settings['style']=='style_01') {
            ?>
            <section class="pricing-area" id="price">
                <div class="container">
                    <div class="title-four text-center">
                        <?php if(!empty($settings['title_text'])) : ?> <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
                        <?php if(!empty($settings['subtitle_text'])) : ?> <?php echo wpautop($settings['subtitle_text']); endif; ?>
                    </div>

                    <div class="tab-content priceing-tab">
                        <div class="row">
                            <?php if($tables) {
                                foreach ( $tables as $table ) {
                                    $try_btn = $table['try_btn_url'];
                                    $try_btn_target = $try_btn['is_external'] ? 'target="_blank"' : '';
                                    $purchase_btn = $table['purchase_btn_url'];
                                    $purchase_btn_target = $purchase_btn['is_external'] ? 'target="_blank"' : '';
                                    ?>
                                    <div class="col-md-4 col-sm-6 price wow fadeInUp" data-wow-dealy="150ms">
                                        <div class="pricing-box">
                                            <div class="pricing-header">
                                                <h2><?php echo esc_html($table['title']) ?></h2>
                                                <h3 class="packeg_typ"><span><?php echo esc_html($table['currency']) ?></span><?php echo esc_html($table['price']) ?><small> <?php echo esc_html($table['duration']) ?></small></h3>
                                            </div>
                                            <ul class="list-unstyled plan-lists">
                                                <?php echo $table['list_items']; ?>
                                            </ul>
                                            <?php if(!empty($table['try_btn_label'])) : ?>
                                                <a href="<?php echo esc_url($try_btn['url']); ?>" class="try" <?php echo esc_attr($try_btn_target); ?>>
                                                    <?php echo esc_html($table['try_btn_label']) ?>
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!empty($table['purchase_btn_label'])) : ?>
                                                <a href="<?php echo esc_url($purchase_btn['url']); ?>" class="purchase-btn" <?php echo $purchase_btn_target; ?>>
                                                    <?php echo esc_html($table['purchase_btn_label']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
        
        elseif($settings['style']=='style_02') {
            ?>
            <section class="priceing_area_two">
                <div class="container">
                    <div class="title-four h_color text-center">
                        <?php if(!empty($settings['title_text'])) : ?> <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
                        <?php if(!empty($settings['subtitle_text'])) : ?>
                            <?php echo '<p class="p_color wow fadeInUp" data-wow-delay="200ms">'.$settings['subtitle_text']."</p>";
                        endif; ?>
                    </div>
                    <div class="row">
                        <?php if($tables) {
                            foreach ( $tables as $table ) {
                                $try_btn = $table['try_btn_url'];
                                $try_btn_target = $try_btn['is_external'] ? 'target="_blank"' : '';
                                $purchase_btn = $table['purchase_btn_url'];
                                $purchase_btn_target = $purchase_btn['is_external'] ? 'target="_blank"' : '';
                                ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="price_box_two text-center wow fadeInLeft" data-wow-delay="250ms">
                                        <h5><?php echo esc_html($table['title']) ?></h5>
                                        <p><?php echo esc_html($table['sub_title']) ?></p>
                                        <div class="price_icon">
                                            <?php if(!empty($table['image_icon']['url'])){?>
                                                <img src="<?php echo esc_url($table['image_icon']['url']); ?>" alt="">
                                            <?php }else{?>
                                                <div class="price-icon">
                                                    <i class="<?php echo $table['font_icon']; ?>"></i>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <h2 class="rate"><?php echo esc_html($table['currency']) ?><?php echo esc_html($table['price'])?></h2>
                                        <ul class="list-unstyled plan-lists">
                                            <?php echo $table['list_items']; ?>
                                        </ul>
                                        <?php if(!empty($table['try_btn_label'])) : ?>
                                            <a href="<?php echo esc_url($try_btn['url']); ?>" class="try" <?php echo esc_attr($try_btn_target); ?>>
                                                <?php echo esc_html($table['try_btn_label']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(!empty($table['purchase_btn_label'])) : ?>
                                            <a href="<?php echo esc_url($purchase_btn['url']); ?>" class="purchase_btn_two" <?php echo $purchase_btn_target; ?>>
                                                <?php echo esc_html($table['purchase_btn_label']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
            </section>
            <?php
        }
	}

	protected function _content_template() {
	}

}