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
class Appart_download_sec2 extends Widget_Base {

	public function get_name() {
		return 'appart-download-sec2';
	}

	public function get_title() {
		return __( 'Download section two', 'appart-core' );
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
				'default' => 'We Support All Devices. So use the app anywher, anytime'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
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
						'label' => __( 'Button name', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'App Store',
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
		$this->end_controls_section(); // End title section

		/**
		 * Style Tab
		 * ------------------------------ Style Title ------------------------------
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
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .analysis_area h2' => 'color: {{VALUE}};',
				],
				'default' => '#1a264a'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_title',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .analysis_area h2',
			]
		);
		$this->end_controls_section();


		/* -------------------------- Style Title ---------------------------
		 */
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
					'{{WRAPPER}} .analysis_area p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .analysis_area p',
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
			'sec_bg_image', [
				'label' => esc_html__( 'Background shape image', 'appart-core' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('images/shape-bg.png', __FILE__)
                ]
			]
		);
		$this->add_control(
			'sec_padding', [
				'label' => __( 'Section padding', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .analysis_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
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
		$buttons = isset($settings['buttons']) ? $settings['buttons'] : '';
		if(!empty($settings['sec_bg_image']['url'])) :
            ?>
            <style>
                .analysis_area:before {
                    content: "";
                    background: url(<?php echo esc_url($settings['sec_bg_image']['url']) ?>) no-repeat scroll center bottom;
                    position: absolute;
                }
            </style>
            <?php
		endif;
		?>
        <section class="analysis_area <?php echo !empty($settings['subtitle_text']) ? 'has_subtitle' : ''; ?>">
            <div class="container">
	            <?php if(!empty($settings['title_text'])) : ?>
                    <h2> <?php echo esc_html($settings['title_text']); ?> </h2>
                <?php endif; ?>
                <?php if(!empty($settings['subtitle_text'])) : ?>
                    <p> <?php echo esc_html($settings['subtitle_text']); ?> </p>
                <?php endif; ?>
		        <?php if(!empty($settings['the_featured_image']['url'])) : ?>
                    <img src="<?php echo esc_url($settings['the_featured_image']['url']) ?>" alt="mockup">
		        <?php endif; ?>
                <div class="apps_button">
                    <?php
                    if(is_array($buttons)) {
                        foreach ($buttons as $button) {
	                        $button_url = $button['btn_url'];
	                        $btn_target = $button_url['is_external'] ? 'target="_blank"' : '';
	                        $icon = !empty($button['btn_icon']) ? $button['btn_icon'] : '';
                            if(!empty($button['btn_name'])) : ?>
                            <a href="<?php echo esc_url($button_url['url']) ?>" <?php echo $btn_target; ?>><i class="<?php echo $icon; ?>"></i> <?php echo esc_html($button['btn_name']) ?> </a>
                            <?php
                            endif;
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
		<?php
	}

	protected function _content_template() {
	}

}