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
class Appart_single_video extends Widget_Base {

	public function get_name() {
		return 'appart-single_video';
	}

	public function get_title() {
		return __( 'Single Video', 'appart-hero' );
	}

	public function get_icon() {
		return 'eicon-play';
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
				'default' => 'Discover The New App'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => 'Retarget past customers with second-chance offers and reach new audiences with geo-targeted campaigns during peak dining times using Forks’ push notifications.'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------ Video ------------------------------
		$this->start_controls_section(
			'video_atts', [
				'label' => __( 'Video', 'appart-core' ),
			]
		);
		$this->add_control(
			'video_url', [
				'label' => esc_html__( 'Video url', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
                'label_block' => true,
				'default' => 'https://www.youtube.com/embed/hgzzLIa-93c'
			]
		);
		$this->add_control(
			'video_poster', [
				'label' => esc_html__( 'Video poster', 'appart-core' ),
				'desc' => esc_html__( 'Upload here the video poster image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'play_btn_label', [
				'label' => esc_html__( 'Play button label', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Play the video'
			]
		);
		$this->end_controls_section(); // End title section



		/**
		 * Style Tab
		 * ------------------------------ Style Title ------------------------------
		 *
		 */
		$this->start_controls_section(
			'style_title',
			[
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
					'{{WRAPPER}} .video-left .video-inner p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .demo-video .app-video p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .video-left .video-inner p, {{WRAPPER}} .demo-video .app-video p',
			]
		);
		$this->end_controls_section();


		//------------------------------ Style Video ------------------------------
		$this->start_controls_section(
			'style_video', [
				'label' => __( 'Style video', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'style', [
                'label' => esc_html__( 'Style', 'appart-core' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'style_01' => esc_html__('Style one', 'appart-core'),
                    'style_02' => esc_html__('Style two', 'appart-core'),
                ],
                'default' => 'style_01'
            ]
        );
		$this->add_control(
			'video_overlay', [
				'label' => _x( 'Video overlay type', 'Background Control', 'appart-core' ),
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
				],
                'condition' => [
                    'style' =>  'style_01'
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
					'{{SELECTOR}}' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'video_overlay' => [ 'solid', 'gradient' ],
                    'style' =>  'style_01'
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
					'video_overlay' => [ 'gradient' ],
                    'style' =>  'style_01'
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
					'video_overlay' => [ 'gradient' ],
                    'style' => 'style_01'
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{SELECTOR}} .videoWrapper .videoPoster:after' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'of_type' => 'gradient',
			]
		);
		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings();
		$poster = !empty($settings['video_poster']['url']) ? 'style="background: url('.esc_url($settings['video_poster']['url']).') no-repeat scroll center 0;"' : '';
		if($settings['style']=='style_01') {
            ?>
            <section class="video_area">
                <div class="video-left">
                    <div class="video-inner">
                        <div class="title-four">
                            <?php if (!empty($settings['title_text'])) : ?>
                                <h2> <?php echo esc_html($settings['title_text']); ?> </h2>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($settings['subtitle_text'])) : ?><?php echo wpautop($settings['subtitle_text']); endif; ?>
                        <button class="play-btn"> <?php echo esc_html($settings['play_btn_label']); ?> </button>
                    </div>
                </div>
                <div class="video-right">
                    <div class="videoWrapper videoWrapper169 js-videoWrapper">
                        <iframe class="videoIframe js-videoIframe"
                                data-src="<?php echo esc_url($settings['video_url']) ?>?autoplay=1&amp; modestbranding=1&amp;rel=0&amp;hl=sv"></iframe>
                        <button class="videoPoster js-videoPoster" <?php echo $poster; ?>></button>
                    </div>
                </div>
            </section>
            <?php
        }

        elseif($settings['style']=='style_02') {
		    ?>
            <div class="row demo-video">
                <div class="col-md-6 col-sm-12 display-flex">
                    <div class="app-video">
                        <?php if (!empty($settings['title_text'])) : ?>
                        <div class="title-four">
                            <h2> <?php echo $settings['title_text']; ?> </h2>
                            <div class="br"></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($settings['subtitle_text'])) : ?><?php echo wpautop($settings['subtitle_text']); endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <?php if(!empty($settings['video_poster']['url'])) : ?>
                        <div class="video-promo wow fadeInRight">
                            <img src="<?php echo esc_url($settings['video_poster']['url']) ?>" alt="<?php echo esc_attr($settings['title_text']); ?>">
                            <a id="video-item" href="<?php echo esc_url($settings['video_url']) ?>"><i class="fa fa-play"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
	}

}