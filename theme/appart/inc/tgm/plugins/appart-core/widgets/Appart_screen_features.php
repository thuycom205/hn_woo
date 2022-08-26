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
class Appart_screen_features extends Widget_Base {

	public function get_name() {
		return 'appart-screen-features';
	}

	public function get_title() {
		return __( 'Screen Features', 'appart-hero' );
	}

	public function get_icon() {
		return ' eicon-posts-group';
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
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
			]
		);
		$this->end_controls_section(); // End title section

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
            'featured_image_margin', [
                'label' => __( 'Padding', 'appart-core' ),
                'description' => __( 'Padding around the featured image', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .features_area .f_img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .b_screen_img img .f_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label' => __( 'Features list', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Feature name', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Enterprise Reporting with Tiered Access'
					],
					[
						'name' => 'url',
						'label' => __( 'URL', 'appart-core' ),
						'description' => __( 'Will apply on Style 01 and Style 02', 'appart-core' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'default' => [
                            'url' => '#'
                        ]
					],
					[
						'name' => 'desc',
						'label' => __( 'Feature description', 'appart-core' ),
						'type' => Controls_Manager::TEXTAREA,
						'label_block' => true,
						'default' => 'Hollywood hype would have us believe that a hypnotist can control and direct our actions, and '
					],
					[
						'name' => 'icon_type',
						'label' => __( 'Icon type', 'appart-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'font_icon',
						'options' => [
							'font_icon' => __( 'Font icon', 'appart-core' ),
							'image_icon' => __( 'Image icon', 'appart-core' ),
						],
					],
					[
						'name' => 'font_icon',
						'label' => __( 'Icon', 'appart-core' ),
						'type' => Controls_Manager::ICON,
						'options' => appart_thimify_icons(),
						'include' => appart_thimify_include_icons(),
						'default' => 'ti-pie-chart',
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
					'{{WRAPPER}} .title-four h2' => 'color: {{VALUE}};',
				],
				'default' => '#1a264a'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_prefix',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
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
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .features_content_three p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '
				    {{WRAPPER}} .title-four p,
				    {{WRAPPER}} .features_content_three p',
			]
		);
		$this->end_controls_section();


		//------------------------------ Style Section ------------------------------
		$this->start_controls_section(
			'style_feature_list', [
				'label' => __( 'Style Feature List', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => 'style_01'
                ]
			]
		);
        $this->add_control(
            'color_feature_title', [
                'label' => __( 'Title Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .features_content_three .media .media-body' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Title typography',
                'name' => 'typography_feature_item',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .features_content_three .media .media-body',
                'condition' => [
                    'style' => 'style_01'
                ]
            ]
        );
        $this->add_control(
            'feature_item_margin', [
                'label' => __( 'Margin', 'appart-core' ),
                'description' => __( 'Margin around the each feature list.', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .scree_feature_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '40',
                    'left' => '0',
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
                'condition' => [
                    'style' => 'style_01'
                ]
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
			'is_revers_column', [
				'label' => __( 'Reverse column', 'appart-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'appart-core' ),
				'label_off' => __( 'No', 'appart-core' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .features_area_pad' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '15',
					'right' => '0',
					'bottom' => '120',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);
		$this->add_control(
			'is_bg_shape', [
				'label' => __( 'Show/hide background shape', 'appart-core' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Show', 'appart-core' ),
				'label_off' => __( 'Hide', 'appart-core' ),
				'return_value' => 'yes',
                'condition' => [
                    'style' => ['style_01']
                ]
			]
		);
        $this->add_control(
            'bg_shape_color', [
                'label' => __( 'Background shape color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0edff',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .shape:before' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['style_01']
                ]
            ]
        );
		$this->add_control(
            'animation_bg', [
                'label'     => esc_html__('Show/hide background animation', 'appart-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__('Show', 'appart-core'),
                'label_off' => esc_html__('Hide', 'appart-core'),
                'return_value'  => 'yes',
                'condition' => [
                    'style' => ['style_02', 'style_03']
                ]
            ]
        );
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$features = isset($settings['features']) ? $settings['features'] : '';
        if($settings['style'] == 'style_01') { ?>
            <section class="features_area features_area_pad feature-bg <?php echo $settings['is_bg_shape']=='yes' ? 'shape' : ''; ?>">
                <div class="container">
                    <div class="row <?php echo $settings['is_revers_column']=='yes' ? 'reverse_column' : ''; ?>">
                        <div class="col-lg-<?php echo $settings['is_revers_column']=='yes' ? '6' : '5'; ?> col-sm-12 features_content_three">
                            <div class="title-four">
                                <?php if(!empty($settings['title_text'])) : ?>
                                    <h2> <?php echo esc_html($settings['title_text']); ?></h2>
                                <?php endif; ?>
                            </div>
                            <?php
                            if(!empty($settings['subtitle_text'])) : ?>
                                <?php echo wpautop($settings['subtitle_text']);
                            endif;

                            if( $features ) {
                            foreach ( $features as $feature ) {
                                ?>
                                <div class="scree_feature_item">
                                    <div class="media">
                                        <div class="media-left">
                                            <?php
                                            if( $feature['icon_type'] == 'font_icon' ) {
                                                echo '<div class="icon">';
                                                echo "<i class='{$feature['font_icon']}'></i>";
                                                echo '</div>';
                                            } else {
                                                echo "<img src='{$feature['image_icon']['url']}' alt='{$feature['title']}'>";
                                            }
                                            ?>
                                        </div>
                                        <div class="media-body">
                                            <?php
                                            if( !empty($feature['title']) ) :
                                                if( !empty($feature['url']['url']) ) : ?>
                                                <a href="<?php echo esc_url($feature['url']['url']) ?>" <?php appart_is_external($feature['url']); appart_is_nofollow($feature['url']) ?>>
                                                    <?php endif; ?>
                                                    <h3> <?php echo esc_html($feature['title']) ?> </h3>
                                                <?php if( !empty($feature['url']['url']) ) : ?>
                                                </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(!empty($feature['desc'])) : ?>
                                        <p><?php echo esc_html($feature['desc']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php
                            }}
                            ?>
                        </div>
                        <?php if(!empty($settings['the_featured_image']['url'])) : ?>
                            <div class="col-lg-<?php echo $settings['is_revers_column']=='yes' ? '6' : '7'; ?> col-sm-12 f_img text-right">
                                <img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="featured">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php
       }elseif($settings['style']=='style_02') {
            ?>
            <section class="best_screen_features_area features_area_pad">
                <?php if('yes' === $settings['is_bg_shape']) : ?>
                <svg xmlns="http://www.w3.org/2000/svg">
                    <path fill="<?php echo esc_attr($settings['bg_shape_color']);?>" id="down_bg_copy_2" data-name="down / bg copy 2" class="cls-1" d="M444.936,252.606c-148.312,0-305.161-29.63-444.936-80.214V0H1920V12S808.194,234.074,444.936,252.606Z"/>
                </svg>
                <?php endif; ?>
                <?php if('yes' === $settings['animation_bg']) : ?>
                    <!--Parallax-->
                    <ul class="memphis-parallax hidden-xs hidden-sm white_border">
                        <li data-parallax='{"x": -00, "y": 100}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/f_l_01.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 200, "y": 200}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/f_l_02.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 150, "y": 150}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/f_l_03.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 50, "y": 50}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/f_l_05.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 150, "y": 150}'><img src="<?php echo plugin_dir_url(__FILE__).'images/f_l_06.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 100, "y": 100}'><img src="<?php echo plugin_dir_url(__FILE__).'images/f_l_07.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 50, "y": 50}'><img src="<?php echo plugin_dir_url(__FILE__).'images/f_l_08.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"y": 250}'><img src="<?php echo plugin_dir_url(__FILE__).'images/f_l_09.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 250, "y": 250}'><img src="<?php echo plugin_dir_url(__FILE__).'images/f_l_10.png'; ?>" alt="f_img"></li>
                        <li data-parallax='{"x": 150, "y": 150}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/f_l_04.png'; ?>" alt="f_img"></li>
                    </ul>
                <?php endif; ?>
                <div class="container">
                    <div class="title-four h_color text-center mb_0">
                        <?php if(!empty($settings['title_text'])) : ?> <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
                        <?php if(!empty($settings['subtitle_text'])) : ?> 
                            <?php echo '<p class="p_color wow fadeInUp" data-wow-delay="200ms">'.$settings['subtitle_text']."</p>"; 
                        endif; ?>
                    </div>
                    
                    <div class="row <?php echo $settings['is_revers_column']=='yes' ? 'reverse_column' : ''; ?>">
                        <?php if(!empty($settings['the_featured_image']['url'])) : ?>
                        <div class="col-lg-4">
                              <div class="b_screen_img wow fadeInUp">
                                  <img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="featured">
                              </div>
                        </div>
                        <?php endif;?>
                        <div class="col-lg-<?php echo !empty($settings['the_featured_image']['url']) ? '8' : '12'; ?>">
                            <div class="row b_features_info">
                                <?php
                                if($features) {
                                    foreach ($features as $feature) {
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="b_features_item wow fadeInUp">
                                                <div class="b_features_icon">
                                                    <?php
                                                        if($feature['icon_type'] == 'font_icon'){
                                                            echo '<div class="icon">';
                                                            echo "<i class='{$feature['font_icon']}'></i>";
                                                            echo "<span class=\"hover_color\"></span>";
                                                            echo '</div>';
                                                        } else {
                                                           echo "<img src='{$feature['image_icon']['url']}' alt='{$feature['title']}'>";
                                                        }
                                                    ?>
                                                </div>
                                                <?php if(!empty($feature['title'])) : ?>
                                                    <?php if( !empty($feature['url']['url']) ) : ?>
                                                    <a href="<?php echo esc_url($feature['url']['url']) ?>" <?php appart_is_external($feature['url']); appart_is_nofollow($feature['url']) ?>>
                                                        <?php endif; ?>
                                                        <h3> <?php echo esc_html($feature['title']) ?> </h3>
                                                        <?php if( !empty($feature['url']['url']) ) : ?>
                                                    </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if(!empty($feature['desc'])) : ?>
                                                <p><?php echo esc_html($feature['desc']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
         }
         elseif($settings['style']=='style_03') {
            ?>
            <section class="faq_solution_area features_area_pad">
                <?php if('yes' === $settings['animation_bg']) : ?>
                <!--Parallax-->
                <ul class="memphis-parallax hidden-xs hidden-sm white_border">
                    <li data-parallax='{"x": -100, "y": 100}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-1.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": -200, "y": 200}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-2.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": -150, "y": 150}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-3.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": 50, "y": -50}'><img class="br_shape" src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-4.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": -150, "y": 150}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-5.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": -100, "y": 100}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-6.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": 50, "y": -50}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-7.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": 250, "y": -250}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-8.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"x": 150, "y": -150}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-9.png'; ?>" alt="f_img"></li>
                    <li data-parallax='{"y": -180}'><img src="<?php echo plugin_dir_url(__FILE__).'images/fq_line-10.png'; ?>" alt="f_img"></li>
                </ul>
                <?php endif;?>
                <div class="container">
                    <div class="title-four h_color text-center">
                        <?php if(!empty($settings['title_text'])) : ?> <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2> <?php endif; ?>
                        <?php if(!empty($settings['subtitle_text'])) : ?> 
                            <?php echo '<p class="p_color wow fadeInUp" data-wow-delay="200ms">'.$settings['subtitle_text']."</p>"; 
                        endif; ?>
                    </div>
                    <div class="row <?php echo $settings['is_revers_column']=='yes' ? 'reverse_column' : ''; ?>">
                        <div class="col-md-<?php echo !empty($settings['the_featured_image']['url']) ? '6' : '12'; ?> d_flex">
                            <div id="accordion" class="faq_accordian_two">
                                <?php
                                if(is_array($features)) {
                                $count = 0;
                                $ac     = 1;
                                foreach ($features as $feature) {
                                    ?>
                                    <div class="card wow fadeInUp <?php if($count == 0){echo esc_attr('active');}?>">
                                        <div class="card-header" id="heading<?php echo esc_attr($ac); ?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo esc_attr($count);?>" aria-expanded="true" aria-controls="collapse<?php echo esc_attr($count);?>">
                                                    <?php
                                                    if($feature['icon_type'] == 'font_icon'){
                                                        echo "<i class='{$feature['font_icon']}'></i>";
                                                    }else{
                                                        echo "<img src='{$feature['image_icon']['url']}' alt='{$feature['title']}'>";
                                                    }
                                                    if(!empty($feature['title'])) {
                                                        echo esc_html($feature['title']);
                                                    }
                                                    ?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo esc_attr($count);?>" class="collapse <?php if($count == 0){echo esc_attr('show');}?>" aria-labelledby="heading<?php echo esc_attr($ac); ?>" data-parent="#accordion">
                                            <?php if(!empty($feature['desc'])) : ?>
                                            <div class="card-body">
                                                <p><?php echo esc_html($feature['desc']); ?></p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $ac++;
                                    $count++;
                                }}
                                ?>
                            </div>
                        </div>
                        <?php
                        if(!empty($settings['the_featured_image']['url'])) : ?>
                            <div class="col-md-6">
                                <div class="faq_image_mockup wow fadeInUp" data-wow-delay="200ms">
                                    <img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="featured">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php
         }
	}

}